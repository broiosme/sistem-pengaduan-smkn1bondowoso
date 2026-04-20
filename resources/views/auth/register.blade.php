@extends('frontend.layout.app')
@section('title', 'Register | Layanan Pengaduan SMKN 1 Bondowoso')
@section('content')
<section class="w-full px-8 py-20 bg-gray-100 xl:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col items-center md:flex-row">
            <div class="w-full space-y-5 md:w-3/5 md:pr-16">
                <h3
                    class="text-2xl text-center md:text-left font-extrabold leading-none text-black sm:text-3xl md:text-5xl">
                    Bergabunglah dengan Kami
                </h3>
                <p class="text-md text-gray-600 text-center md:text-left md:pr-16">Daftarkan akun baru untuk mulai menyampaikan Pengaduan atau Aspirasi Anda kepada pihak sekolah</p>
            </div>
            <div class="w-full mt-10 md:mt-0 md:w-2/5">
                <div
                    class="relative z-10 h-auto p-8 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7">
                    <h3 class="mb-6 text-2xl font-medium text-center">Daftar Pengaduan <br> <strong>SMKN 1 Bondowoso</strong>
                    </h3>
                    <form action="{{ route('store.register') }}" method="post">
                        @csrf
                        @if ($errors->any())
                        <div class="container mx-auto">
                            <div class="w-full my-4 rounded-md bg-red-500 text-white">
                                <div class="flex justify-between items-center container mx-auto py-4 px-6">
                                    <div class="flex flex-col flex-1">
                                        <svg viewBox="0 0 40 40" class="h-6 w-6 fill-current">
                                            <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                                        </svg>
                                        @foreach ($errors->all() as $error)
                                            <p class="mx-3 text-sm">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if (session('success'))     
                        <div class="w-full my-4 rounded-md bg-green-500 text-white">
                            <div class="flex justify-between items-center container mx-auto py-4 px-6">
                                <div class="flex">
                                    <svg viewBox="0 0 40 40" class="h-6 w-6 fill-current">
                                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"></path>
                                    </svg>
                    
                                    <p class="mx-3">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="block mb-3 border border-gray-200 rounded-lg">
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Nama Lengkap" required>
                        </div>

                        <div class="block mb-3 border border-gray-200 rounded-lg">
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Email" required>
                        </div>

                        <div class="block mb-3 border border-gray-200 rounded-lg">
                            <input type="number" name="nomor_induk" id="nomor_induk" value="{{ old('nomor_induk') }}"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Nomor Induk Siswa/Karyawan" required>
                        </div>

                        <div class="block mb-3 border border-gray-200 rounded-lg">
                            <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Tempat Lahir" required>
                        </div>

                        <div class="block mb-3 border border-gray-200 rounded-lg">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Tanggal Lahir" required>
                        </div>

                        <div class="block mb-3 border border-gray-200 rounded-lg">
                            <input type="password" name="password" id="password"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Password (Minimal 6 karakter)" required>
                        </div>

                        <div class="block mb-4 border border-gray-200 rounded-lg">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="block w-full px-4 py-3 border-2 border-transparent rounded-lg focus:border-blue-500 focus:outline-none"
                                placeholder="Konfirmasi Password" required>
                        </div>

                        <div class="block mb-4">
                            <button type="submit"
                                class="w-full px-3 py-4 font-medium font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                                Daftar Sekarang
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="text-sm text-gray-600">Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Login di sini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
