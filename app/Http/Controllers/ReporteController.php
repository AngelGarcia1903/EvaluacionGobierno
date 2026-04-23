<?php

namespace App\Http\Controllers;

use App\Models\ReporteRobo;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        // Obtenemos solo vehículos que NO tengan reporte activo para el select
        $vehiculos = Vehiculo::all();
        return view('catalogos.reportes', compact('vehiculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required',
            'descripcion' => 'required|string|min:10',
            'fecha_reporte' => 'required|date'
        ]);

        // Usamos una transacción para asegurar que se cree el reporte
        // y se actualice el estado del vehículo al mismo tiempo (Integridad de datos)
        DB::transaction(function () use ($request) {
            ReporteRobo::create([
                'vehiculo_id' => $request->vehiculo_id,
                'descripcion' => $request->descripcion,
                'fecha_reporte' => $request->fecha_reporte,
                'estatus' => 'ACTIVO'
            ]);
        });

        return response()->json(['success' => 'Reporte de robo registrado exitosamente.']);
    }

    public function getReportesData()
    {
        // Eager Loading para traer datos del vehículo y el dueño en una sola consulta
        $reportes = ReporteRobo::with('vehiculo.dueno')->orderBy('created_at', 'desc')->get();
        return response()->json(['data' => $reportes]);
    }
}
