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
        Schema::create('CCA_operatividad_detalles', function (Blueprint $table) {
            $table->id('id_operatividad_detalle');
            $table->dateTime('fecha_hora');
            $table->integer('acargo')->nullable();
            $table->foreign('acargo')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('acargo_aux', 10)->nullable();
            $table->integer('cant_personal')->default(0);
            $table->integer('cant_conductor')->default(0);
            $table->boolean('equipo_hidraulico')->default(false);
            $table->boolean('pileta')->default(false);
            $table->integer('cant_autonomo')->default(0);
            $table->integer('cant_espuma')->default(0);
            $table->foreignId('compania_id')->nullable()->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('CCA_operatividad_detalles');
    }
};
