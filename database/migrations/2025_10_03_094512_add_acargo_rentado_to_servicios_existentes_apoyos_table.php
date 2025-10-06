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
            $table->boolean('acargo_rentado')->default(false)->nullable()->after('acargo_aux');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('CCA_servicios_existentes_apoyos', function (Blueprint $table) {
            $table->dropColumn('acargo_rentado');
        });
    }
};
