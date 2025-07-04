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
        Schema::create('MAT_acciones_categorias', function (Blueprint $table) {
            $table->id('id_accion_categoria');
            $table->string('categoria', 45);
            $table->foreignId('accion_id')->constrained('MAT_acciones', 'id_accion')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MAT_acciones_categorias');
    }
};
