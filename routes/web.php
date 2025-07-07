<?php

use App\Http\Controllers\IsytiharController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KehadiranController;
use App\Http\Controllers\KelulusanController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenyokongController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TempatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dashboard (All Authenticated Users)
Route::get('/', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil
    Route::resource('profil', ProfilController::class)->names([
        'index' => 'profil'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Routes for Roles: user, supervisor
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:user,supervisor')->group(function () {

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
    });

    /*
    |--------------------------------------------------------------------------
    | Routes for Roles: supervisor
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:supervisor')->group(function () { // Consider changing this to 'role:supervisor' if that's the intent
        // Pengguna Kursus
        Route::resource('kelulusan', KelulusanController::class)->names([
            'index' => 'penyelia-kelulusan'
        ]);
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
        // Urusetia Tempat
        Route::resource('/urusetia/tempat', TempatController::class)->names([
            'index' => 'tetapan-tempat'
        ]);
        // Urusetia Kehadiran
        Route::resource('/urusetia/kehadiran', KehadiranController::class)->names([
            'index' => 'urusetia-kehadiran'
        ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Routes for Roles: administrator & superadmin
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:administrator,superadmin')->group(function () {

        // Urusetia Pengguna
        Route::resource('/urusetia/pengguna', PenggunaController::class)->names([
            'index' => 'urusetia-pengguna'
        ]);
    });

    // ========== Pegawai Penyokong ==========
    Route::resource('pengesahan', PenyokongController::class);

    // ========== Sementara ==========
    Route::put('/update-role', [App\Http\Controllers\ProfilController::class, 'update']);
});

// Require the Breeze authentication routes
require __DIR__ . '/auth.php';