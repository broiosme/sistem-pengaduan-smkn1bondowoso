@extends('backend.layout.app')
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Pengaduan</h3>
                <p class="text-subtitle text-muted">For user to check they list</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengaduan') }}">Pengaduan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Pengaduan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div>
                    <h4>Informasi Pelapor</h4>
                    <table>
                        <tr>
                            <td width="180px">Nomor Induk</td>
                            <td>:</td>
                            <td>{{ $laporan->nomor_induk }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $laporan->nama }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td>{{ $laporan->email }}</td>
                        </tr>
                        <tr>
                            <td>Nomor Telepon</td>
                            <td>:</td>
                            <td>{{ $laporan->no_telp }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $laporan->alamat }}</td>
                        </tr>
                    </table>
                </div>
                <div class="mt-4">
                    <h4>Laporan</h4>
                    <table>
                        <tr>
                            <td width="180px">Kode</td>
                            <td>:</td>
                            <td>{{ $laporan->kode_pengaduan }}</td>
                        </tr>
                        <tr>
                            <td>Jenis</td>
                            <td>:</td>
                            <td>{{ $laporan->jenis_pengaduan }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ $laporan->tanggal_laporan }}</td>
                        </tr>
                        <tr>
                            <td>Judul</td>
                            <td>:</td>
                            <td>{{ $laporan->judul_laporan }}</td>
                        </tr>
                        <tr>
                            <td>Isi</td>
                            <td>:</td>
                            <td>{{ $laporan->laporan }}</td>
                        </tr>
                        <tr>
                            <td>Berkas Pendukung</td>
                            <td>:</td>
                            <td>
                                @if ($laporan->berkas_pendukung)
                                    {{ $laporan->berkas_pendukung }}
                                    <a href="{{ asset($laporan->berkas_pendukung) }}" download="{{$laporan->berkas_pendukung}}" class="btn btn-primary"><i class="fas fa-download"></i></a>
                                @else
                                Tidak ada berkas
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="mt-4">
                    <h4>Status & Tanggapan</h4>
                    <div class="alert {{ $laporan->status === 'sukses' ? 'alert-success' : ($laporan->status === 'ditolak' ? 'alert-danger' : 'alert-warning') }}">
                        <strong>Status:</strong> 
                        @if ($laporan->status === 'sukses')
                            Laporan Diterima
                        @elseif($laporan->status === 'ditolak')
                            Laporan Ditolak
                        @else
                            Menunggu Tanggapan
                        @endif
                    </div>
                    
                    @if ($laporan->tanggapan)
                        <div class="card mt-3 border-left-primary">
                            <div class="card-header bg-light">
                                <h5 class="mb-0"><i class="fas fa-reply"></i> Tanggapan dari: <strong>{{ $laporan->tanggapan->user->name }}</strong></h5>
                                <small class="text-muted">{{ $laporan->tanggapan->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="card-body">
                                <p>{{ $laporan->tanggapan->tanggapan }}</p>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada tanggapan. <a href="{{ route('tanggapan',  Crypt::Encrypt($laporan->id)) }}" class="btn btn-sm btn-primary mt-2">Berikan Tanggapan</a>
                        </div>
                    @endif
                </div>
                
                @if ($laporan->status === 'pending')
                <div class="mt-4">
                    <a href="{{ route('tanggapan',  Crypt::Encrypt($laporan->id)) }}" class="btn btn-primary"><i class="fas fa-reply"></i> Berikan Tanggapan</a>
                </div>
                @endif
            </div>
        </div>

    </section>
</div>

@endsection