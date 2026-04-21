<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas (Módulos de consulta y catálogos)
Route::middleware(['check.session'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Esta será tu pantalla principal post-login
    })->name('dashboard');

    // Aquí irán las rutas de los catálogos y búsquedas [cite: 14, 21]
});
