<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('consultas.buscador');
    }

    public function buscar(Request $request)
    {
        $termino = $request->input('termino');

        $vehiculo = Vehiculo::with(['duenos', 'reportes'])
            ->where('license_plate', $termino)
            ->orWhere('vin', $termino)
            ->first();

        if (!$vehiculo) {
            return response()->json(['error' => 'El vehículo no está en la base de datos municipal.'], 404);
        }

        return response()->json([
            'vehiculo' => [
                'marca'  => $vehiculo->brand,      // Corregido
                'modelo' => $vehiculo->model,
                'anio'   => $vehiculo->year_model, // Corregido
                'placa'  => $vehiculo->license_plate,
                'vin'    => $vehiculo->vin,
                'color'  => $vehiculo->color ?? 'S/M'
            ],
            'duenos' => $vehiculo->duenos->map(function ($dueno) {
                return [
                    'nombre' => $dueno->full_name,
                    'identificacion' => $dueno->curp_rfc,
                    // Usamos acquisition_date en lugar de created_at
                    'fecha_asociacion' => $dueno->pivot->acquisition_date
                        ? Carbon::parse($dueno->pivot->acquisition_date)->format('d/m/Y')
                        : 'N/D',
                    'es_actual' => $dueno->pivot->is_current
                ];
            }),
            'reporte' => $vehiculo->reportes->where('status', 'ACTIVO')->first()
        ]);
    }
}
