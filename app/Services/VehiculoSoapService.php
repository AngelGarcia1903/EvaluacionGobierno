<?php

namespace App\Services;

use App\Models\Vehiculo;

class VehiculoSoapService
{
    /**
     * Este es el método que será expuesto por SOAP
     */
    public function obtenerHistorialVehiculo($termino)
    {
        $vehiculo = Vehiculo::with(['duenos', 'reportes'])
            ->where('license_plate', $termino)
            ->orWhere('vin', $termino)
            ->first();

        // Si no existe, regresamos un arreglo con el mensaje
        if (!$vehiculo) {
            return ['estatus' => 'ERROR', 'mensaje' => 'El vehiculo no se encuentra en la base de datos municipal.'];
        }

        // Armamos el historial de dueños
        $historialDuenos = [];
        foreach ($vehiculo->duenos as $dueno) {
            $historialDuenos[] = [
                'nombre' => $dueno->full_name,
                'curp' => $dueno->curp_rfc,
                'estado' => $dueno->pivot->is_current ? 'Dueño Actual' : 'Dueño Anterior'
            ];
        }

        $reporteActivo = $vehiculo->reportes->where('status', 'ACTIVO')->first();

        // Retornamos toda la información estructurada
        return [
            'estatus' => 'OK',
            'vehiculo' => [
                'placa' => $vehiculo->license_plate,
                'vin' => $vehiculo->vin,
                'marca' => $vehiculo->brand,
                'modelo' => $vehiculo->model,
                'anio' => $vehiculo->year_model
            ],
            'alerta_robo' => $reporteActivo ? 'CON REPORTE DE ROBO: ' . $reporteActivo->description : 'SIN REPORTE',
            'historial_duenos' => $historialDuenos
        ];
    }
}
