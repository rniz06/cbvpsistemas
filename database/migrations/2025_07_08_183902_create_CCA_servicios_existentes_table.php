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
        Schema::create('CCA_servicios_existentes', function (Blueprint $table) {
            $table->id('id_servicio_existente');
            $table->string('informacion_servicio', 255)->nullable();
            $table->string('calle_referencia', 255)->nullable();
            $table->integer('cantidad_tripulantes')->nullable();
            $table->foreignId('compania_id')->nullable()->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('servicio_id')->nullable()->constrained('CCA_servicios', 'id_servicio')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('clasificacion_id')->nullable()->constrained('CCA_servicios_clasificaciones', 'id_servicio_clasificacion')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('ciudad_id')->nullable()->constrained('GRAL_ciudades', 'id_ciudad')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('movil_id')->nullable()->constrained('MAT_moviles', 'id_movil')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('acargo')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('acargo')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('acargo_aux', 10)->nullable();
            $table->integer('chofer')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('chofer')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('chofer_aux', 10)->nullable();
            $table->boolean('chofer_rentado')->nullable()->default(false);
            $table->foreignId('estado_id')->nullable()->constrained('CCA_servicios_estados', 'id_servicio_estado')->cascadeOnUpdate()->cascadeOnDelete();
            $table->dateTime('fecha_alfa')->useCurrent()->nullable();
            $table->dateTime('fecha_cia')->nullable();
            $table->dateTime('fecha_movil')->nullable();
            $table->dateTime('fecha_servicio')->nullable();
            $table->dateTime('fecha_base')->nullable();
            $table->boolean('falsa_alarma')->nullable()->default(0);
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
        Schema::dropIfExists('CCA_servicios_existentes');
    }
};
