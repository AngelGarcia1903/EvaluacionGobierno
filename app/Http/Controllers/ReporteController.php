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
                'vehiculo_id' => 'required|exists:vehicles,id',
                'fecha_reporte' => 'required|date',
                'descripcion' => 'required|string'
            ]);

            // Generamos un número de reporte único (Ej: REP-202405-1234)
            $folio = 'REP-' . date('Ym') . '-' . rand(1000, 9999);

            ReporteRobo::create([
                'vehicle_id'    => $request->vehiculo_id,
                'report_number' => $folio, // Agregamos el campo faltante
                'report_date'   => $request->fecha_reporte,
                'description'   => $request->descripcion,
                'status'        => 'ACTIVO'
            ]);

            return response()->json(['success' => 'El reporte ha sido registrado con el folio: ' . $folio]);
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
        $reportes = ReporteRobo::with('vehiculo')->get()->map(function ($item) {
            return [
                'id'            => $item->id, // ESTO ES VITAL PARA LOS BOTONES
                'license_plate' => $item->vehiculo->license_plate ?? 'N/A',
                'model'         => $item->vehiculo->model ?? 'N/A',
                'report_date'   => $item->report_date,
                'description'   => $item->description
            ];
        });

        return response()->json(['data' => $reportes]);
    }

    // Funciones nuevas para Editar, Actualizar y Eliminar:
    public function edit($id)
    {
        return response()->json(ReporteRobo::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vehiculo_id' => 'required|exists:vehicles,id',
            'fecha_reporte' => 'required|date',
            'descripcion' => 'required|string'
        ]);

        $reporte = ReporteRobo::findOrFail($id);
        $reporte->update([
            'vehicle_id'  => $request->vehiculo_id,
            'report_date' => $request->fecha_reporte,
            'description' => $request->descripcion
        ]);

        return response()->json(['success' => 'Reporte actualizado exitosamente.']);
    }

    public function destroy($id)
    {
        ReporteRobo::destroy($id);
        return response()->json(['success' => true]);
    }
}
