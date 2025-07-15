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
use App\Models\RekamMedis;

use App\Http\Middleware\Admin;
use App\Http\Middleware\Petugas;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;


//laporan
Route::get('/laporan/jadwal-pemeriksaan', [JadwalPemeriksaanController::class, 'laporan'])
    ->name('jadwal_pemeriksaan.laporan');
Route::get('/laporan/jadwal-pemeriksaan/export/pdf', [JadwalPemeriksaanController::class, 'exportPdf'])
    ->name('jadwal_pemeriksaan.export.pdf');

//pdf kunjungan
Route::get('/rekam-medis/export/pdf', function (\Illuminate\Http\Request $request) {
    $awal  = $request->tanggal_awal;
    $akhir = $request->tanggal_akhir;

    $rekam_medis = RekamMedis::with('siswa.kelas')
        ->whereBetween('tanggal', [$awal, $akhir])
        ->get();

    $pdf = Pdf::loadView('backend.rekam_medis.pdf', compact('rekam_medis', 'awal', 'akhir'));

    return $pdf->download('laporan-rekam-medis.pdf');
})->name('rekam_medis.export.pdf');

//excel kunjungan
Route::get('/rekam-medis/export/excel', [RekamMedisController::class, 'exportExcel'])->name('rekam_medis.export.excel');


Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/petugas', [AdminController::class, 'index'])->name('petugas.dashboard');

Route::middleware(['auth'])->prefix('backend')->group(function () {

    // Blok khusus admin
    Route::group(['middleware' => function ($request, $next) {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }
        return $next($request);
    }], function () {
        Route::resource('user', UserController::class)->names([
            'index' => 'backend.user.index',
            'create' => 'backend.user.create',
            'store' => 'backend.user.store',
            'destroy' => 'backend.user.destroy',
        ]);

        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('backend.log.index');
    });

    // Route umum
    Route::resource('siswa', SiswaController::class)->except(['show']);
    Route::get('siswa/search', [SiswaController::class, 'search'])->name('siswa.search');

    Route::resource('kelas', KelasController::class)->except(['show', 'edit', 'update']);
    Route::resource('obat', ObatController::class)->except(['show']);
    Route::resource('jadwal_pemeriksaan', JadwalPemeriksaanController::class)->except(['show']);
    Route::resource('rekam_medis', RekamMedisController::class)->except(['show']);
    Route::get('rekam_medis/laporan', [RekamMedisController::class, 'laporan'])->name('backend.rekam_medis.laporan');
});

                
//siswa
Route::get('/siswa', [SiswaController::class, 'index'])->name('backend.siswa.index');
Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
Route::post('/siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
Route::post('/siswa/update', [SiswaController::class, 'update'])->name('siswa.update');
Route::delete('/siswa/destroy/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
Route::get('/siswa/search', [SiswaController::class, 'search'])->name('siswa.search');
//kelas
Route::get('/kelas', [KelasController::class, 'index'])->name('backend.kelas.index');
Route::get('/kelas/create', [KelasController::class, 'create'])->name('kelas.create');
Route::post('/kelas/store', [KelasController::class, 'store'])->name('kelas.store');
Route::delete('/kelas/destroy/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

//obat
Route::get('/obat', [ObatController::class, 'index'])->name('backend.obat.index');
Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
Route::post('/obat/store', [ObatController::class, 'store'])->name('obat.store');
Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
Route::post('/obat/update/{id}', [ObatController::class, 'update'])->name('obat.update');
Route::delete('/obat/destroy/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

//jadwal pemeriksaan
Route::get('/jadwal_pemeriksaan', [JadwalPemeriksaanController::class, 'index'])->name('jadwal_pemeriksaan.index');
Route::get('/jadwal_pemeriksaan/create', [JadwalPemeriksaanController::class, 'create'])->name('jadwal_pemeriksaan.create');
Route::post('/jadwal_pemeriksaan/store', [JadwalPemeriksaanController::class, 'store'])->name('jadwal_pemeriksaan.store');
Route::get('/jadwal_pemeriksaan/{id}/edit', [JadwalPemeriksaanController::class, 'edit'])->name('jadwal_pemeriksaan.edit');
Route::put('/jadwal_pemeriksaan/update/{id}', [JadwalPemeriksaanController::class, 'update'])->name('jadwal_pemeriksaan.update');
Route::delete('/jadwal_pemeriksaan/destroy/{id}', [JadwalPemeriksaanController::class, 'destroy'])->name('jadwal_pemeriksaan.destroy');

// rekam medis
Route::get('/rekam_medis', [RekamMedisController::class, 'index'])->name('backend.rekam_medis.index');
Route::get('/rekam_medis/create', [RekamMedisController::class, 'create'])->name('rekam_medis.create');
Route::post('/rekam_medis/store', [RekamMedisController::class, 'store'])->name('rekam_medis.store');
Route::get('/rekam_medis/{id}/edit', [RekamMedisController::class, 'edit'])->name('rekam_medis.edit');
Route::put('/rekam_medis/update/{id}', [RekamMedisController::class, 'update'])->name('rekam_medis.update');
Route::delete('/rekam_medis/destroy/{id}', [RekamMedisController::class, 'destroy'])->name('rekam_medis.destroy');
Route::get('/rekam_medis/laporan', [RekamMedisController::class, 'laporan'])->name('backend.rekam_medis.laporan');