<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;

class VehiculoController extends Controller
{
    public function index()
    {
        // Simplemente retorna la vista. La lista se cargará por AJAX.
        return view('vehiculos.index');
    }
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

    // En VehiculoController.php

    public function getVehiculosData()
    {
        // IMPORTANTE: Forzamos la respuesta limpia de la tabla 'vehicles'
        // sin relaciones pesadas para que el conteo en JS sea instantáneo.
        $vehiculos = \App\Models\Vehiculo::all();
        return response()->json(['data' => $vehiculos]);
    }

    public function store(Request $request)
    {
        try {
            // Asegúrate de que los nombres de las columnas coincidan con tu DB manual
            $vehiculo = \App\Models\Vehiculo::create([
                'vin' => $request->vin,
                'license_plate' => $request->placas,
                'model' => $request->modelo,
                'brand' => 'Genérica',
            ]);

            // Guardamos la relación
            \Illuminate\Support\Facades\DB::table('vehicle_ownership')->insert([
                'vehicle_id' => $vehiculo->id,
                'owner_id' => $request->dueno_id,
                'is_current' => true,
                'acquisition_date' => now()
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Si hay un error 500, aquí lo atrapamos para que no rompa el JS
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
