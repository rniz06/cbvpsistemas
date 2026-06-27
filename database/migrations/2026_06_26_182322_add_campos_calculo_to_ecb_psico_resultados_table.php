<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ECB_psico_resultados', function (Blueprint $table) {

            $table->decimal(
                'puntaje_bruto',
                10,
                2
            )->nullable()->after('dimension_id');

            $table->decimal(
                'puntaje_directo',
                10,
                2
            )->nullable()->after('puntaje_bruto');

            $table->integer(
                'percentil'
            )->nullable()->after('puntaje_directo');

            $table->string(
                'interpretacion'
            )->nullable()->after('percentil');

        });
    }

    public function down(): void
    {
        Schema::table('ECB_psico_resultados', function (Blueprint $table) {

            $table->dropColumn([

                'puntaje_bruto',

                'puntaje_directo',

                'percentil',

                'interpretacion'

            ]);

        });
    }
};