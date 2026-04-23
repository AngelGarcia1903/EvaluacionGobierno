<?php

namespace App\Http\Controllers;

use App\Models\Dueno;
use Illuminate\Http\Request;

class DuenoController extends Controller
{
    public function index()
    {
        return view('catalogos.duenos');
    }

    public function getDuenosData()
    {
        // Obtenemos todos los dueños usando POO
        $duenos = Dueno::all();
        return response()->json(['data' => $duenos]);
    }

    public function store(Request $request)
    {
        // Validamos usando los nombres que vienen del formulario (SQL)
        $request->validate([
            'full_name' => 'required|string|max:150',
            'curp_rfc'  => 'required|string|unique:owners,curp_rfc',
            'phone'     => 'nullable|string|max:15',
            'address'   => 'nullable|string'
        ]);

        // Creamos el registro en la tabla owners
        \App\Models\Dueno::create([
            'full_name' => $request->full_name,
            'curp_rfc'  => $request->curp_rfc,
            'phone'     => $request->phone,
            'address'   => $request->address,
        ]);

        return response()->json(['success' => 'Propietario registrado con éxito.']);
    }
}
