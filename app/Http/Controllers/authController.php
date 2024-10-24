<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class authController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'nomor_id' => 'required|string',
            'password' => 'required|string',
        ]);

        // Mencari user berdasarkan nomor_id
        $user = User::where('nomor_id', $credentials['nomor_id'])->first();

        // Jika user ditemukan dan password sesuai
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Login user
            Auth::login($user);

            // Redirect ke dashboard setelah berhasil login
            return redirect()->route('dashboard');
        }

        // Jika login gagal, redirect kembali ke halaman login dengan pesan error
        return back()->withErrors([
            'nomor_id' => 'ID atau Password salah.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
