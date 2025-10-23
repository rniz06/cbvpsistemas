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
        Schema::create('PER_asistencias', function (Blueprint $table) {
            $table->id('id_asistencia');
            $table->foreignId('compania_id')
                ->constrained('GRAL_companias', 'id_compania')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('periodo_id')
                ->constrained('PER_asistencias_periodos', 'id_asistencia_periodo')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('estado_id')
                ->constrained('PER_asistencias_estados', 'id_asistencia_estado')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PER_asistencias');
    }
};
