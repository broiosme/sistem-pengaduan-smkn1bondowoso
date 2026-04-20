@extends('frontend.layout.app')
@section('title', 'Detail Pengaduan | SMKN 1 Bondowoso')
@section('content')
<!---form -->
<section class="w-full px-8 py-20 bg-gray-100 xl:px-8">
    <div class="max-w-5xl mt-20  mx-auto">
        <div class="flex flex-col justify-between items-center md:flex-row">
            <div class="w-full mt-16 md:mt-0 ">
                <div
                    class="w-full h-auto p-10 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7">
                    <h3 class="mb-6 text-2xl font-medium text-center">Detail <strong>Pengaduan / Aspirasi</strong> Anda
                    </h3>

                    <!-- card report -->
                    <div
                        class="w-full px-6  py-6 mx-auto mt-10 shadow-2xl bg-white border border-gray-200 rounded-lg sm:px-8 md:px-12 sm:py-8 sm:shadow-2xl lg:w-5/6 xl:w-2/3">
                        <h3 class="text-lg font-bold text-gray-500 sm:text-xl md:text-2xl">
                            {{$groupItem->pengaduan->judul_laporan}}
                        </h3>
                        <hr class="bg-gray-400 my-4 rounded-md">
                        <p class="text-sm sm:text-md md:text-md">Nama Pelapor : <span
                                class="font-semibold  text-cyan-500">{{$groupItem->pengaduan->nama}}</span>
                        </p>

                        <p class="mt-2 text-base text-gray-600 sm:text-lg md:text-normal">
                            {{$groupItem->pengaduan->laporan}}</p>
                        @if (!$groupItem->pengaduan->berkas_pendukung)
                        <div class="flex justify-between items-center">
                            <p class="px-3 py-1 mx-2 bg-gray-600 text-gray-100 text-sm font-bold rounded hover:bg-gray-500">
                                Tidak ada berkas yang dilampirkan</p>
                        </div>
                        @else
                        <a href="{{ asset($groupItem->pengaduan->berkas_pendukung) }}" class="text-blue-400"
                            download="{{$groupItem->pengaduan->berkas_pendukung}}">Download Berkas</i></a>
                        @endif
                        @if ($groupItem->pengaduan->status === 'pending')
                        <div
                            class="bg-yellow-500 font-semibold text-center mt-4 text-white p-2 rounded  leading-none flex items-center">
                            Pending</div>
                        @elseif($groupItem->pengaduan->status === 'ditolak')
                        <div
                            class="bg-red-600  font-semibold  text-center mt-4 text-white p-2 rounded  leading-none flex items-center">
                            Ditolak</div>
                        @else
                        <div
                            class="bg-green-600 font-semibold text-center mt-4 text-white p-2 rounded  leading-none flex items-center">
                            Diterima</div>
                        @endif
                        <hr class="bg-gray-400 my-6 rounded-md">
                        
                        <!-- Feedback Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Umpan Balik dari Petugas:</h3>
                            @if ($groupItem && $groupItem->tanggapan)
                            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                                <p>{{$groupItem->tanggapan}}</p>
                                <p class="text-xs text-gray-600 mt-2">{{ optional($groupItem)->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            @else
                            <p class="text-yellow-600">Belum ada umpan balik dari petugas</p>
                            @endif
                        </div>

                        <div class="flex gap-3 mt-6">
                            <a href="{{url('site/cek-pengaduan')}}"
                                class="inline-flex items-center px-6 py-3 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.707 9.293a1 1 0 010 1.414L5.414 13H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                Kembali
                            </a>
                        </div>
                    </div>
                    <!-- card report -->
                </div>
            </div>
</section>
@endsection
