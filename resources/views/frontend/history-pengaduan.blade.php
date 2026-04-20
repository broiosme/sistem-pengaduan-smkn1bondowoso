@extends('frontend.layout.app')
@section('title', 'Riwayat Pengaduan | SMKN 1 Bondowoso')
@section('content')
<section class="w-full px-8 py-20 bg-gray-100 xl:px-8">
    <div class="max-w-5xl mt-20 mx-auto">
        <div class="flex flex-col justify-between items-center md:flex-row">
            <div class="w-full mt-16 md:mt-0">
                <div class="w-full h-auto p-10 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7">
                    <h3 class="mb-6 text-2xl font-medium text-center">Riwayat <strong>Pengaduan / Aspirasi</strong> Anda</h3>
                    
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                            <p class="text-gray-600 text-sm font-semibold">TOTAL PENGADUAN</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                            <p class="text-gray-600 text-sm font-semibold">MENUNGGU</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-500">
                            <p class="text-gray-600 text-sm font-semibold">DITERIMA</p>
                            <p class="text-3xl font-bold text-green-600">{{ $stats['sukses'] }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                            <p class="text-gray-600 text-sm font-semibold">DITOLAK</p>
                            <p class="text-3xl font-bold text-red-600">{{ $stats['ditolak'] }}</p>
                        </div>
                    </div>

                    <!-- History List -->
                    @forelse ($pengaduan as $item)
                    <div class="max-w-2xl mt-5 mx-auto px-8 py-4 bg-white rounded-lg shadow-lg border-l-4 {{ $item->status === 'sukses' ? 'border-green-500' : ($item->status === 'ditolak' ? 'border-red-500' : 'border-yellow-500') }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <span class="font-light text-gray-600 text-sm">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                                <p class="text-sm font-medium text-cyan-100 sm:text-md md:text-md">Kode: <strong>{{ $item->kode_pengaduan }}</strong></p>
                                <p class="text-2xl text-gray-700 font-bold hover:text-gray-600 mt-2">{{ \Str::limit($item->judul_laporan, 50) }}</p>
                                <p class="mt-2 text-gray-600 text-sm">{{\Str::limit($item->laporan, 100)}}...</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="px-3 py-1 bg-gray-600 text-gray-100 text-xs font-bold rounded">{{ ucfirst($item->jenis_pengaduan) }}</span>
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                @if ($item->status === 'pending')
                                <div class="bg-yellow-500 font-semibold text-white p-2 rounded text-sm">Pending</div>
                                @elseif($item->status === 'ditolak')
                                <div class="bg-red-600 font-semibold text-white p-2 rounded text-sm">Ditolak</div>
                                @else
                                <div class="bg-green-600 font-semibold text-white p-2 rounded text-sm">Diterima</div>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3 mt-4">
                            @auth
                                <a href="{{ route('detail.pengaduan', Crypt::Encrypt($item->id)) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">Detail</a>
                                <a href="{{ route('pengaduan.progress', Crypt::Encrypt($item->id)) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">Lihat Progress</a>
                                @if ($item->status === 'pending')
                                <a href="{{ route('pengaduan.edit', Crypt::Encrypt($item->id)) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded hover:bg-yellow-700">Ubah</a>
                                <form action="{{ Route('pengaduan.delete', $item->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded hover:bg-red-700">Hapus</button>
                                </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                    @empty
                    <div class="container mx-auto mt-10">
                        <div class="w-full bg-red-500 rounded-md text-white">
                            <div class="flex justify-between items-center container mx-auto py-4 px-6">
                                <div class="flex">
                                    <p class="mx-3">Anda belum memiliki pengaduan. <a href="{{ route('pengaduan.check') }}" class="underline font-bold">Klik di sini untuk membuat pengaduan baru</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforelse

                    <!-- Pagination -->
                    @if ($pengaduan->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $pengaduan->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
