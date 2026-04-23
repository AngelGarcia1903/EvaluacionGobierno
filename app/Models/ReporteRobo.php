<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReporteRobo extends Model
{
    protected $table = 'theft_reports';
    public $timestamps = false;
    protected $fillable = ['vehicle_id', 'report_number', 'description', 'report_date', 'status'];
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehicle_id');
    }
}
