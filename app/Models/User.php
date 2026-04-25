<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // AÑADE ESTA LÍNEA para que Laravel no busque 'updated_at'
    public $timestamps = false;

    // Elimina el uso de HasFactory y Notifiable si no los usas para simplificar el código POO.
    protected $fillable = ['username', 'password', 'name'];
    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}
