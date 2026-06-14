<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'ECB_psico_preguntas',
            function (Blueprint $table) {

                $table->string(
                    'dimension'
                )->nullable()->after('pregunta');

            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'ECB_psico_preguntas',
            function (Blueprint $table) {

                $table->dropColumn(
                    'dimension'
                );

            }
        );
    }
};