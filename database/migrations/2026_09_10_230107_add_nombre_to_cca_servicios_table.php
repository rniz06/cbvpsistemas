<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     */
    public function up(): void
    {
        Schema::table('CCA_servicios', function (Blueprint $table) {
            $table->string('nombre', 255)
                ->nullable()
                ->after('servicio');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::table('CCA_servicios', function (Blueprint $table) {
            $table->dropColumn('nombre');
        });
    }
};