<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\DuenoController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
*/

// La raíz ahora redirige al formulario de login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');

// Mantenemos /login con GET por si el middleware redirige explícitamente a esa URL
Route::get('/login', [AuthController::class, 'showLogin']);

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren Sesión Activa)
|--------------------------------------------------------------------------
*/
Route::middleware(['check.session'])->group(function () {

    // Panel Principal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- PARTE 3: Catálogos (CRUD) ---
    // Vehículos
    Route::resource('vehiculos', VehiculoController::class);
    Route::get('/api/vehiculos/data', [VehiculoController::class, 'getVehiculosData'])->name('vehiculos.data');

    // Dueños
    Route::resource('duenos', DuenoController::class);
    Route::get('/api/duenos/data', [DuenoController::class, 'getDuenosData'])->name('duenos.data');

    // Reportes de Robo
    Route::resource('reportes', ReporteController::class);
    Route::get('/api/reportes/data', [ReporteController::class, 'getReportesData'])->name('reportes.data');

    // --- PARTE 4: Módulo de Consulta (Buscador VIN/Placa) ---
    Route::get('/consultar', [VehiculoController::class, 'showConsulta'])->name('consulta.index');
    Route::post('/consultar/buscar', [VehiculoController::class, 'buscar'])->name('consulta.buscar');
});
