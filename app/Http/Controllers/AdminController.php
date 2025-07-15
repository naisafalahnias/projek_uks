<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Obat;
use App\Models\RekamMedis;

class AdminController extends Controller
{
    public function index()
    {
        $jumlahSiswa      = Siswa::count();
        $jumlahUser       = User::count();
        $jumlahObat       = Obat::count();
        $jumlahRekamMedis = RekamMedis::count();

        // Ambil data kunjungan per bulan
        $kunjunganPerBulan = RekamMedis::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(tanggal)'))
            ->orderBy(DB::raw('MONTH(tanggal)'))
            ->pluck('total', 'bulan')
            ->toArray();

        // Biar bulan yang belum ada datanya tetap tampil 0
        $dataKunjungan = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataKunjungan[] = $kunjunganPerBulan[$i] ?? 0;
        }

        return view('dashboard.admin', compact(
            'jumlahSiswa',
            'jumlahUser',
            'jumlahObat',
            'jumlahRekamMedis',
            'dataKunjungan'
        ));
    }

}
