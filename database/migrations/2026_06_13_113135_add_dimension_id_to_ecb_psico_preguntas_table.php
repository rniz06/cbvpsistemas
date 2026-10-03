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

                $table->foreignId(
                    'dimension_id'
                )
                ->nullable()
                ->after('test_id')
                ->constrained(
                    'ECB_psico_dimensiones'
                )
                ->nullOnDelete();

            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'ECB_psico_preguntas',
            function (Blueprint $table) {

                $table->dropForeign([
                    'dimension_id'
                ]);

                $table->dropColumn(
                    'dimension_id'
                );

            }
        );
    }
};