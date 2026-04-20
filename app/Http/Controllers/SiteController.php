<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Auth;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class SiteController extends Controller
{
    // Allowed MIME types for file uploads
    private $allowedMimes = [
        'application/pdf',
        'image/jpeg',
        'image/png',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
    
    private $maxFileSize = 5242880; // 5MB in bytes

    public function index()
    {
        return view('frontend.index');
    }
    // input pengaduan
    public function create()
    {
        return view('frontend.input-pengaduan');
    }

    public function edit($id)
    {
        return view('frontend.ubah-pengaduan', [
            'pengaduan' => Pengaduan::findOrfail(Crypt::decrypt($id)),
            'jenis' => ['pengaduan', 'aspirasi']
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_pengaduan' => 'unique',
            'judul_laporan' => 'required',
            'nomor_induk' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required|min:11|max:13',
            'alamat' => 'required',
            'jenis_pengaduan' => 'required',
            'tanggal_laporan' => 'required',
            'laporan' => 'required',
            'berkas_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);
        
        if ($id) {
            $pengaduan = Pengaduan::findOrfail($id);
            
            $berkas = $pengaduan->berkas_pendukung;
            if ($request->hasFile('berkas_pendukung')) {
                $file = $request->file('berkas_pendukung');
                
                // Validate MIME type
                if (!in_array($file->getMimeType(), $this->allowedMimes)) {
                    return back()->with('error', 'Tipe file tidak diizinkan. Gunakan PDF, JPG, PNG, atau DOC.');
                }
                
                // Validate file size
                if ($file->getSize() > $this->maxFileSize) {
                    return back()->with('error', 'Ukuran file terlalu besar. Maksimal 5MB.');
                }
                
                // Delete old file if exists
                if ($pengaduan->berkas_pendukung && Storage::exists($pengaduan->berkas_pendukung)) {
                    Storage::delete($pengaduan->berkas_pendukung);
                }
                
                // Generate secure filename
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $berkas = $file->storeAs('public/berkas_pendukung', $filename);
            }
            
            $data = $pengaduan->update([
                'nomor_induk' => $request->nomor_induk,
                'judul_laporan' => $request->judul_laporan,
                'nama' => $request->nama,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'jenis_pengaduan' => $request->jenis_pengaduan,
                'tanggal_laporan' => $request->tanggal_laporan,
                'laporan' => strip_tags($request->laporan),
                'berkas_pendukung' => $berkas,
            ]);
            Activity::create([
                'activity' => Auth::user()->name . ' mengubah Data Pengaduan ' . $pengaduan->kode_pengaduan,
            ]);
            return redirect()->route('pengaduan.check')->with('status', 'Data pengaduan berhasil di ubah');
        } else {
            return redirect()->route('pengaduan.check')->with('status', 'Data tidak ditemukan');
        }
    }
    // store
    public function store(Request $request)
    {
        // action to store data pengaduan into database
        $request->validate([
            'kode_pengaduan' => 'unique',
            'judul_laporan' => 'required',
            'nomor_induk' => 'required',
            'nama' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required|min:11|max:13',
            'alamat' => 'required',
            'jenis_pengaduan' => 'required',
            'tanggal_laporan' => 'required',
            'laporan' => 'required',
            'berkas_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);
        
        $berkas = null;
        if ($request->hasFile('berkas_pendukung')) {
            $file = $request->file('berkas_pendukung');
            
            // Validate MIME type
            if (!in_array($file->getMimeType(), $this->allowedMimes)) {
                return back()->with('error', 'Tipe file tidak diizinkan. Gunakan PDF, JPG, PNG, atau DOC.');
            }
            
            // Validate file size
            if ($file->getSize() > $this->maxFileSize) {
                return back()->with('error', 'Ukuran file terlalu besar. Maksimal 5MB.');
            }
            
            // Generate secure filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $berkas = $file->storeAs('public/berkas_pendukung', $filename);
        }
        
        Pengaduan::create([
            'kode_pengaduan' => 'PGD' . mt_rand(10000, 99999) . mt_rand(100, 999),
            'nomor_induk' => $request->nomor_induk,
            'judul_laporan' => $request->judul_laporan,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'jenis_pengaduan' => $request->jenis_pengaduan,
            'tanggal_laporan' => $request->tanggal_laporan,
            'laporan' => strip_tags($request->laporan),
            'berkas_pendukung' => $berkas,
            'status' => 'pending',
        ]);

        Activity::create([
            'activity' => Auth::user()->name . ' mengirim ' . $request->jenis_pengaduan,
        ]);

        return redirect()->route('success');
    }
    public function handleDetail($id = false)
    {
        $dec = \Crypt::Decrypt($id);
        $groupItem = Tanggapan::with(['user', 'pengaduan'])->where('pengaduan_id', $dec)->first();
        
        // If no tanggapan exists, fetch pengaduan directly and create fallback object
        if (!$groupItem) {
            $pengaduan = Pengaduan::findOrfail($dec);
            $groupItem = (object)['pengaduan' => $pengaduan, 'tanggapan' => null, 'user' => null];
        }
        
        return view('frontend.detail-pengaduan', [
            'groupItem' => $groupItem
        ]);
    }

    public function handleSearch(Request $request)
    {
        return view('frontend.cek-pengaduan', [
            'pengaduan' => Pengaduan::where('judul_laporan', 'like', '%' . $request->keyword . '%')->paginate(3)
        ]);
    }

    public function handleCheck(Request $request)
    {
        return view('frontend.cek-pengaduan', ['pengaduan' => Pengaduan::paginate(3)]);
    }
    // sukses page
    public function success()
    {
        return view('frontend.sukses');
    }

    public function destroy($id)
    {
        Pengaduan::destroy($id);
        Activity::create([
            'activity' => Auth::user()->name . ' menghapus pengaduan/aspirasi',
        ]);
        return redirect()->route('pengaduan.check')->with('status', 'Data pengaduan berhasil dihapus');
    }

    public function history()
    {
        $pengaduan = Pengaduan::where('nomor_induk', Auth::user()->nomor_induk)
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);
        
        return view('frontend.history-pengaduan', [
            'pengaduan' => $pengaduan,
            'stats' => [
                'total' => Pengaduan::where('nomor_induk', Auth::user()->nomor_induk)->count(),
                'pending' => Pengaduan::where('nomor_induk', Auth::user()->nomor_induk)->where('status', 'pending')->count(),
                'sukses' => Pengaduan::where('nomor_induk', Auth::user()->nomor_induk)->where('status', 'sukses')->count(),
                'ditolak' => Pengaduan::where('nomor_induk', Auth::user()->nomor_induk)->where('status', 'ditolak')->count(),
            ]
        ]);
    }

    public function progress($id)
    {
        $dec = \Crypt::Decrypt($id);
        $pengaduan = Pengaduan::findOrfail($dec);
        
        $tanggapan = Tanggapan::with('user')->where('pengaduan_id', $dec)->first();
        
        return view('frontend.progress-pengaduan', [
            'pengaduan' => $pengaduan,
            'tanggapan' => $tanggapan,
            'timeline' => [
                [
                    'status' => 'Pengaduan Dikirim',
                    'date' => $pengaduan->created_at,
                    'description' => 'Aspirasi/pengaduan Anda telah diterima sistem',
                    'completed' => true
                ],
                [
                    'status' => 'Menunggu Verifikasi',
                    'date' => $pengaduan->created_at,
                    'description' => 'Petugas sedang memverifikasi pengaduan Anda',
                    'completed' => $pengaduan->status !== 'pending'
                ],
                [
                    'status' => 'Diproses',
                    'date' => $tanggapan ? $tanggapan->created_at : null,
                    'description' => 'Pengaduan sedang diproses oleh pihak sekolah',
                    'completed' => $tanggapan && ($pengaduan->status === 'sukses' || $pengaduan->status === 'ditolak')
                ],
                [
                    'status' => in_array($pengaduan->status, ['sukses', 'ditolak']) ? 'Selesai' : 'Menunggu',
                    'date' => $tanggapan ? $tanggapan->created_at : null,
                    'description' => $pengaduan->status === 'sukses' ? 'Pengaduan Anda telah diterima dan ditanggapi' : 'Proses penyelesaian',
                    'completed' => $pengaduan->status !== 'pending'
                ]
            ]
        ]);
    }
}
