<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\SiswaDashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses tanpa login)
|--------------------------------------------------------------------------
*/
// Taruh login siswa paling atas agar tidak dianggap sebagai ID siswa
Route::post('/siswa/login', [SiswaDashboardController::class, 'login']);
Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Protected Routes (Wajib Login/Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth & Profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Khusus Dashboard Siswa
    Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'getDashboard']);
    Route::get('/siswa/rekam-medis', [SiswaDashboardController::class, 'getRiwayatMedis']);

    // Dashboard Admin/Petugas Stats
    Route::get('/dashboard-stats', [AdminController::class, 'getStats']);
    Route::get('/aktivitas-terbaru', [AdminController::class, 'getAktivitasTerbaru']);
    Route::get('/log-aktivitas', [AdminController::class, 'getLogAktivitas']);

    // Pengelolaan Rekam Medis
    Route::get('/rekam-medis', [AdminController::class, 'getRekamMedis']);
    Route::post('/rekam-medis', [AdminController::class, 'store']);
    Route::post('/rekam-medis/update/{id}', [AdminController::class, 'update']);
    Route::delete('/rekam-medis/{id}', [AdminController::class, 'destroyRekamMedis']);

    // Pengelolaan Siswa (Urutan: List & Store dulu, baru ID)
    Route::get('/siswa', [AdminController::class, 'getAllSiswa']);
    Route::post('/siswa', [AdminController::class, 'storeSiswa']);
    Route::get('/siswa-by-kelas/{kelas_id}', [AdminController::class, 'getSiswaByKelas']);
    Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa']);
    Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa']);

    // Fitur Tambahan
    Route::get('/kelas', [AdminController::class, 'getKelas']);
    Route::get('/akun-siswa', [AdminController::class, 'getDaftarAkunSiswa']);
    Route::post('/kirim-hasil/{user_id}', [AdminController::class, 'kirimHasilApi']);

    // Laporan & Jadwal
    Route::get('/laporan/kunjungan', [AdminController::class, 'laporanKunjungan']);
    Route::get('/laporan/jadwal', [AdminController::class, 'laporanJadwal']);
    Route::get('/laporan/gizi', [AdminController::class, 'laporanGizi']);
    
    Route::get('/jadwal', [AdminController::class, 'getJadwal']);
    Route::post('/jadwal', [AdminController::class, 'storeJadwal']);
    Route::put('/jadwal/{id}', [AdminController::class, 'updateJadwal']);
    Route::delete('/jadwal/{id}', [AdminController::class, 'destroyJadwal']);

    // Obat
    Route::get('/obat', [AdminController::class, 'getObat']);
    Route::post('/obat', [AdminController::class, 'storeObat']);
    Route::put('/obat/{id}', [AdminController::class, 'updateObat']);
    Route::delete('/obat/{id}', [AdminController::class, 'destroyObat']);
});