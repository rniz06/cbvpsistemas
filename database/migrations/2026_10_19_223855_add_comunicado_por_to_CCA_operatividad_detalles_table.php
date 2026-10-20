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
        Schema::table('CCA_operatividad_detalles', function (Blueprint $table) {
            $table->string('comunicado_por', 255)->nullable()->after('cant_espuma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('CCA_operatividad_detalles', function (Blueprint $table) {
            $table->dropColumn('comunicado_por');
        });
    }
};
