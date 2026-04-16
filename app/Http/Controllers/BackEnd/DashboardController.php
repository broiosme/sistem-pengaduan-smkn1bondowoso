<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung statistik dari database
        $totalActivities = Activity::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPengaduan = Pengaduan::count();
        
        // Statistik pengaduan berdasarkan status
        $pengaduanPending = Pengaduan::where('status', 'pending')->count();
        $pengaduanSukses = Pengaduan::where('status', 'sukses')->count();
        $pengaduanDitolak = Pengaduan::where('status', 'ditolak')->count();
        
        // Ambil data admin & petugas (for display)
        $admins = User::where('role', 'admin')->latest()->get();
        $petugas = User::where('role', 'petugas')->latest()->get();
        $staffMembers = $admins->merge($petugas)->take(5);
        
        $data = [
            'title' => 'Dashboard',
            'activities' => Activity::latest()->limit(10)->get(),
            'totalActivities' => $totalActivities,
            'totalUsers' => $totalUsers,
            'totalPetugas' => $totalPetugas,
            'totalPengaduan' => $totalPengaduan,
            'pengaduanPending' => $pengaduanPending,
            'pengaduanSukses' => $pengaduanSukses,
            'pengaduanDitolak' => $pengaduanDitolak,
            'staffMembers' => $staffMembers,
        ];
        return view('backend.pages.dashboard', $data);
    }
}
