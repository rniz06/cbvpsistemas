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
        Schema::create('CCA_servicios_enganchados', function (Blueprint $table) {
            $table->id('id_servicio_enganchado');
            $table->foreignId('servicio_anterior_id')->constrained('CCA_servicios_existentes', 'id_servicio_existente')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('servicio_actual_id')->constrained('CCA_servicios_existentes', 'id_servicio_existente')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('servicio_padre_id')->constrained('CCA_servicios_existentes', 'id_servicio_existente')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('culminado')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CCA_servicios_enganchados');
    }
};
