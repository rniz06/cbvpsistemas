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
        Schema::create('MAT_hidraulicos', function (Blueprint $table) {
            $table->id('id_hidraulico');
            $table->integer('anho')->nullable();
            $table->boolean('operativo')->nullable()->default(true);
            $table->foreignId('marca_id')->nullable()->references('id_hidraulico_marca')->on('MAT_hidraulicos_marcas')->onDelete('cascade');
            $table->foreignId('modelo_id')->nullable()->references('id_hidraulico_modelo')->on('MAT_hidraulicos_modelos')->onDelete('cascade');
            $table->foreignId('motor_id')->nullable()->references('id_hidraulico_motor')->on('MAT_hidraulicos_motor')->onDelete('cascade');
            $table->foreignId('compania_id')->nullable()->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('MAT_hidraulicos');
    }
};
