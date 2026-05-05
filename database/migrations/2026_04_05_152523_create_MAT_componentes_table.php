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
        Schema::create('MAT_menor_componentes', function (Blueprint $table) {
            $table->id('id_menor_componente');
            $table->string('nombre', 100);
            $table->foreignId('tipo_id')->constrained('MAT_menor_tipos', 'id_menor_tipo')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('categoria_id')->nullable()->constrained('MAT_menor_categorias', 'id_menor_categoria')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('MAT_menor_componentes');
    }
};
