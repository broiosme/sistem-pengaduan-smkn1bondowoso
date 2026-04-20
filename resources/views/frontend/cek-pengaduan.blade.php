@extends('frontend.layout.app')
@section('title', 'Cek Pengaduan | SMKN 1 Bondowoso')
@section('content')
<section class="w-full px-8 py-20 bg-gray-100 xl:px-8">
    <div class="max-w-5xl mt-20  mx-auto">
        <div class="flex flex-col justify-between items-center md:flex-row">
            <div class="w-full mt-16  md:mt-0 ">
                @if (session('status'))
                <div class="container mb-10  mx-auto">
                    <div class="w-full bg-green-500 rounded-md mt-8 text-white">
                        <div class="flex justify-between items-center container mx-auto py-4 px-6">
                            <div class="flex">
                                <svg viewBox="0 0 40 40" class="h-6 w-6 fill-current">
                                    <path
                                        d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z">
                                    </path>
                                </svg>
                                <p class="mx-3">{{session('status')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div
                    class="w-full h-auto p-10 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-medium">Cari <strong>Pengaduan / Aspirasi</strong> Anda</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('pengaduan.history') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H6a4 4 0 014 4v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm12-1a1 1 0 100 2h1a1 1 0 100-2h-1zm-1 11a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                Lihat Riwayat
                            </a>
                        </div>
                    </div>
                    <form action="{{route('pengaduan.search')}}" method="POST">
                        @csrf
                        <label for="" class="text-gray-600">Cari</label>
                        <div class="block mb-4 border border-gray-200 rounded-lg">
                            <input type="text" name="keyword" id="nis"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Pencarian berdasarkan  judul pengaduan atau Masalah yang di laporkan">
                        </div>
                        <div class="block">
                            <button
                                class="w-full px-3 py-4  font-medium text-white bg-blue-600 rounded-lg">Cari</button>
                        </div>
                    </form>
                    @forelse ($pengaduan as $item)
                    <div class="max-w-2xl mt-5 mx-auto px-8 py-4 bg-white  rounded-lg shadow-lg">
                        <div class="flex justify-between items-center">
                            <span
                                class="font-light text-gray-600 text-gray-400 text-sm">{{$item->created_at->format('d/m/Y')}}</span>
                            <p class="px-3 py-1 bg-gray-600 text-gray-100 text-sm font-bold rounded hover:bg-gray-500">
                                 {{strip_tags($item->jenis_pengaduan)}}</p>
                        </div>
                        <p class="text-sm font-medium  text-cyan-100 sm:text-md md:text-md">Nama Pelapor :
                            {{$item->nama}}
                        </p>
                        <div class="mt-2">
                            <p
                                class="text-2xl text-gray-700  font-bold hover:text-gray-600 dark:hover:text-gray-200 ">
                                @php
                                    echo(strip_tags($item->judul_laporan))
                                @endphp</p>
                            <p class="mt-2 text-gray-600 dark:text-gray-300">{{\Str::limit($item->laporan, 20)}}
                            </p>
                        </div>
                        @if ($item->status === 'pending')
                        <div
                            class="bg-yellow-500 font-semibold text-center mt-4 text-white p-2 rounded  leading-none flex items-center">
                            Pending</span>
                        </div>
                        @elseif($item->status === 'ditolak')
                        <div
                            class="bg-red-600  font-semibold  text-center mt-4 text-white p-2 rounded  leading-none flex items-center">
                            Di tolak</span>
                        </div>
                        @else
                        <div
                            class="bg-green-600 font-semibold text-center mt-4 text-white p-2 rounded  leading-none flex items-center">
                            Di konfirmasi </span>
                        </div>
                        @endif

                        <div class="flex flex-wrap gap-3 mt-5">
                            @if ($item->status === 'sukses' || $item->status === 'ditolak')
                                <a href="{{route('detail.pengaduan', Crypt::Encrypt($item->id))}}"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                                    Detail
                                </a>
                                <a href="{{route('pengaduan.progress', Crypt::Encrypt($item->id))}}"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out bg-blue-600 border border-transparent rounded-md hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 1 1 0 000-2H6a4 4 0 014 4v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm12-1a1 1 0 100 2h1a1 1 0 100-2h-1zm-1 11a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                                    Progress
                                </a>
                            @endif

                            @if ($item->nama === auth()->user()->name && $item->status === 'pending')
                                <a href="{{route('pengaduan.edit', Crypt::Encrypt($item->id))}}"
                                    class="inline-flex items-center px-6 py-3 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-500 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                    Ubah
                                </a>

                                <form action="{{ Route('pengaduan.delete', $item->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-6 py-3 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out bg-red-600 border border-transparent rounded-md hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="container mx-auto">
                        <div class="w-full bg-red-500 rounded-md mt-8 text-white">
                            <div class="flex justify-between items-center container mx-auto py-4 px-6">
                                <div class="flex">
                                    <svg viewBox="0 0 40 40" class="h-6 w-6 fill-current">
                                        <path
                                            d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z">
                                        </path>
                                    </svg>

                                    <p class="mx-3">Data Tidak Tersedia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforelse

                    <div class="my-3">
                        {{ $pengaduan->links() }}
                    </div>

                </div>
            </div>
</section>
@endsection
