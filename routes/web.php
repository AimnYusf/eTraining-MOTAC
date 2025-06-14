<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// ========== Authentication Routes ==========
Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});

Route::controller(AuthController::class)->middleware('auth')->group(function () {
    Route::post('/logout', 'logout')->name('logout');

    // ========== Dashboard ==========
    Route::get('/', 'dashboard')->name('dashboard');

    Route::get('/example', function () {
        return view('pages.form-validation');
    });
});