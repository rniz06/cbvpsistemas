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
        Schema::create('CCA_operatividad_moviles', function (Blueprint $table) {
            $table->id('id_operatividad_movil');
            $table->foreignId('operatividad_detalle_id')->constrained('CCA_operatividad_detalles', 'id_operatividad_detalle')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('movil_id')->constrained('MAT_moviles', 'id_movil')
                ->cascadeOnUpdate()->cascadeOnDelete();
                $table->boolean('operativo');
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
        Schema::dropIfExists('CCA_operatividad_moviles');
    }
};
