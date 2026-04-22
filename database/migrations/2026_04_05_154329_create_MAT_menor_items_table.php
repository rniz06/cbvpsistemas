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
        Schema::create('MAT_menor_items', function (Blueprint $table) {
            $table->id('id_menor_item');
            $table->foreignId('componente_id')->constrained('MAT_menor_componentes', 'id_menor_componente')->cascadeOnUpdate()->cascadeOnDelete();

            # SE OMITEN POR AHORA, CAMBIO DE ESTRUCTURA
            #$table->foreignId('estado_id')->constrained('MAT_operatividad', 'id_operatividad')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('cantidad_operativo')->default(0);
            $table->integer('cantidad_inoperativo')->default(0);
            $table->foreignId('compania_id')->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('marca_id')->nullable()->constrained('MAT_menor_marcas', 'id_menor_marca')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('MAT_menor_items');
    }
};
