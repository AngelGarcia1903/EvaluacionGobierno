<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    public function historial()
    {
        return $this->hasMany(HistorialDueno::class, 'vehiculo_id');
    }

    public function duenoActual()
    {
        return $this->hasOne(HistorialDueno::class, 'vehiculo_id')->where('es_dueno_actual', true);
    }
}
