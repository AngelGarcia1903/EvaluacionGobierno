<?php

namespace App\Http\Controllers;

use App\Models\ReporteRobo;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    // Vista principal de reportes
    public function index()
    {
        return view('catalogos.reportes');
    }

    // Datos para DataTables vía AJAX
    public function getReportesData()
    {
        // Usamos Eager Loading para traer la relación del vehículo
        $reportes = ReporteRobo::with('vehiculo')->get();
        return response()->json(['data' => $reportes]);
    }

    // Método POO para dar de alta un reporte de robo
    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|exists:vehiculos,id',
            'fecha_reporte' => 'required|date',
            'descripcion' => 'required'
        ]);

        ReporteRobo::create($request->all());

        return response()->json(['success' => 'Reporte de robo registrado exitosamente.']);
    }
}
