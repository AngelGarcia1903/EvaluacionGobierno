<?php

namespace App\Services;

use App\Models\Vehiculo;

class SoapService
{
    /**
     * Retorna el historial completo de un vehículo para el Webservice.
     */
    public function obtenerHistorialVehiculo($termino)
    {
        $vehiculo = Vehiculo::with(['duenos', 'reportes'])
            ->where('license_plate', $termino)
            ->orWhere('vin', $termino)
            ->first();

        if (!$vehiculo) {
            return "Vehículo no encontrado en el sistema de Seguridad Pública.";
        }

        // Estructuramos la respuesta para el cliente SOAP
        $status = $vehiculo->reportes->where('status', 'active')->count() > 0 ? 'CON REPORTE DE ROBO' : 'SIN REPORTE';

        $historial = "Vehículo: {$vehiculo->brand} {$vehiculo->model} | Estatus: {$status}\n";
        $historial .= "Historial de Dueños:\n";

        foreach ($vehiculo->duenos as $dueno) {
            $rol = $dueno->pivot->is_current ? '[ACTUAL]' : '[ANTERIOR]';
            $historial .= "- {$dueno->full_name} ({$dueno->curp_rfc}) {$rol}\n";
        }

        return $historial;
    }
}
