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

    public function destroy($id)
    {
        $log = LogAktivitas::findOrFail($id);
        $log->delete();

        return redirect()->back()->with('success', 'Log aktivitas berhasil dihapus.');
    }

    public function deleteAll()
    {
        LogAktivitas::truncate(); // Ini akan mengosongkan seluruh isi tabel
        
        // Opsional: Catat bahwa admin baru saja membersihkan log
        logAktivitas("Membersihkan seluruh riwayat log aktivitas", 'log_aktivitas');

        return redirect()->back()->with('success', 'Semua riwayat log telah dibersihkan.');
    }
}
