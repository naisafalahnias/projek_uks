<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaLoginController extends Controller
{
    /**
     * tampilkan halaman login siswa
     */
    public function showLoginForm()
    {
        return view('auth.siswa.login');
    }

    /**
     * proses login siswa
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required', // fleksibel (email / username)
            'password' => 'required'
        ]);

        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'siswa'
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email / Username atau password salah'
        ])->withInput();
    }

    /**
     * logout siswa
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('siswa.login');
    }
}
