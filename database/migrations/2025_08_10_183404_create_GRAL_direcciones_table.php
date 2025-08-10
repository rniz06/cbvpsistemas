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
        Schema::create('GRAL_direcciones', function (Blueprint $table) {
            $table->id('id_direccion');
            $table->string('direccion', 50);
            $table->foreignId('compania_id')->nullable()->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete()
                ->comment('ESTAMENTO AL QUE PERTENECE LA DIRECCION EJ: DIRECTORIO, COMANDANCIA, ANB, ETC.');
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
        Schema::dropIfExists('GRAL_direcciones');
    }
};
