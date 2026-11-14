
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_pasantias', function (Blueprint $table) {
            $table->bigIncrements('id_pasantia');

            $table->integer('personal_id');
            $table->integer('compania_origen_id');
            $table->integer('compania_destino_id');

            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('registrado_por')->nullable();

            $table->timestamps();

            $table->index(
                ['personal_id', 'fecha_inicio', 'fecha_fin'],
                'personal_pasantias_periodo_idx'
            );

            $table->index('compania_origen_id', 'personal_pasantias_origen_idx');
            $table->index('compania_destino_id', 'personal_pasantias_destino_idx');
            $table->index('fecha_fin', 'personal_pasantias_fecha_fin_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_pasantias');
    }
};
