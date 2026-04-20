<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Mail;
use App\Mail\ConfirmMail;
use Barryvdh\DomPDF\Facade as PDF;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::query();
        
        // Filter by jenis pengaduan (kategori)
        if ($request->filled('jenis_pengaduan')) {
            $query->where('jenis_pengaduan', $request->jenis_pengaduan);
        }
        
        // Filter by nomor induk (student)
        if ($request->filled('nomor_induk')) {
            $query->where('nomor_induk', 'like', '%' . $request->nomor_induk . '%');
        }
        
        // Filter by date
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_laporan', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_laporan', '<=', $request->tanggal_sampai);
        }
        
        // Filter by month and year
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereYear('tanggal_laporan', $request->tahun)
                  ->whereMonth('tanggal_laporan', $request->bulan);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $pengaduan = $query->latest()->get();
        
        $data = [
            'title' => 'Pengaduan',
            'pengaduan' => $pengaduan,
            'jenis_list' => ['pengaduan', 'aspirasi'],
            'status_list' => ['pending', 'sukses', 'ditolak'],
            'bulan_list' => [
                '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
            ]
        ];
        return view('backend.pages.pengaduan.index', $data);
    }

    public function detail($id)
    {
        $_dec = Crypt::decrypt($id);
        $pengaduan = Pengaduan::findOrfail($_dec);
        
        // Authorization Check: User hanya bisa lihat laporan mereka sendiri
        if (Auth::user()->role === 'user' && $pengaduan->nomor_induk !== Auth::user()->nomor_induk) {
            abort(403, 'Anda tidak memiliki akses untuk mengakses halaman ini.');
        }
        
        $data = [
            'title' => 'Detail Pengaduan',
            'laporan' => $pengaduan,
        ];
        return view('backend.pages.pengaduan.detail', $data);
    }

    // public function update(Request $req, $id)
    // {
    //     Pengaduan::where(['id' => $id])->update([
    //         'status' => $req->status,
    //     ]);
    //     return redirect(route('pengaduan'))->with('status', 'Data Pengaduan Berhasil Diubah');
    // }

    public function tanggapan($id)
    {
        $_dec = Crypt::decrypt($id);
        $pengaduan = Pengaduan::findOrfail($_dec);
        
        // Authorization Check: Only admin/petugas can respond
        if (!in_array(Auth::user()->role, ['admin', 'petugas'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengakses halaman ini.');
        }
        
        $data = [
            'title' => 'Tanggapan',
            'pengaduan' => $pengaduan,
        ];
        return view('backend.pages.tanggapan', $data);
    }

    public function storeTanggapan(Request $req, $id)
    {
        $req->validate([
            'tanggapan' => 'required',
            'status' => 'required'
        ]);

        $pengaduan = Pengaduan::findOrfail($id);
        $pengaduan->update([
            'status' => $req->status,
        ]);

        Tanggapan::create([
            'pengaduan_id' => $id,
            'user_id' => Auth::User()->id,
            'tanggapan' => $req->tanggapan
        ]);
        
        // Send mail to user with error handling
        try {
            Mail::to($pengaduan->email)->send(new ConfirmMail($pengaduan));
        } catch (\Exception $e) {
            \Log::warning('Email pengaduan gagal dikirim ke ' . $pengaduan->email . ': ' . $e->getMessage());
        }
        
        return redirect(route('pengaduan'))->with('status', 'Data Pengaduan Berhasil Ditanggapi');
    }

    public function createPDF()
    {
        $pengaduan = Pengaduan::all();
        $pdf = PDF::loadView('backend.pages.pengaduan.pengaduan_pdf', ['pengaduan' => $pengaduan]);
        return $pdf->download('laporan-pengaduan.pdf');
    }
}
