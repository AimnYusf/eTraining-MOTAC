<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\IsytiharController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KursusController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PenyokongController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TempatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest Only)
|--------------------------------------------------------------------------
*/

Route::controller(AuthController::class)
    ->middleware('guest')
    ->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/store', 'store')->name('store');
        Route::get('/login', 'login')->name('login');
        Route::post('/authenticate', 'authenticate')->name('authenticate');
    });

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard (All Authenticated Users)
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::resource('profil', ProfilController::class)->names([
        'index' => 'profil'
    ]);

    /*
    |--------------------------------------------------------------------------
    | Routes for Roles: guest, user, supervisor
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:guest,user,supervisor')->group(function () {

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
            'index' => 'urusetia-tempat'
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
});

// ========== Sementara ==========
Route::put('/update-role', [ProfilController::class, 'update']);
Route::get('/test', function () {
    return view('mail.verify-application');
});


// ========== Pegawai Penyokong ==========
Route::resource('pengesahan', PenyokongController::class);
