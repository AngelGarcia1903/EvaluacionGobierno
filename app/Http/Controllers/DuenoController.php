<?php

namespace App\Http\Controllers;

use App\Models\Dueno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DuenoController extends Controller
{
    /**
     * Muestra la vista del catálogo de dueños.
     * Parte 3: Diseño de módulo de captura. [cite: 14]
     */
    public function index()
    {
        return view('catalogos.duenos.index');
    }

    /**
     * Retorna los datos en JSON para la DataTable.
     * Requisito: Consulta mediante AJAX y JSON totalmente permitida.
     */
    public function getDuenosData()
    {
        // Obtenemos todos los registros usando Eloquent (POO)
        $duenos = Dueno::all();
        return response()->json(['data' => $duenos]);
    }

    public function destroy($id)
    {
        Dueno::destroy($id);
        return response()->json(['success' => true]);
    }

    /**
     * Almacena un nuevo dueño en el sistema.
     * Aplica validaciones para mantener la integridad de la base de datos. [cite: 4]
     */
    public function store(Request $request)
    {
        // Usamos el validador manual para controlar la respuesta en caso de error AJAX
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:150',
            'curp_rfc'  => 'required|string|unique:owners,curp_rfc',
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Los datos son inválidos o el CURP ya existe.'], 422);
        }

        try {
            Dueno::create($request->all());
            return response()->json(['success' => 'Propietario registrado con éxito.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en el servidor.'], 500);
        }
    }

    public function edit($id)
    {
        return response()->json(Dueno::find($id));
    }

    public function update(Request $request, $id)
    {
        // 1. Validar los datos (igual que en store, pero exceptuando el RFC actual)
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:150',
            'curp_rfc'  => 'required|string|unique:owners,curp_rfc,' . $id,
            'phone'     => 'required|string|max:10',
            'calle'     => 'required|string',
            'colonia'   => 'required|string',
            'num_ext'   => 'required|string',
            'num_int'   => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Datos inválidos o CURP ya registrado por otro usuario.'], 422);
        }

        try {
            // 2. Buscar al dueño y actualizar
            $dueno = Dueno::findOrFail($id);

            // Si el checkbox de num_int no se mandó, lo ponemos como null
            $data = $request->all();
            if (!$request->has('num_int')) {
                $data['num_int'] = null;
            }

            $dueno->update($data);

            return response()->json(['success' => 'Propietario actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno al actualizar.'], 500);
        }
    }
}
