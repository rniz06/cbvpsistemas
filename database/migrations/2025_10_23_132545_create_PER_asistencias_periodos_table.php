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
        Schema::create('PER_asistencias_periodos', function (Blueprint $table) {
            $table->id('id_asistencia_periodo');
            $table->foreignId('anho_id')
                ->constrained('GRAL_anhos', 'id_anho')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('mes_id')
                ->constrained('GRAL_meses', 'id_mes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PER_asistencias_periodos');
    }
};
