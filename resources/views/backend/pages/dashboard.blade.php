@extends('backend.layout.app')
@section('content')
<div class="page-heading">
    <h3>Dashboard</h3>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <!-- Aktivitas User -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon purple">
                                        <i class="iconly-boldShow"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Aktivitas User</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalActivities }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Data User -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon blue">
                                        <i class="iconly-boldProfile"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Data User</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalUsers }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Data Petugas -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon green">
                                        <i class="iconly-boldAdd-User"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Data Petugas</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalPetugas }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Data Laporan -->
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-3 py-4-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="stats-icon red">
                                        <i class="iconly-boldBookmark"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h6 class="text-muted font-semibold">Data Laporan</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalPengaduan }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Log Aktivitas User</h4>
                        </div>
                        <div class="card-body">
                            @if ($activities->count() > 0)
                                <table class="table">
                                    <tr>
                                        <th width="10%">#</th>
                                        <th width="75%">Activity</th>
                                        <th width="15%">Time</th>
                                    </tr>
                                    @foreach ($activities as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->activity }}</td>
                                            <td>{{ $item->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i> Belum ada aktivitas user
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Admin & Petugas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @if ($staffMembers->count() > 0)
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($staffMembers as $staff)
                                                <tr>
                                                    <td class="col-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-md bg-light-primary text-primary">
                                                                <span>{{ substr($staff->name, 0, 1) }}</span>
                                                            </div>
                                                            <p class="font-bold ms-3 mb-0">{{ $staff->name }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="col-4">{{ $staff->email }}</td>
                                                    <td class="col-4">
                                                        <span class="badge bg-{{ $staff->role === 'admin' ? 'danger' : 'info' }}">
                                                            {{ ucfirst($staff->role) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info" role="alert">
                                        <i class="fas fa-info-circle me-2"></i> Belum ada Admin atau Petugas terdaftar
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <div class="avatar-content bg-light-primary text-primary">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                            <h6 class="text-muted mb-0">@ {{ Auth::user()->email }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Statistik Pengaduan</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="text-muted">Pending</h6>
                            <span class="badge bg-warning">{{ $pengaduanPending }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="text-muted">Diterima</h6>
                            <span class="badge bg-success">{{ $pengaduanSukses }}</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="text-muted">Ditolak</h6>
                            <span class="badge bg-danger">{{ $pengaduanDitolak }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection