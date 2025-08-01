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
        Schema::create('CCA_servicios_existentes_apoyos', function (Blueprint $table) {
            $table->id('idservicio_existente_apoyo');
            $table->integer('cantidad_tripulantes')->nullable();
            $table->foreignId('servicio_id')->constrained('CCA_servicios_existentes', 'id_servicio_existente')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('compania_id')->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('movil_id')->constrained('MAT_moviles', 'id_movil')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('acargo')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('acargo')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('acargo_aux', 10)->nullable();
            $table->integer('chofer')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('chofer')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('chofer_rentado')->nullable()->default(false);
            $table->dateTime('fecha_cia')->useCurrent()->nullable();
            $table->dateTime('fecha_movil')->nullable();
            $table->dateTime('fecha_servicio')->nullable();
            $table->dateTime('fecha_base')->nullable();
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
        Schema::dropIfExists('CCA_servicios_existentes_apoyos');
    }
};
