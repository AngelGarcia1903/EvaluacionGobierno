<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabla de Vehículos
        // 1. Tabla de Vehículos (Sin timestamps)
        Schema::create('vehicles', function ($table) {
            $table->id();
            $table->string('vin', 17)->unique();
            $table->string('license_plate', 10)->unique();
            $table->string('brand');
            $table->string('model');
            $table->integer('year_model')->nullable(); // Cambiamos a integer para evitar el error de rango
            $table->string('color')->nullable();
        });

        // 2. Tabla de Dueños
        // 2. Tabla de Dueños (Actualizada)
        Schema::create('owners', function ($table) {
            $table->id();
            $table->string('full_name');
            $table->string('curp_rfc', 20)->unique();
            $table->string('phone', 15)->nullable();
            // Campos de dirección detallada
            $table->string('calle');
            $table->string('colonia');
            $table->string('num_ext', 10);
            $table->string('num_int', 10)->nullable();
            $table->timestamps(); // Es mejor habilitarlos para saber cuándo se registró el dueño
        });
        // 3. Historial (Tabla Pivote)
        Schema::create('vehicle_ownership', function ($table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->boolean('is_current')->default(false);
            $table->date('acquisition_date')->nullable();
        });

        // 4. Reportes de Robo
        Schema::create('theft_reports', function ($table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->string('report_number')->unique()->nullable();
            $table->text('description');
            $table->dateTime('report_date');
            $table->enum('status', ['active', 'recovered'])->default('active');
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
