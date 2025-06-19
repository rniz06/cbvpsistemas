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
        Schema::create('MAT_hidraulicos_comentarios', function (Blueprint $table) {
            $table->id('id_hidraulico_comentario');
            $table->text('comentario')->nullable();
            $table->foreignId('hidraulico_id')->nullable()->references('id_hidraulico')->on('MAT_hidraulicos')->onDelete('cascade');
            $table->foreignId('accion_id')->nullable()->references('id_accion')->on('MAT_acciones')->onDelete('cascade');
            $table->foreignId('creadoPor')->nullable()->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreignId('actualizadoPor')->nullable()->references('id_usuario')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MAT_hidraulicos_comentarios');
    }
};
