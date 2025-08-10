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
            $table->string('cargo', 45)->nullable();
            $table->string('sufijo', 15)->nullable();
            $table->foreignId('rango_id')->nullable()->constrained('PER_rangos', 'id_rango')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('compania_id')->nullable()->constrained('GRAL_companias', 'id_compania')->cascadeOnUpdate()->cascadeOnDelete()
                ->comment('ESTAMENTO AL QUE PERTENECE EL CARGO EJ: DIRECTORIO, COMANDANCIA, ANB, ETC.');
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
