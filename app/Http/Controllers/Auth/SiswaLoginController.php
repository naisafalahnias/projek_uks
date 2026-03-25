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
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Kita login lewat tabel 'users' (guard default), 
        // tapi kita paksa harus yang role-nya 'siswa'
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => 'siswa' 
        ];

        // Gunakan Auth biasa (guard web), tidak perlu ->guard('siswa')
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->route('landing'); 
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau Anda bukan siswa.'
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

        // Redirect ke landing page
        return redirect()->route('landing');
    }
}
