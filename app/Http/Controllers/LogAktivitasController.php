<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
    public function index()
    {
        // Ambil semua log aktivitas dengan relasi user
        $logs = LogAktivitas::with('user')->latest()->paginate(5); // <- Pagination aktif

        // Kirim ke view blade
        return view('backend.log.index', compact('logs'));
    }
}
