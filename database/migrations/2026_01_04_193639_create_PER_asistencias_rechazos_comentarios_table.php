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
        Schema::create('PER_asistencias_comentarios', function (Blueprint $table) {
            $table->id('id_asistencia_comentario');
            $table->string('comentario');
            $table->enum('accion', ['RECHAZO', 'REPORTE'])->default('RECHAZO');
            $table->foreignId('asistencia_id')->constrained('PER_asistencias', 'id_asistencia')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('PER_asistencias_comentarios');
    }
};
