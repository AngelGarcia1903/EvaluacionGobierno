<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    // Forzamos el nombre de la tabla de tu SQL
    protected $table = 'vehicles';

    // Desactivamos timestamps porque tu SQL no tiene updated_at
    public $timestamps = false;

    // Definimos los campos que se pueden llenar (coinciden con tu SQL)
    protected $fillable = ['vin', 'license_plate', 'brand', 'model', 'year_model', 'color'];

    // Relación con el historial (Tabla vehicle_ownership)
    public function historial()
    {
        // El segundo parámetro es la llave foránea en la tabla pivote
        return $this->hasMany(HistorialDueno::class, 'vehicle_id');
    }

    // Relación para obtener el dueño actual
    public function duenoActual()
    {
        // Cambiamos 'es_dueno_actual' por 'is_current' según tu SQL
        return $this->hasOne(HistorialDueno::class, 'vehicle_id')->where('is_current', true);
    }

    // Relación directa con los reportes de robo
    public function reportes()
    {
        return $this->hasMany(ReporteRobo::class, 'vehicle_id');
    }

    // MEJORA: Esta relación permite obtener directamente la lista de objetos "Dueno"
    public function duenos()
    {
        return $this->belongsToMany(Dueno::class, 'vehicle_ownership', 'vehicle_id', 'owner_id')
            ->withPivot('is_current', 'acquisition_date');
    }
}
