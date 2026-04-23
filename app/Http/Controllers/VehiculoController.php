<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function getVehiculos()
    {
        $vehiculos = \App\Models\Vehiculo::with('duenoActual.dueno')->get();

        // Transformamos los datos a un formato que DataTable entienda
        $data = $vehiculos->map(function ($v) {
            return [
                'id' => $v->id,
                'vin' => $v->vin,
                'placas' => $v->placas,
                'modelo' => $v->marca . ' ' . $v->modelo,
                'dueno' => $v->duenoActual ? $v->duenoActual->dueno->nombre_completo : 'Sin dueño',
                'acciones' => '<button class="btn btn-sm btn-info">Editar</button>'
            ];
        });

        return response()->json(['data' => $data]);
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'vin' => 'required|unique:vehicles,vin',
                'placas' => 'required|unique:vehicles,license_plate',
                'dueno_id' => 'required',
                'modelo' => 'required'
            ]);

            // 1. Creamos el vehículo en la tabla 'vehicles'
            $vehiculo = \App\Models\Vehiculo::create([
                'vin' => $request->vin,
                'license_plate' => $request->placas,
                'model' => $request->modelo,
                'brand' => 'Genérica', // O el campo que tengas
            ]);

            // 2. Creamos la relación en 'vehicle_ownership' (Requisito POO)
            \Illuminate\Support\Facades\DB::table('vehicle_ownership')->insert([
                'vehicle_id' => $vehiculo->id,
                'owner_id' => $request->dueno_id,
                'is_current' => true,
                'acquisition_date' => now()
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function buscar(Request $request)
    {
        $request->validate(['termino' => 'required|string']);

        $busqueda = $request->termino;

        // Buscamos el vehículo y cargamos su dueño y sus reportes de robo
        $vehiculo = Vehiculo::with(['dueno', 'reportes'])
            ->where('vin', $busqueda)
            ->orWhere('placas', $busqueda)
            ->first();

        if (!$vehiculo) {
            return response()->json(['error' => 'No se encontró ningún vehículo con esos datos.'], 404);
        }

        return response()->json([
            'vehiculo' => $vehiculo,
            'dueno' => $vehiculo->dueno,
            'tiene_reporte' => $vehiculo->reportes->where('estatus', 'ACTIVO')->count() > 0
        ]);
    }
}
