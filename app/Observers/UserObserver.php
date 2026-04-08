<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
        // Jika role-nya siswa, bahasanya "Menghubungkan"
        if ($user->role === 'siswa') {
            logAktivitas("Menghubungkan Akun Siswa: {$user->name}", 'users');
        } else {
            // Jika admin/petugas, bahasanya "Membuat Akun Baru"
            logAktivitas("Membuat Akun Petugas: {$user->name} (Role: {$user->role})", 'users');
        }
    }

    public function deleted(User $user)
    {
        // Tambahin role-nya pas dihapus biar jelas siapa yang ilang
        logAktivitas("Menghapus Akun: {$user->name} (Role: {$user->role})", 'users');
    }
}
