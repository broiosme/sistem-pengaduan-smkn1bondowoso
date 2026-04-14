<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'nomor_induk' => 'required|integer|unique:users',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah terdaftar',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'nomor_induk.required' => 'Nomor induk wajib diisi',
            'nomor_induk.unique' => 'Nomor induk sudah terdaftar',
            'nomor_induk.integer' => 'Nomor induk harus berupa angka',
            'nomor_induk.numeric' => 'Nomor induk harus berupa angka',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
        ]);

        try {
            // Buat user baru dengan role default "user"
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'nomor_induk' => $validated['nomor_induk'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'role' => 'user',
            ]);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login dengan akun Anda');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
        }
    }

    public function login()
    {
        return view('auth.BE_login');
    }

    public function prosesLogin(Request $req)
    {
        // dd($req->all());
        if (Auth::attempt(['email' => $req->email, 'password' => $req->password])) {
            if(Auth::user()->role === 'user' ) {
               return redirect('/');   
            }
            if (Auth::user()->role === 'admin' || Auth::user()->role === 'petugas' ){
                return redirect(route('dashboard'));
            }
        } else {
            return redirect()->back()->with('error', 'Email atau Password Yang Anda Masukan Salah');
        }
    }

    public function logout()
    {
        if (Auth::user()) {
            Auth::logout();
            return redirect()->route('login')->with('status', 'Logout Berhasil, Silahkan Login kembali untuk memakai layanan kami');
        } else {
            return redirect()->back();
        }
    }
}
