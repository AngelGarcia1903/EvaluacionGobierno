<?php

namespace App\Http\Controllers;

use App\Models\Dueno;
use Illuminate\Http\Request;

class DuenoController extends Controller
{
    // Carga la vista principal del catálogo
    public function index()
    {
        return view('catalogos.duenos');
    }

    // Método para obtener datos vía AJAX (Requerimiento examen)
    public function getDuenosData()
    {
        $duenos = Dueno::all();
        return response()->json(['data' => $duenos]);
    }

    // Método POO para insertar (Alta)
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'curp' => 'required|unique:duenos,curp'
        ]);

        Dueno::create($request->all());

        return response()->json(['success' => 'Dueño registrado correctamente.']);
    }
}
