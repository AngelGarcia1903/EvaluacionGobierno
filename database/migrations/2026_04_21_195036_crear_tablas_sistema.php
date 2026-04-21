<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla de Vehículos [cite: 21]
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('vin', 17)->unique();
            $table->string('placas', 10)->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->timestamps();
        });

        // Tabla de Dueños [cite: 14]
        Schema::create('duenos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('rfc')->unique();
            $table->timestamps();
        });

        // Historial y Dueño Actual [cite: 2, 21]
        Schema::create('historial_duenos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            $table->foreignId('dueno_id')->constrained('duenos')->onDelete('cascade');
            $table->boolean('es_dueno_actual')->default(false);
            $table->timestamps();
        });

        // Reportes de Robo [cite: 2, 14]
        Schema::create('reportes_robo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            $table->text('detalles');
            $table->boolean('tiene_reporte')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
