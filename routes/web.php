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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;

use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;

/*
|--------------------------------------------------------------------------
| LANDING PAGE (GUEST)
|--------------------------------------------------------------------------
*/
Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');

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
/*
|--------------------------------------------------------------------------
| SISWA DASHBOARD & DATA KESEHATAN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    // Dashboard Utama
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
        ->name('siswa.dashboard');

    // Menu Rekam Medis
    Route::get('/rekam-medis', [SiswaDashboardController::class, 'rekamMedis'])
        ->name('siswa.rekam_medis');
    Route::get('/rekam-medis/pdf/{id}', [SiswaDashboardController::class, 'downloadPdf'])
        ->name('siswa.rekam_medis.pdf');

    // Menu Pemeriksaan Gizi
    Route::get('/pemeriksaan-gizi', [SiswaDashboardController::class, 'pemeriksaanGizi'])
        ->name('siswa.pemeriksaan_gizi');

    // Download PDF Gizi 
    // Saya sarankan name-nya konsisten: siswa.pemeriksaan_gizi.pdf
    Route::get('/pemeriksaan-gizi/pdf/{id}', [SiswaDashboardController::class, 'kaloriPdf'])
        ->name('siswa.pemeriksaan_gizi.pdf'); 
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
        /*
        |------------------------------------------
        | AKUN SISWA (ADMIN ONLY)
        |------------------------------------------
        */
        Route::get('akun-siswa/create', [UserController::class, 'siswaCreate'])
            ->name('akun_siswa.create');

        Route::post('akun-siswa', [UserController::class, 'siswaStore'])
            ->name('akun_siswa.store');
        
        Route::delete('akun-siswa/{id}', [UserController::class, 'siswaDestroy'])
        ->name('akun_siswa.destroy');

    });
    

    // ADMIN + PETUGAS
    Route::middleware('role:admin,petugas')->group(function () {
        
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


        // LIHAT AKUN SISWA (ADMIN & PETUGAS)
        Route::get('akun-siswa', [UserController::class, 'siswaIndex'])
            ->name('akun_siswa.index');

        // PETUGAS: KIRIM HASIL KE SISWA
        Route::post('akun-siswa/{id}/kirim-hasil',
            [UserController::class, 'kirimHasil']
        )->name('user.kirimHasil');

        Route::get('siswa/search', [SiswaController::class, 'search'])->name('siswa.search');
        Route::resource('siswa', SiswaController::class)->except(['show']);
        Route::resource('kelas', KelasController::class)->except(['show']);
        Route::resource('obat', ObatController::class)->except(['show']);
        Route::resource('jadwal_pemeriksaan', JadwalPemeriksaanController::class)->except(['show']);
        Route::patch('pemeriksaan_gizi/{id}/publish',[PemeriksaanGiziController::class, 'publish']
            )->name('pemeriksaan_gizi.publish');
        Route::get('pemeriksaan_gizi/{id}/export-pdf',[PemeriksaanGiziController::class, 'exportPdf']
            )->name('pemeriksaan_gizi.exportPdf');
        Route::get('pemeriksaan_gizi/laporan',[PemeriksaanGiziController::class, 'laporan']
            )->name('pemeriksaan_gizi.laporan');
        Route::get('rekam_medis/laporan', [RekamMedisController::class, 'laporan'])
            ->name('rekam_medis.laporan');
        Route::resource('rekam_medis', RekamMedisController::class);
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
