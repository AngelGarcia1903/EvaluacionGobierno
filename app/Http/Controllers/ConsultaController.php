<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('consultas.buscador');
    }

    public function buscar(Request $request)
    {
        $termino = $request->input('termino');

        // POO: Buscamos el vehículo con sus relaciones (Dueños y Reportes)
        // Usamos eager loading para optimizar la consulta
        $vehiculo = Vehiculo::with(['duenos', 'reportes'])
            ->where('license_plate', $termino)
            ->orWhere('vin', $termino)
            ->first();

        if (!$vehiculo) {
            return response()->json(['error' => 'Vehículo no encontrado'], 404);
        }

        // Estructuramos la respuesta JSON para el frontend
        return response()->json([
            'vehiculo' => [
                'marca' => $vehiculo->make,
                'modelo' => $vehiculo->model,
                'anio' => $vehiculo->year,
                'placa' => $vehiculo->license_plate,
                'vin' => $vehiculo->vin,
                'color' => $vehiculo->color
            ],
            'duenos' => $vehiculo->duenos->map(function ($dueno) {
                return [
                    'nombre' => $dueno->full_name,
                    'identificacion' => $dueno->curp_rfc,
                    'fecha_asociacion' => $dueno->pivot->created_at->format('d/m/Y'),
                    'es_actual' => $dueno->pivot->is_current // Asumiendo campo en tabla pivote
                ];
            }),
            'reporte' => $vehiculo->reportes->where('status', 'ACTIVO')->first()
        ]);
    }
}
