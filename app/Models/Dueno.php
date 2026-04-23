<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dueno extends Model
{
    protected $table = 'owners';
    public $timestamps = false;
    protected $fillable = ['full_name', 'curp_rfc', 'phone', 'address'];
}
