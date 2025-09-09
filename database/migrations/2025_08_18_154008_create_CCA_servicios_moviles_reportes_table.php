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
        Schema::create('CCA_servicios_moviles_reportes', function (Blueprint $table) {
            $table->foreignId('servicio_id')->constrained('CCA_servicios_existentes', 'id_servicio_existente')
                ->cascadeOnUpdate()->cascadeOnDelete()->comment('Id de la tabla CCA_servicios_existentes');
            $table->foreignId('movil_id')->constrained('MAT_moviles', 'id_movil')
                ->cascadeOnUpdate()->cascadeOnDelete()->comment('Id de la tabla MAT_moviles');
            $table->foreignId('comentario_id')->nullable()->constrained('MAT_moviles_comentarios', 'id_movil_comentario')
                ->cascadeOnUpdate()->cascadeOnDelete()->comment('Id de la tabla MAT_moviles_comentarios donde el accion_id sea 1(En Servicio) o 2(Fuera de Servicio)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CCA_servicios_moviles_reportes');
    }
};
