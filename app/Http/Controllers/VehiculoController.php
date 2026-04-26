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
        // Cargamos el vehículo con su "duenoActual" y el "dueno" dentro de ese registro
        $vehiculos = Vehiculo::with(['duenos' => function ($q) {
            $q->wherePivot('is_current', true);
        }])->get();

        return response()->json(['data' => $vehiculos]);
    }

    /**
     * Proceso de Alta (Create) de Vehículo. [cite: 14]
     * Maneja la transacción para asegurar la integridad de la base de datos.
     */
    public function store(Request $request)
    {
        // 1. Validar (Nombres de campos exactos al HTML)
        $request->validate([
            'vin' => 'required|unique:vehicles,vin',
            'license_plate' => 'required|unique:vehicles,license_plate',
            'brand' => 'required',
            'model' => 'required',
            'year_model' => 'required|numeric',
            'owner_id' => 'required|exists:owners,id' // El ID del dueño seleccionado
        ]);

        try {
            // 2. Crear el vehículo
            $vehiculo = Vehiculo::create($request->all());

            // 3. Crear la relación en la tabla pivote (Historial)
            DB::table('vehicle_ownership')->insert([
                'vehicle_id'       => $vehiculo->id,
                'owner_id'         => $request->owner_id,
                'is_current'       => true,
                'acquisition_date' => date('Y-m-d') // Solo la fecha, sin horas ni campos created_at
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'vin' => 'required|unique:vehicles,vin,' . $id,
            'license_plate' => 'required|unique:vehicles,license_plate,' . $id,
            'brand' => 'required',
            'model' => 'required',
            'year_model' => 'required|numeric',
            'owner_id' => 'required|exists:owners,id'
        ]);

        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update($request->all());

        // 1. Buscamos quién es el dueño actual en este momento
        $duenoActual = DB::table('vehicle_ownership')
            ->where('vehicle_id', $id)
            ->where('is_current', true)
            ->first();

        // 2. SOLO si no hay dueño, o si el dueño enviado es DIFERENTE al actual, hacemos el cambio
        if (!$duenoActual || $duenoActual->owner_id != $request->owner_id) {

            // Quitamos el estatus al anterior
            DB::table('vehicle_ownership')
                ->where('vehicle_id', $id)
                ->update(['is_current' => false]);

            // Registramos al nuevo dueño
            DB::table('vehicle_ownership')->insert([
                'vehicle_id'       => $id,
                'owner_id'         => $request->owner_id,
                'is_current'       => true,
                'acquisition_date' => date('Y-m-d')
            ]);
        }

        return response()->json(['success' => true]);
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

    public function edit($id)
    {
        // Cargamos el vehículo con sus dueños para saber cuál es el actual
        $vehiculo = Vehiculo::with('duenos')->findOrFail($id);
        return response()->json($vehiculo);
    }

    public function destroy($id)
    {
        Vehiculo::destroy($id);
        return response()->json(['success' => true]);
    }
}
