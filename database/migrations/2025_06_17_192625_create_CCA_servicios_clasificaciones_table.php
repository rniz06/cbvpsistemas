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
        Schema::create('CCA_servicios_clasificaciones', function (Blueprint $table) {
            $table->id('id_servicio_clasificacion');
            $table->string('clasificacion', 45);
            $table->foreignId('servicio_id')->constrained('CCA_servicios', 'id_servicio')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CCA_servicios_clasificaciones');
    }
};
