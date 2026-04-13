<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

// Grouping biar rapi
Route::get('/dashboard-stats', [AdminController::class, 'getStats']);
Route::get('/kelas', [AdminController::class, 'getKelas']);
Route::get('/siswa-by-kelas/{kelas_id}', [AdminController::class, 'getSiswaByKelas']);
Route::get('/rekam-medis', [AdminController::class, 'getRekamMedis']);

// BAGIAN REKAM MEDIS 
Route::delete('/rekam-medis/{id}', [AdminController::class, 'destroyRekamMedis']);  
Route::post('/rekam-medis', [AdminController::class, 'store']);      
Route::post('/rekam-medis/update/{id}', [AdminController::class, 'update']); 

// BAGIAN SISWA
Route::get('/siswa', [AdminController::class, 'getAllSiswa']);
Route::post('/siswa', [AdminController::class, 'storeSiswa']);
Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa']);
Route::delete('/siswa/{id}', [AdminController::class, 'destroySiswa']);

Route::get('/akun-siswa', [AdminController::class, 'getDaftarAkunSiswa']);
Route::post('/kirim-hasil/{user_id}', [AdminController::class, 'kirimHasilApi']);

// Laporan
Route::get('/laporan/kunjungan', [AdminController::class, 'laporanKunjungan']);
Route::get('/laporan/jadwal', [AdminController::class, 'laporanJadwal']);
Route::get('/laporan/gizi', [AdminController::class, 'laporanGizi']);

// Jadwal Pemeriksaan
Route::get('/jadwal', [AdminController::class, 'getJadwal']);
Route::post('/jadwal', [AdminController::class, 'storeJadwal']);
Route::put('/jadwal/{id}', [AdminController::class, 'updateJadwal']);
Route::delete('/jadwal/{id}', [AdminController::class, 'destroyJadwal']);

// Obat
Route::get('/obat', [AdminController::class, 'getObat']);
Route::post('/obat', [AdminController::class, 'storeObat']);
Route::put('/obat/{id}', [AdminController::class, 'updateObat']);
Route::delete('/obat/{id}', [AdminController::class, 'destroyObat']);
