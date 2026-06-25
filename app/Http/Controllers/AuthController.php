<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Halaman Tampilan Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Aksi Login
    public function login(Request $request)
    {
        // Validasi input data dari form login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba melakukan login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            // Jika berhasil, arahkan ke dashboard utama manga tracker
            return redirect()->intended(route('manga.index'))->with('success', 'Selamat datang kembali!');
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])->onlyInput('email');
    }

    // Halaman Tampilan Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Aksi Register (Create Account)
    public function register(Request $request)
    {
        // Validasi data pendaftaran sesuai field di UI
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' otomatis mengecek password_confirmation
        ]);

        // Simpan data user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash demi keamanan
        ]);

        // Otomatis login setelah berhasil mendaftar
        Auth::login($user);

        return redirect()->route('manga.index')->with('success', 'Akun berhasil dibuat! Selamat datang di Manga Noted.');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
 
        return redirect()->route('login')->with('success', 'Kamu berhasil logout.');
    }
}