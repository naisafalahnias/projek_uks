<?php

namespace App\Observers;

use App\Models\RekamMedis;

class RekamMedisObserver
{
    public function created(RekamMedis $rekamMedis)
    {
        $namaSiswa = $rekamMedis->siswa->nama ?? 'Siswa';
        logAktivitas("Menambah Rekam Medis baru untuk siswa: {$namaSiswa}", 'REKAM_MEDIS');
    }

    public function updated(RekamMedis $rekamMedis)
    {
        $namaSiswa = $rekamMedis->siswa->nama ?? 'Siswa';
        logAktivitas("Mengubah data Rekam Medis siswa: {$namaSiswa}", 'REKAM_MEDIS');
    }

    public function deleted(RekamMedis $rekamMedis)
    {
        // Catatan: Karena di Controller kamu hapus manual, 
        // pastikan logAktivitas di Controller kamu hapus biar gak double.
        $namaSiswa = $rekamMedis->siswa->nama ?? 'Siswa';
        logAktivitas("Menghapus data Rekam Medis siswa: {$namaSiswa}", 'REKAM_MEDIS');
    }
}