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
        Schema::create('PER_companias_autoridades', function (Blueprint $table) {
            $table->id('id_compania_autoridad');
            $table->integer('personal_id')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('personal_id')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('compania_id')->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('cargo_id')->constrained('PER_cargos', 'id_cargo')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('codigo_cargo', 15)->unique()->nullable();
            $table->foreignId('creadoPor')->nullable()->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('actualizadoPor')->nullable()->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->comment('TABLA DE AUTORIDADES DE LAS COMPANIAS EJ: COMANDANTE DE COMPANIA, SEGUNDO OFICIAL, DK, ETC');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PER_companias_autoridades');
    }
};
