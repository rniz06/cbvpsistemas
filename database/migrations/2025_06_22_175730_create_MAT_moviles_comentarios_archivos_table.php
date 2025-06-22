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
        Schema::create('MAT_moviles_comentarios_archivos', function (Blueprint $table) {
            $table->id('idmovil_comentario_archivo');
            $table->foreignId('comentario_id')->constrained('MAT_moviles_comentarios', 'id_movil_comentario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('nombre');
            $table->string('nombre_generado')->nullable();
            $table->string('tamanho')->nullable();
            $table->string('tipo')->nullable();
            $table->text('ruta');
            $table->foreignId('creadoPor')->nullable()->references('id_usuario')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MAT_moviles_comentarios_archivos');
    }
};
