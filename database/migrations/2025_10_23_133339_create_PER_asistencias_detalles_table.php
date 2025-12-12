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
        Schema::create('PER_asistencias_detalles', function (Blueprint $table) {
            $table->id('id_asistencia_detalle');
            $table->foreignId('asistencia_id')
                ->constrained('PER_asistencias', 'id_asistencia')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            // FK a personal (tipo int porque así está en tabla 'personal')
            $table->integer('personal_id')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('personal_id')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->smallInteger('practica')->nullable();
            $table->smallInteger('guardia')->nullable();
            $table->smallInteger('citacion')->nullable();
            $table->smallInteger('total')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PER_asistencias_detalles');
    }
};
