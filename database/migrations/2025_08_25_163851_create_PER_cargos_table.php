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
        Schema::create('PER_cargos', function (Blueprint $table) {
            $table->id('id_cargo');
            $table->string('cargo', 45)->unique()->nullable();
            $table->string('codigo_base', 15)->nullable();
            $table->enum('tipo_codigo', ['FIJO', 'VARIABLE', 'COMPANIA'])->nullable();
            $table->foreignId('rango_id')->nullable()->constrained('PER_rangos', 'id_rango')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('PER_cargos');
    }
};
