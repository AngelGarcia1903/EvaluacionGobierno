<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, VehiculoController, DuenoController, ReporteController, DashboardController, ConsultaController, SoapController};
// --- Rutas Públicas ---
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Rutas Protegidas ---
Route::middleware(['check.session'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Catálogos (CRUD)
    Route::get('/vehiculos/data', [VehiculoController::class, 'getVehiculosData'])->name('vehiculos.data');
    Route::resource('vehiculos', VehiculoController::class);

    Route::get('/duenos/data', [DuenoController::class, 'getDuenosData'])->name('duenos.data');
    // 2. Ruta explícita para guardar (Esto garantiza que /duenos acepte POST)
    Route::post('/duenos', [DuenoController::class, 'store'])->name('duenos.store');
    Route::resource('duenos', DuenoController::class);

    // 1. Ruta para alimentar el DataTable (GET)
    Route::get('/reportes/data', [ReporteController::class, 'getReportesData'])->name('reportes.data');
    // 2. Resource (Automáticamente habilita POST /reportes para el método store)
    Route::resource('reportes', ReporteController::class);

    // Consultas (Parte 4)
    Route::get('/consultar', [ConsultaController::class, 'index'])->name('consulta.index');
    Route::post('/consultas/buscar', [ConsultaController::class, 'buscar'])->name('consulta.buscar');
});

// --- Webservice SOAP (Sin CSRF y fuera de sesión) ---
// Usa PreventRequestForgery que es el nombre moderno en Laravel 11
Route::post('/api/soap-server', [SoapController::class, 'handle'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class]);
