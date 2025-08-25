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
        Schema::create('PER_comisionamientos', function (Blueprint $table) {
            $table->id('id_comisionamiento');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            // FK a personal (tipo int porque así está en tabla 'personal')
            $table->integer('personal_id')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('personal_id')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('cargo_id')
                ->constrained('PER_cargos', 'id_cargo')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('compania_id')
                ->constrained('GRAL_companias', 'id_compania')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->comment('Estamento al cual va comisionado: Directorio, Comandancia, ANB, etc.');

            $table->foreignId('direccion_id')
                ->constrained('GRAL_direcciones', 'id_direccion')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->comment('Dirección dentro del estamento: Directorio - Dpto de TI, Comandancia - DMN, etc.');
                $table->unsignedBigInteger('resolucion_id')->nullable();
            $table->string('codigo_comisionamiento', 15)->nullable();
            // Estado
            $table->boolean('culminado')->default(false)->nullable();
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
        Schema::dropIfExists('PER_comisionamientos');
    }
};
