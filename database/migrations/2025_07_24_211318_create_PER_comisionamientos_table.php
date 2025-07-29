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
            $table->integer('personal_id')->nullable(); // Tipo Integer debido a que asi es el tipo de campo en la tabla personal
            $table->foreign('personal_id')->references('idpersonal')->on('personal')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('compania_id')->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('resolucion_id')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->string('codigo_comisionamiento', 10)->nullable();
            $table->boolean('culminado')->nullable()->default(false);
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
