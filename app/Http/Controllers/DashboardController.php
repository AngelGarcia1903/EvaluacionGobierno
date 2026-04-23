<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dueno;
use App\Models\Vehiculo;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Totales Reales (Estos funcionan porque las tablas existen)
        $totalDuenos = Dueno::count();
        $totalVehiculos = Vehiculo::count();
        $totalReportes = \App\Models\ReporteRobo::count();

        // 2. Lógica de Porcentajes (Simulada o basada en otros datos para evitar el error de columna)
        // Como no tienes 'created_at', no podemos saber qué mes se registró cada uno.
        // Pondremos valores fijos o basados en la relación de datos para que no truene.
        $porcentajeCrecimiento = 100; // Valor por defecto

        // 3. Relación Vehículo/Dueño (Esto sí es real)
        $promedioPorDueno = $totalDuenos > 0 ? round(($totalVehiculos / $totalDuenos), 2) : 0;

        return view('dashboard', compact(
            'totalDuenos',
            'totalVehiculos',
            'totalReportes',
            'porcentajeCrecimiento',
            'promedioPorDueno'
        ));
    }
}
