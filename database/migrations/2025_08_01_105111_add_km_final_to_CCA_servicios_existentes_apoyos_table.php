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
        Schema::table('CCA_servicios_existentes_apoyos', function (Blueprint $table) {
            $table->integer('km_final')->nullable()->after('fecha_base');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('CCA_servicios_existentes_apoyos', function (Blueprint $table) {
            $table->dropColumn('km_final');
        });
    }
};
