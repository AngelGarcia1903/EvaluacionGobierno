<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dueno;
use App\Models\Vehiculo;

class DashboardController extends Controller
{
    // En DashboardController.php

    public function index()
    {
        $totalDuenos = Dueno::count();
        $totalVehiculos = Vehiculo::count();
        $totalReportes = \App\Models\ReporteRobo::count();

        // Lógica Realista: Porcentaje de vehículos con reporte de robo
        // Esto es un dato real y valioso para un dashboard de gobierno
        $porcentajeRobos = $totalVehiculos > 0
            ? round(($totalReportes / $totalVehiculos) * 100, 1)
            : 0;

        // Lógica de "Meta de Registro": Supongamos que la meta son 100 vehículos
        $metaMensual = 100;
        $porcentajeMeta = round(($totalVehiculos / $metaMensual) * 100, 1);

        $promedioPorDueno = $totalDuenos > 0 ? round(($totalVehiculos / $totalDuenos), 2) : 0;

        return view('dashboard', compact(
            'totalDuenos',
            'totalVehiculos',
            'totalReportes',
            'porcentajeRobos', // Cambiamos el nombre para que sea real
            'porcentajeMeta',  // Esto muestra avance
            'promedioPorDueno'
        ));
    }
}
