<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use App\Models\Dueno;
use Illuminate\Support\Facades\DB;

class VehiculoController extends Controller
{
    /**
     * Muestra la vista principal del catálogo.
     */
    public function index()
    {
        return view('catalogos.vehiculos.index');
    }

    /**
     * Retorna los datos para la DataTable en formato JSON. [cite: 18, 25]
     * Cumple con la Parte 3: Tabla dinámica y consulta AJAX. [cite: 17, 18]
     */
    public function getVehiculosData()
    {
        // Usamos Eager Loading para obtener el dueño actual sin N+1
        $vehiculos = Vehiculo::with(['duenos' => function($query) {
            $query->where('is_current', true);
        }])->get();

        return response()->json(['data' => $vehiculos]);
    }

    /**
     * Proceso de Alta (Create) de Vehículo. [cite: 14]
     * Maneja la transacción para asegurar la integridad de la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vin' => 'required|unique:vehicles,vin',
            'placas' => 'required',
            'dueno_id' => 'required|exists:owners,id',
            'modelo' => 'required'
        ]);

        try {
            DB::beginTransaction();

            // 1. Crear el vehículo usando POO
            $vehiculo = Vehiculo::create([
                'vin' => $request->vin,
                'license_plate' => $request->placas,
                'model' => $request->modelo,
                'brand' => $request->brand ?? 'S/M',
            ]);

            // 2. Registrar el dueño actual en la tabla pivote [cite: 2, 4]
            $vehiculo->duenos()->attach($request->dueno_id, [
                'is_current' => true,
                'acquisition_date' => now()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Vehículo registrado con éxito.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al registrar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Módulo de Consulta (Parte 4).
     * Busca por placa o VIN y regresa historial completo. [cite: 2]
     */
    public function buscar(Request $request)
    {
        $termino = $request->termino;

        // Buscamos con todas sus relaciones para cumplir con el reporte histórico
        $vehiculo = Vehiculo::with(['duenos', 'reportes'])
            ->where('vin', $termino)
            ->orWhere('license_plate', $termino)
            ->first();

        if (!$vehiculo) {
            return response()->json(['error' => 'El vehículo no está en la base de datos.'], 404);
        }

        return response()->json([
            'vehiculo' => $vehiculo,
            'historial_duenos' => $vehiculo->duenos, // Todos los dueños históricos
            'reportes' => $vehiculo->reportes,       // Detalles de robos si existen
            'tiene_robo' => $vehiculo->reportes->count() > 0
        ]);
    }
}
