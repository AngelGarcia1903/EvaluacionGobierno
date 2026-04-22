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
}
