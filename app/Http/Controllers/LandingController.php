<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\RekamMedis;
use App\Models\Obat;
use App\Models\User;

class LandingController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data
        $data = [
            'totalSiswa'       => Siswa::count(),
            'totalPemeriksaan' => RekamMedis::count(),
            'totalObat'        => Obat::count(),
            'totalPetugas'     => User::where('role', 'petugas')->count(),
        ];

        // 2. Kirim ke view (pastikan path-nya benar)
        return view('frontend.pages.home', $data);
    }
}