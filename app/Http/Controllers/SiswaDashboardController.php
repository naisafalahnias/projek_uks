<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\RekamMedis;
use App\Models\PemeriksaanGizi;
use Barryvdh\DomPDF\Facade\Pdf;

class SiswaDashboardController extends Controller
{
    /**
     * Dashboard utama siswa
     */
    public function index()
    {
        $user = Auth::user();

        // ambil data siswa berdasarkan user login
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        // ringkasan data
        $rekamMedisCount = RekamMedis::where('siswa_id', $siswa->id)->count();
        $giziTerakhir = PemeriksaanGizi::where('siswa_id', $siswa->id)
                            ->latest()
                            ->first();

        return view('siswa.dashboard.index', compact(
            'siswa',
            'rekamMedisCount',
            'giziTerakhir'
        ));
    }

    /**
     * List rekam medis siswa (READ ONLY)
     */
    public function rekamMedis()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $rekamMedis = RekamMedis::where('siswa_id', $siswa->id)
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('siswa.rekam-medis.index', compact(
            'siswa',
            'rekamMedis'
        ));
    }

    /**
     * Download PDF rekam medis
     */
    public function downloadPdf($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $rekamMedis = RekamMedis::where('id', $id)
                        ->where('siswa_id', $siswa->id)
                        ->firstOrFail();

        $pdf = Pdf::loadView('siswa.rekam-medis.pdf', [
            'siswa' => $siswa,
            'rekamMedis' => $rekamMedis
        ]);

        return $pdf->download('rekam-medis-'.$siswa->nama.'.pdf');
    }

    /**
     * Download PDF kebutuhan kalori / pemeriksaan gizi
     */
    public function kaloriPdf($id)
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->firstOrFail();

        $gizi = PemeriksaanGizi::where('id', $id)
                    ->where('siswa_id', $siswa->id)
                    ->firstOrFail();

        $pdf = Pdf::loadView('siswa.gizi.pdf', [
            'siswa' => $siswa,
            'gizi' => $gizi
        ]);

        return $pdf->download('kebutuhan-kalori-'.$siswa->nama.'.pdf');
    }
}
