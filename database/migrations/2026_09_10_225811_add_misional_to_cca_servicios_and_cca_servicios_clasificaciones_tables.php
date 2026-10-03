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
            $table->boolean('misional')
                ->default(false)
                ->after('clasificacion_boolean');
        });

        Schema::table('CCA_servicios_clasificaciones', function (Blueprint $table) {
            $table->boolean('misional')
                ->default(false)
                ->after('servicio_id');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::table('CCA_servicios', function (Blueprint $table) {
            $table->dropColumn('misional');
        });

        Schema::table('CCA_servicios_clasificaciones', function (Blueprint $table) {
            $table->dropColumn('misional');
        });
    }
};