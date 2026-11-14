<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convertir los valores de asistencia a DECIMAL(8,2).
     * Los valores existentes se conservan y pasan a tener .00.
     */
    public function up(): void
    {
        Schema::table('PER_asistencias_detalles', function (Blueprint $table) {
            $table->decimal('practica', 8, 2)->nullable()->change();
            $table->decimal('guardia', 8, 2)->nullable()->change();
            $table->decimal('citacion', 8, 2)->nullable()->change();
            $table->decimal('total', 8, 2)->nullable()->change();
        });
    }

    /**
     * Volver a SMALLINT puede eliminar decimales.
     */
    public function down(): void
    {
        Schema::table('PER_asistencias_detalles', function (Blueprint $table) {
            $table->smallInteger('practica')->nullable()->change();
            $table->smallInteger('guardia')->nullable()->change();
            $table->smallInteger('citacion')->nullable()->change();
            $table->smallInteger('total')->nullable()->change();
        });
    }
};