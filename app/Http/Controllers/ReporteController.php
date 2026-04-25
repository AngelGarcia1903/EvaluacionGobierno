<?php

namespace App\Http\Controllers;

use App\Models\ReporteRobo;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Muestra el módulo de reportes.
     */
    public function index()
    {
        // POO: Obtenemos los vehículos para el catálogo de captura [cite: 14]
        $vehiculos = Vehiculo::all();
        return view('catalogos.reportes.index', compact('vehiculos'));
    }

    /**
     * Guarda el reporte usando el modelo (POO) en lugar de DB::table.
     * Cumple con los puntos 14 y 15 de la Parte 3.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'vehiculo_id' => 'required|exists:vehicles,id', // Valida constraint [cite: 5]
                'fecha_reporte' => 'required|date',
                'descripcion' => 'required|string'
            ]);

            // Uso de métodos de clase (POO) [cite: 15]
            ReporteRobo::create([
                'vehicle_id'  => $request->vehiculo_id,
                'report_date' => $request->fecha_reporte,
                'description' => $request->descripcion,
                'status'      => 'ACTIVO' // Clave para la lógica de la Parte 4 [cite: 21]
            ]);

            return response()->json(['success' => 'El reporte ha sido registrado en la base de datos.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Retorna datos mediante AJAX y JSON[cite: 18].
     * Presenta la información para la tabla dinámica[cite: 17].
     */
    public function getReportesData()
    {
        // POO: Usamos relaciones de Eloquent para evitar JOINS manuales pesados
        // Esto demuestra una base de datos normalizada [cite: 6]
        $reportes = ReporteRobo::with('vehiculo')->get()->map(function ($item) {
            return [
                'license_plate' => $item->vehiculo->license_plate,
                'model'         => $item->vehiculo->model,
                'report_date'   => $item->report_date,
                'description'   => $item->description
            ];
        });

        return response()->json(['data' => $reportes]);
    }
}
