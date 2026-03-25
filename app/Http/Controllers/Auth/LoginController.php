<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect setelah LOGIN (sesuai role)
     */
    protected function redirectTo()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return route('admin.dashboard');
        }

        if ($role === 'petugas') {
            return route('petugas.dashboard');
        }

        return route('siswa.dashboard');
    }


    /**
     * Redirect setelah LOGOUT
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        
        // Paksa agar user yang login di sini BUKAN siswa
        // (Asumsi admin dan petugas ada di tabel users yang sama)
        return array_merge($credentials, ['role' => ['admin', 'petugas']]);
        
        // Atau jika hanya admin:
        // return array_merge($credentials, ['role' => 'admin']);
    }
}
