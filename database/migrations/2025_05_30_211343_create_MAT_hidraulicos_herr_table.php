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
        Schema::create('MAT_hidraulicos_herr', function (Blueprint $table) {
            $table->id('id_hidraulico_herr');
            $table->integer('serie')->nullable();
            $table->boolean('operativo')->nullable()->default(true);
            $table->foreignId('hidraulico_id')->nullable()->references('id_hidraulico')->on('MAT_hidraulicos')->onDelete('cascade');
            $table->foreignId('marca_id')->nullable()->references('idhidraulico_herr_marca')->on('MAT_hidraulicos_herr_marcas')->onDelete('cascade');
            $table->foreignId('modelo_id')->nullable()->references('idhidraulico_herr_modelo')->on('MAT_hidraulicos_herr_modelos')->onDelete('cascade');
            $table->foreignId('motor_id')->nullable()->references('idhidraulico_herr_motor')->on('MAT_hidraulicos_herr_motor')->onDelete('cascade');
            $table->foreignId('tipo_id')->nullable()->references('idhidraulico_herr_tipo')->on('MAT_hidraulicos_herr_tipos')->onDelete('cascade');
            $table->foreignId('operatividad_id')->nullable()->references('id_operatividad')->on('MAT_operatividad')->onDelete('cascade');
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
        Schema::dropIfExists('MAT_hidraulicos_herr');
    }
};
