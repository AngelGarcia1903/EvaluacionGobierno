<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dueno;
use App\Models\Vehiculo;
use App\Models\ReporteRobo; // Importación explícita para evitar el \App\Models\

class DashboardController extends Controller
{
    /**
     * Muestra el panel principal con estadísticas en tiempo real.
     * Cumple con la Parte 3: Generar clases y métodos correspondientes.
     */
    public function index()
    {
        // Obtención de conteos básicos mediante Eloquent (POO)
        $totalDuenos = Dueno::count();
        $totalVehiculos = Vehiculo::count();
        $totalReportes = ReporteRobo::count();

        // Lógica de Negocio: Índice de robo actual
        $porcentajeRobos = $totalVehiculos > 0
            ? round(($totalReportes / $totalVehiculos) * 100, 1)
            : 0;

        // Lógica de Gestión: Avance respecto a meta mensual (Ejemplo: 100 unidades)
        $metaMensual = 100;
        $porcentajeMeta = $totalVehiculos > 0
            ? round(($totalVehiculos / $metaMensual) * 100, 1)
            : 0;

        // Promedio de vehículos por cada dueño registrado
        $promedioPorDueno = $totalDuenos > 0
            ? round(($totalVehiculos / $totalDuenos), 2)
            : 0;

        // Retornamos la vista dashboard (asegúrate que la ruta en views sea dashboard.index o dashboard)
        return view('dashboard.index', compact(
            'totalDuenos',
            'totalVehiculos',
            'totalReportes',
            'porcentajeRobos',
            'porcentajeMeta',
            'promedioPorDueno'
        ));
    }
}
