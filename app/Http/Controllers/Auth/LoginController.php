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
            return '/admin';
        }

        if ($role === 'petugas') {
            return '/petugas';
        }

        return '/home'; // siswa
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
}
