<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('PER_asistencias_rectificaciones', function (Blueprint $table) {
            $table->id('id_rectificacion');

            $table->unsignedBigInteger('asistencia_detalle_id');
            $table->unsignedBigInteger('asistencia_id');
            $table->unsignedInteger('personal_id');

            $table->unsignedBigInteger('usuario_id')->nullable();

            $table->text('observacion');

            $table->json('valores_anteriores');
            $table->json('valores_nuevos');

            $table->timestamp('created_at')->useCurrent();

            $table->index('asistencia_detalle_id');
            $table->index('personal_id');
            $table->index('usuario_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('PER_asistencias_rectificaciones');
    }
};