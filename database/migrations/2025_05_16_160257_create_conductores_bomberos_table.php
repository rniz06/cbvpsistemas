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
        Schema::create('conductores_bomberos', function (Blueprint $table) {
            $table->id('id_conductor_bombero');
            $table->integer('personal_id')->nullable();
            $table->foreignId('estado_id')->nullable()->references('id_conductor_estado')->on('conductores_estados')->onDelete('set null');
            $table->string('resolucion', 50)->nullable();
            $table->string('resolucion_enlace')->nullable();
            $table->date('fecha_curso')->nullable();
            $table->integer('ciudad_curso_id')->nullable();
            $table->integer('ciudad_licencia_id')->nullable();
            $table->foreignId('tipo_vehiculo_id')->nullable()->references('idconductor_tipo_vehiculo')->on('conductores_tipo_vehiculo')->onDelete('set null');
            $table->integer('numero_licencia')->unique()->nullable();
            $table->foreignId('clase_licencia_id')->nullable()->references('idconductor_clase_licencia')->on('conductores_clase_licencias')->onDelete('set null');
            $table->foreignId('creadoPor')->nullable()->references('id_usuario')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('personal_id')->references('idpersonal')->on('personal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores_bomberos');
    }
};
