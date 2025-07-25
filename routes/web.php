<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsytiharController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PegawaiLatihanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenyokongController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Settings\BahagianController;
use App\Http\Controllers\Settings\JabatanController;
use App\Http\Controllers\Settings\KategoriController;
use App\Http\Controllers\Settings\KumpulanController;
use App\Http\Controllers\Settings\PenganjurController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\Settings\TempatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Pegawai Penyokong
Route::get('/pengesahan/{id}', [PenyokongController::class, 'show'])
    ->middleware('signed')
    ->name('pengesahan.show');
Route::post('/pengesahan', [PenyokongController::class, 'store'])->name('pengesahan.store');

// Dashboard (All Authenticated Users)
Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Pegawai Penyokong
Route::get('/pengesahan/{id}', [PenyokongController::class, 'show'])->name('pengesahan.show');
Route::post('/pengesahan', [PenyokongController::class, 'store'])->name('pengesahan.store');

Route::middleware('auth')->group(function () {
    // Profil
    Route::resource('profil', ProfilController::class)->names([
        'index' => 'profil'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Routes for Roles: user, supervisor, administrator
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user,supervisor,administrator')->group(function () {

        // Pengguna Kursus
        Route::resource('kursus', KatalogController::class)->names([
            'index' => 'kursus'
        ]);
        // Pengguna Permohonan
        Route::resource('permohonan', StatusController::class)->names([
            'index' => 'permohonan'
        ]);
        // Pengguna Isytihar
        Route::resource('isytihar', IsytiharController::class)->names([
            'index' => 'isytihar'
        ]);
        // Rekod Kursus
        Route::get('/rekod/kursus', [LaporanController::class, 'rekodKursus'])->name('rekod-kursus');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes for Roles: supervisor
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:supervisor')->group(function () {
        // Pengguna Kursus
        Route::resource('kelulusan', KelulusanController::class)->names([
            'index' => 'plb-kelulusan'
        ]);
        Route::any('/rekod-baru', [PegawaiLatihanController::class, 'rekodBaru'])->name('plb-rekod-baru');
        Route::get('/rekod-pegawai', [PegawaiLatihanController::class, 'rekodPegawai'])->name('plb-rekod-pegawai');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes for Roles: administrator
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:administrator')->group(function () {

        // Urusetia Kursus
        Route::resource('/urusetia/kursus', KursusController::class)->names([
            'index' => 'urusetia-kursus'
        ]);
        // Urusetia Permohonan
        Route::resource('/urusetia/permohonan', PermohonanController::class)->names([
            'index' => 'urusetia-permohonan'
        ]);
        Route::post('/urusetia/permohonan/batch-update', [PermohonanController::class, 'batchUpdate']);

        // Urusetia Kehadiran
        Route::resource('/urusetia/kehadiran', KehadiranController::class)->names([
            'index' => 'urusetia-kehadiran'
        ]);
        // Urusetia Pengguna
        Route::resource('/urusetia/pengguna', PenggunaController::class)->names([
            'index' => 'urusetia-pengguna'
        ]);

        // ========== Laporan ==========
        // Laporan Kumpulan
        Route::get('/laporan/kumpulan', [LaporanController::class, 'rekodKumpulan'])->name('laporan-kumpulan');
        // Laporan Bahagian
        Route::get('/laporan/bahagian', [LaporanController::class, 'rekodBahagian'])->name('laporan-bahagian');
        // Laporan Keseluruhan
        Route::get('/laporan/keseluruhan', [LaporanController::class, 'rekodKeseluruhan'])->name('laporan-keseluruhan');
        // Laporan Individu
        Route::get('/laporan/individu', [LaporanController::class, 'rekodIndividu'])->name('laporan-individu');

        // ========== Tetapan ==========
        Route::resource('tetapan/bahagian', BahagianController::class)->names(['index' => 'tetapan-bahagian']);
        Route::resource('tetapan/jabatan', JabatanController::class)->names(['index' => 'tetapan-jabatan']);
        Route::resource('tetapan/kategori', KategoriController::class)->names(['index' => 'tetapan-kategori']);
        Route::resource('tetapan/kumpulan', KumpulanController::class)->names(['index' => 'tetapan-kumpulan']);
        Route::resource('tetapan/penganjur', PenganjurController::class)->names(['index' => 'tetapan-penganjur']);
        Route::resource('tetapan/tempat', TempatController::class)->names(['index' => 'tetapan-tempat']);
    });

    // ========== Sementara ==========
    Route::put('/update-role', [App\Http\Controllers\ProfilController::class, 'update']);
});

// Require the Breeze authentication routes
require __DIR__ . '/auth.php';
