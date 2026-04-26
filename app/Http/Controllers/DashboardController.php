<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dueno;
use App\Models\Vehiculo;
use App\Models\ReporteRobo;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDuenos = Dueno::count();
        $totalVehiculos = Vehiculo::count();
        $totalReportes = ReporteRobo::where('status', 'ACTIVO')->count();

        // KPIs de Lógica de Negocio
        $porcentajeRobos = $totalVehiculos > 0 ? round(($totalReportes / $totalVehiculos) * 100, 1) : 0;
        $metaMensual = 100;
        $porcentajeMeta = $totalVehiculos > 0 ? round(($totalVehiculos / $metaMensual) * 100, 1) : 0;
        $promedioPorDueno = $totalDuenos > 0 ? round(($totalVehiculos / $totalDuenos), 1) : 0;

        // --- DATOS PARA LAS GRÁFICAS ---

        // 1. Vehículos por Marca
        $vehiculosPorMarca = Vehiculo::select('brand', DB::raw('count(*) as total'))
            ->groupBy('brand')
            ->pluck('total', 'brand')
            ->toArray();

        // 2. Estatus de la Flota (Sanos vs Robados)
        $vehiculosSanos = $totalVehiculos - $totalReportes;
        $estatusFlota = [
            'Sin Reporte' => $vehiculosSanos,
            'Con Reporte' => $totalReportes
        ];

        return view('dashboard.index', compact(
            'totalDuenos',
            'totalVehiculos',
            'totalReportes',
            'porcentajeRobos',
            'porcentajeMeta',
            'promedioPorDueno',
            'vehiculosPorMarca',
            'estatusFlota'
        ));
    }
}
