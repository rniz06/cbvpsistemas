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
        Schema::create('CCA_servicios_existentes_comentarios', function (Blueprint $table) {
            $table->id('idservicio_existente_comentario');
            $table->text('comentario')->nullable();
            $table->foreignId('servicio_id')->constrained('CCA_servicios_existentes', 'id_servicio_existente')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('creadoPor')->nullable()->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('actualizadoPor')->nullable()->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CCA_servicios_existentes_comentarios');
    }
};
