<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\JadwalPemeriksaanController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PemeriksaanGiziController;
use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| AUTH & DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/petugas', [AdminController::class, 'index'])->name('petugas.dashboard');


/*
|--------------------------------------------------------------------------
| LAPORAN (GLOBAL)
|-------------------------\-------------------------------------------------
*/
Route::get('/laporan/jadwal-pemeriksaan', [JadwalPemeriksaanController::class, 'laporan'])
    ->name('jadwal_pemeriksaan.laporan');

Route::get('/laporan/jadwal-pemeriksaan/export/pdf', [JadwalPemeriksaanController::class, 'exportPdf'])
    ->name('jadwal_pemeriksaan.export.pdf');

Route::get('/rekam-medis/export/pdf', function (\Illuminate\Http\Request $request) {
    $awal  = $request->tanggal_awal;
    $akhir = $request->tanggal_akhir;

    $rekam_medis = RekamMedis::with('siswa.kelas')
        ->whereBetween('tanggal', [$awal, $akhir])
        ->get();

    $pdf = Pdf::loadView('backend.rekam_medis.pdf', compact('rekam_medis', 'awal', 'akhir'));
    return $pdf->download('laporan-rekam-medis.pdf');
})->name('rekam_medis.export.pdf');

Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])
    ->name('rekam_medis.export.excel');


/*
|--------------------------------------------------------------------------
| BACKEND (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('backend')->name('backend.')->group(function () {

    /*
    | ADMIN ONLY
    */
    Route::middleware('role')->group(function () {
        Route::resource('user', UserController::class)->only([
            'index', 'create', 'store', 'destroy'
        ]);

        Route::get('log-aktivitas', [LogAktivitasController::class, 'index'])
            ->name('log.index');
    });

    /*
    | UMUM
    */
    Route::resource('siswa', SiswaController::class)->except(['show']);
    Route::get('siswa/search', [SiswaController::class, 'search'])
        ->name('siswa.search');

    Route::resource('kelas', KelasController::class)->except(['show']);
    Route::resource('obat', ObatController::class)->except(['show']);
    Route::resource('jadwal_pemeriksaan', JadwalPemeriksaanController::class)->except(['show']);
    Route::resource('rekam_medis', RekamMedisController::class)->except(['show']);

    Route::get('rekam_medis/laporan', [RekamMedisController::class, 'laporan'])
        ->name('rekam_medis.laporan');
    Route::resource('pemeriksaan_gizi', PemeriksaanGiziController::class)->except(['show']);
});


/*
|--------------------------------------------------------------------------
| AJAX / HELPER
|--------------------------------------------------------------------------
*/
Route::get('/get-siswa-by-kelas/{kelas_id}', [RekamMedisController::class, 'getSiswaByKelas']);
