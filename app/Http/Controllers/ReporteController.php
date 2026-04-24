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
        try {
            // 1. Validar con los nombres exactos de tu formulario HTML
            $request->validate([
                'vehiculo_id' => 'required',
                'fecha_reporte' => 'required|date',
                'descripcion' => 'required|string'
            ]);

            // 2. Insertar en la tabla que definiste en la Parte 1
            // Nota: Asegúrate de que los nombres de las columnas (ej: vehicle_id)
            // sean los que creaste en MySQL.
            \Illuminate\Support\Facades\DB::table('theft_reports')->insert([
                'vehicle_id' => $request->vehiculo_id,
                'report_date' => $request->fecha_reporte,
                'description' => $request->descripcion,
                'status'      => 'ACTIVO'
            ]);

            return response()->json(['success' => 'El reporte ha sido registrado en la base de datos.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getReportesData()
    {
        // Obtenemos los reportes uniendo con la tabla de vehículos para mostrar datos útiles
        $reportes = \Illuminate\Support\Facades\DB::table('theft_reports')
            ->join('vehicles', 'theft_reports.vehicle_id', '=', 'vehicles.id')
            ->select('theft_reports.*', 'vehicles.license_plate', 'vehicles.model')
            ->get();

        return response()->json(['data' => $reportes]);
    }
}
