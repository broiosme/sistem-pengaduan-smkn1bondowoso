@extends('frontend.layout.app')
@section('title', 'Progress Pengaduan | SMKN 1 Bondowoso')
@section('content')
<section class="w-full px-8 py-20 bg-gray-100 xl:px-8">
    <div class="max-w-5xl mt-20 mx-auto">
        <div class="flex flex-col justify-between items-center md:flex-row">
            <div class="w-full mt-16 md:mt-0">
                <div class="w-full h-auto p-10 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7">
                    <h3 class="mb-6 text-2xl font-medium text-center">Progress <strong>Pengaduan / Aspirasi</strong> Anda</h3>

                    <!-- Main Status Card -->
                    <div class="w-full px-6 py-6 mx-auto mt-10 shadow-2xl bg-white border border-gray-200 rounded-lg">
                        <h3 class="text-lg font-bold text-gray-500 sm:text-xl md:text-2xl">
                            {{ $pengaduan->judul_laporan }}
                        </h3>
                        <hr class="bg-gray-400 my-4 rounded-md">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Kode Pengaduan</p>
                                <p class="text-lg font-bold text-gray-800">{{ $pengaduan->kode_pengaduan }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Jenis</p>
                                <p class="text-lg font-bold text-gray-800">{{ ucfirst($pengaduan->jenis_pengaduan) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Tanggal Dikirim</p>
                                <p class="text-lg font-bold text-gray-800">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Status Saat Ini</p>
                                <p class="text-lg font-bold">
                                    @if ($pengaduan->status === 'pending')
                                        <span class="px-3 py-1 bg-yellow-500 text-white rounded">Menunggu</span>
                                    @elseif ($pengaduan->status === 'ditolak')
                                        <span class="px-3 py-1 bg-red-600 text-white rounded">Ditolak</span>
                                    @else
                                        <span class="px-3 py-1 bg-green-600 text-white rounded">Diterima</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm font-semibold text-gray-600 mb-2">Isi Laporan</p>
                            <p class="text-gray-800">{{ $pengaduan->laporan }}</p>
                        </div>

                        @if ($tanggapan)
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
                            <p class="text-sm font-semibold text-green-700 mb-2">Balasan dari Petugas</p>
                            <p class="text-gray-800">{{ $tanggapan->tanggapan }}</p>
                            <p class="text-xs text-gray-600 mt-2">Ditanggapi oleh: <strong>{{ $tanggapan->user->name }}</strong></p>
                            <p class="text-xs text-gray-600">Tanggal: {{ $tanggapan->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Timeline Progress -->
                    <div class="w-full mt-12">
                        <h4 class="text-xl font-bold text-gray-800 mb-8">Tahapan Proses</h4>
                        
                        <!-- Desktop Timeline -->
                        <div class="hidden md:block">
                            <div class="relative">
                                <!-- Timeline line -->
                                <div class="absolute left-1/2 transform -translate-x-1/2 top-0 bottom-0 w-1 bg-gray-300"></div>

                                @foreach ($timeline as $index => $item)
                                <div class="mb-12 relative">
                                    <div class="flex">
                                        <!-- Left Side (Even items) -->
                                        @if ($index % 2 == 0)
                                        <div class="w-1/2 pr-8 text-right">
                                            <div class="mb-2">
                                                <p class="font-semibold text-gray-800 text-lg">{{ $item['status'] }}</p>
                                                @if ($item['date'])
                                                <p class="text-sm text-gray-600">{{ $item['date']->format('d/m/Y H:i') }}</p>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $item['description'] }}</p>
                                        </div>

                                        <!-- Center Circle -->
                                        <div class="w-0 flex justify-center">
                                            <div class="relative flex items-center justify-center">
                                                <div class="absolute w-16 h-16 {{ $item['completed'] ? 'bg-green-500' : 'bg-gray-300' }} rounded-full opacity-10"></div>
                                                <div class="relative z-10 w-12 h-12 {{ $item['completed'] ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                                    @if ($item['completed'])
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    @else
                                                    <div class="w-4 h-4 {{ $index === 0 || ($index > 0 && $timeline[$index-1]['completed']) ? 'bg-gray-600' : 'bg-white' }} rounded-full"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Side (Odd items) -->
                                        <div class="w-1/2 pl-8 {{ $index % 2 == 0 ? 'invisible' : 'visible' }}">
                                            <div class="mb-2">
                                                <p class="font-semibold text-gray-800 text-lg">{{ $index % 2 == 1 ? $item['status'] : '' }}</p>
                                                @if ($item['date'] && $index % 2 == 1)
                                                <p class="text-sm text-gray-600">{{ $item['date']->format('d/m/Y H:i') }}</p>
                                                @endif
                                            </div>
                                            @if ($index % 2 == 1)
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $item['description'] }}</p>
                                            @endif
                                        </div>
                                        @else
                                        <!-- Right Side for even indices is empty, odd indices show content -->
                                        <div class="w-1/2 pr-8 text-right invisible"></div>

                                        <!-- Center Circle -->
                                        <div class="w-0 flex justify-center">
                                            <div class="relative flex items-center justify-center">
                                                <div class="absolute w-16 h-16 {{ $item['completed'] ? 'bg-green-500' : 'bg-gray-300' }} rounded-full opacity-10"></div>
                                                <div class="relative z-10 w-12 h-12 {{ $item['completed'] ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                                    @if ($item['completed'])
                                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    @else
                                                    <div class="w-4 h-4 {{ $index === 0 || ($index > 0 && $timeline[$index-1]['completed']) ? 'bg-gray-600' : 'bg-white' }} rounded-full"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Left Side (Odd items) -->
                                        <div class="w-1/2 pl-8">
                                            <div class="mb-2">
                                                <p class="font-semibold text-gray-800 text-lg">{{ $item['status'] }}</p>
                                                @if ($item['date'])
                                                <p class="text-sm text-gray-600">{{ $item['date']->format('d/m/Y H:i') }}</p>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-700 leading-relaxed">{{ $item['description'] }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Mobile Timeline -->
                        <div class="md:hidden">
                            @foreach ($timeline as $index => $item)
                            <div class="mb-8 flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div class="relative z-10 w-12 h-12 {{ $item['completed'] ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                        @if ($item['completed'])
                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        @else
                                        <div class="w-4 h-4 {{ $index === 0 || ($index > 0 && $timeline[$index-1]['completed']) ? 'bg-gray-600' : 'bg-white' }} rounded-full"></div>
                                        @endif
                                    </div>
                                    @if ($index < count($timeline) - 1)
                                    <div class="w-1 h-12 bg-gray-300 mt-2"></div>
                                    @endif
                                </div>
                                <div class="flex-1 pt-2">
                                    <p class="font-semibold text-gray-800 text-lg">{{ $item['status'] }}</p>
                                    @if ($item['date'])
                                    <p class="text-sm text-gray-600">{{ $item['date']->format('d/m/Y H:i') }}</p>
                                    @endif
                                    <p class="text-sm text-gray-700 mt-3 leading-relaxed">{{ $item['description'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 mt-8 flex-wrap">
                        <a href="{{ route('detail.pengaduan', Crypt::Encrypt($pengaduan->id)) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                            Lihat Detail Lengkap
                        </a>
                        <a href="{{ route('pengaduan.history') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H6a4 4 0 014 4v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm12-1a1 1 0 100 2h1a1 1 0 100-2h-1zm-1 11a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            Kembali ke Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
