<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dueno extends Model
{
    protected $table = 'owners';

    // Cambiamos a true para llevar registro de creación/edición
    public $timestamps = false;

    protected $fillable = ['full_name', 'curp_rfc', 'phone', 'calle', 'colonia', 'num_ext', 'num_int'];
}
