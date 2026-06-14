<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'ECB_psico_dimensiones',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId('test_id')
                    ->constrained('ECB_psico_tests')
                    ->cascadeOnDelete();

                $table->string('nombre');

                $table->timestamps();

            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'ECB_psico_dimensiones'
        );
    }
};