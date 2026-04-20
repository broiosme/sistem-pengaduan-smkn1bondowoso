@extends('backend.layout.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaduan</h3>
                <p class="text-subtitle text-muted">For user to check they list</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pengaduan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Filter & Cari Pengaduan</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('pengaduan') }}" class="row">
                    <div class="col-md-2 mb-3">
                        <label for="jenis_pengaduan">Jenis Pengaduan</label>
                        <select name="jenis_pengaduan" id="jenis_pengaduan" class="form-control">
                            <option value="">-- Semua --</option>
                            @foreach ($jenis_list as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis_pengaduan') == $jenis ? 'selected' : '' }}>{{ ucfirst($jenis) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">-- Semua --</option>
                            @foreach ($status_list as $st)
                                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="nomor_induk">Nomor Induk Siswa</label>
                        <input type="text" name="nomor_induk" id="nomor_induk" class="form-control" value="{{ request('nomor_induk') }}" placeholder="NIS">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tanggal_dari">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tanggal_sampai">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="bulan">Bulan</label>
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">-- Semua --</option>
                            @foreach ($bulan_list as $num => $bulan)
                                <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $bulan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tahun">Tahun</label>
                        <input type="number" name="tahun" id="tahun" class="form-control" value="{{ request('tahun', date('Y')) }}" min="2020" max="{{ date('Y') }}">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Cari</button>
                        <a href="{{ route('pengaduan') }}" class="btn btn-secondary"><i class="fas fa-sync"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('print.laporan') }}" class="btn btn-primary"><i class="fas fa-print"></i></a>
                @if (session('status'))
                    <div class="alert alert-success mt-1">
                        {{ session('status') }}
                    </div>
                @endif
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>kode</th>
                            <th>Judul</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduan as $item)
                        <tr>
                            <td>{{ $item->kode_pengaduan }}</td>
                            <td>{{ $item->judul_laporan }}</td>
                            <td>{{ $item->jenis_pengaduan }}</td>
                            <td>
                                @if ($item->status === 'pending')
                                    <span class="badge bg-warning">{{ $item->status }}</span>
                                @elseif($item->status === 'ditolak')
                                    <span class="badge bg-danger">{{ $item->status }}</span>
                                @else
                                    <span class="badge bg-success">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('detail.laporan', Crypt::Encrypt($item->id)) }}" class="btn btn-sm btn-info">Detail</a>
                                @if ($item->status === 'pending')
                                    <a href="{{ route('tanggapan',  Crypt::Encrypt($item->id)) }}" class="btn btn-sm btn-primary">Tanggapi</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

@endsection