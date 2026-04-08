<?php

namespace App\Observers;

use App\Models\Obat;

class ObatObserver
{
    /**
     * Log saat obat baru ditambahkan.
     */
    public function created(Obat $obat): void
    {
        logAktivitas("Menambah Obat Baru: {$obat->nama_obat} ({$obat->stok} {$obat->unit})", 'obat');
    }

    /**
     * Log saat data obat diubah (termasuk stok).
     */
    public function updated(Obat $obat): void
    {
        // Cek kolom apa saja yang berubah
        $changes = array_diff(array_keys($obat->getChanges()), ['updated_at']);

        if (empty($changes)) {
            return;
        }

        // Kalau yang berubah cuma STOK, buat pesan khusus biar jelas
        if (count($changes) === 1 && in_array('stok', $changes)) {
            $stokLama = $obat->getOriginal('stok');
            logAktivitas("Update Stok Obat {$obat->nama_obat}: dari {$stokLama} menjadi {$obat->stok} {$obat->unit}", 'obat');
        } else {
            // Kalau banyak yang berubah (nama, kategori, dll)
            $kolom = implode(', ', $changes);
            logAktivitas("Mengubah data Obat {$obat->nama_obat} (Kolom: {$kolom})", 'obat');
        }
    }

    /**
     * Log saat obat dihapus.
     */
    public function deleted(Obat $obat): void
    {
        logAktivitas("Menghapus Obat: {$obat->nama_obat}", 'obat');
    }
}