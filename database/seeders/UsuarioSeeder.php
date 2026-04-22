<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiamos la tabla primero para que no haya conflictos
        DB::table('users')->truncate();

        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => md5('12345'), // Cumpliendo requisito MD5
        ]);
    }
}
