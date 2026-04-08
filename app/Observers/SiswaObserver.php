<?php

namespace App\Observers;

use App\Models\Siswa;

class SiswaObserver
{
    public function created(Siswa $siswa)
    {
        logAktivitas("Menambah Siswa: {$siswa->nama}", 'siswa');
    }

    public function updated(Siswa $siswa)
    {
        // Daftar kolom yang tidak ingin ditampilkan di log
        $ignoreColumns = ['updated_at', 'created_at', 'user_id'];

        // Ambil perubahan, lalu buang kolom yang ada di list ignore
        $changes = array_diff(array_keys($siswa->getChanges()), $ignoreColumns);

        // Kalau ada perubahan di kolom selain yang di-ignore, baru catat log
        if (!empty($changes)) {
            $kolomDiedit = implode(', ', $changes);
            logAktivitas("Mengubah data Siswa: {$siswa->nama} (Kolom: {$kolomDiedit})", 'siswa');
        }
    }

    public function deleted(Siswa $siswa)
    {
        logAktivitas("Menghapus Siswa: {$siswa->nama}", 'siswa');
    }
}