<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect('admin');
        } elseif ($user->role === 'petugas') {
            return redirect('petugas');
        } elseif ($user->role === 'siswa') {
            return redirect('dashboard/siswa');
        } else {
            return abort(403, 'Role tidak dikenal.');
        }
    }
}
