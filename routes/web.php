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
use App\Http\Controllers\KondisiKesehatanController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\KonsumsiMakananController;
use App\Http\Controllers\KebutuhanKaloriController;
use App\Http\Controllers\Auth\SiswaLoginController;
use App\Http\Controllers\SiswaDashboardController;

use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| LANDING PAGE (GUEST)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('frontend.pages.home');
})->name('landing');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Auth::routes();
/*
|--------------------------------------------------------------------------
| SISWA AUTH
|--------------------------------------------------------------------------
*/
Route::get('/siswa/login', [SiswaLoginController::class, 'showLoginForm'])
    ->name('siswa.login');

Route::post('/siswa/login', [SiswaLoginController::class, 'login'])
    ->name('siswa.login.post');

Route::post('/siswa/logout', [SiswaLoginController::class, 'logout'])
    ->name('siswa.logout');

/*
|--------------------------------------------------------------------------
| SISWA DASHBOARD
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
        ->name('siswa.dashboard');

    Route::get('/rekam-medis', [SiswaDashboardController::class, 'rekamMedis'])
        ->name('siswa.rekam_medis');

    Route::get('/rekam-medis/pdf/{id}', [SiswaDashboardController::class, 'downloadPdf'])
        ->name('siswa.rekam_medis.pdf');

    Route::get('/kebutuhan-kalori/pdf/{id}', [SiswaDashboardController::class, 'kaloriPdf'])
        ->name('siswa.kalori.pdf');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/petugas', [AdminController::class, 'index'])->name('petugas.dashboard');
});


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

    // ADMIN ONLY
    Route::middleware('role:admin')->group(function () {
        Route::resource('user', UserController::class)->only([
            'index', 'create', 'store', 'destroy'
        ]);

        Route::get('log-aktivitas', [LogAktivitasController::class, 'index'])
            ->name('log.index');
    });

    // ADMIN + PETUGAS
    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('siswa', SiswaController::class)->except(['show']);
        Route::resource('kelas', KelasController::class)->except(['show']);
        Route::resource('obat', ObatController::class)->except(['show']);
        Route::resource('jadwal_pemeriksaan', JadwalPemeriksaanController::class)->except(['show']);
        Route::resource('rekam_medis', RekamMedisController::class);
        Route::get('rekam_medis/laporan', [RekamMedisController::class, 'laporan'])
            ->name('rekam_medis.laporan');
        Route::resource('pemeriksaan_gizi', PemeriksaanGiziController::class)->except(['show']);
        Route::resource('kondisi_kesehatan', KondisiKesehatanController::class)->except(['show']);
        Route::resource('makanans', MakananController::class);
        Route::resource('konsumsi_makanan', KonsumsiMakananController::class);
        Route::resource('kebutuhan_kalori', KebutuhanKaloriController::class);
    });
});


/*
|--------------------------------------------------------------------------
| AJAX / HELPER
|--------------------------------------------------------------------------
*/
Route::get('/get-siswa-by-kelas/{kelas_id}', [RekamMedisController::class, 'getSiswaByKelas']);
