<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialDueno extends Model
{
    protected $table = 'vehicle_ownership';
    public $timestamps = false;

    protected $fillable = [
        'vehicle_id',
        'owner_id',
        'is_current',
        'acquisition_date'
    ];

    // Relación inversa con el propietario
    public function dueno()
    {
        return $this->belongsTo(Dueno::class, 'owner_id');
    }
}
