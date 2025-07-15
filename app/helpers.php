<?php

use App\Models\LogAktivitas;

if (! function_exists('logAktivitas')) {
    function logAktivitas($aksi, $tabel = null)
    {
        if (auth()->check()) {
            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aksi'    => $aksi,
                'tabel'   => $tabel,
            ]);
        }
    }
}