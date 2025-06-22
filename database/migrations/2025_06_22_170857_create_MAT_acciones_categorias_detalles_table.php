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
        Schema::create('MAT_acciones_categorias_detalles', function (Blueprint $table) {
            $table->id('idaccion_categoria_detalle');
            $table->string('detalle', 45);
            $table->foreignId('accion_categoria_id')->constrained('MAT_acciones_categorias', 'id_accion_categoria')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MAT_acciones_categorias_detalles');
    }
};
