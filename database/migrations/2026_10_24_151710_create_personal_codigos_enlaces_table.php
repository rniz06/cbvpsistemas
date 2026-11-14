
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Agregar el estado ENLAZADO solamente si no existe.
         * No se fija manualmente el ID: MySQL asignará el disponible.
         */
        $estado = DB::table('personal_estados')
            ->where('estado', 'ENLAZADO')
            ->first();

        if ($estado) {
            if (isset($estado->deleted_at) && $estado->deleted_at !== null) {
                DB::table('personal_estados')
                    ->where('idpersonal_estados', $estado->idpersonal_estados)
                    ->update(['deleted_at' => null]);
            }
        } else {
            DB::table('personal_estados')->insert([
                'estado' => 'ENLAZADO',
            ]);
        }

        /*
         * Registro administrativo de la relación entre las dos fichas.
         * No se copian asistencias, resoluciones ni otros historiales.
         */
        Schema::create('personal_codigos_enlaces', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('personal_anterior_id')->unique();
            $table->unsignedBigInteger('personal_nueva_id')->unique();

            $table->unsignedBigInteger('usuario_ejecutor_id')->nullable();

            $table->timestamp('fecha_enlace')->useCurrent();
            $table->timestamps();

            $table->index('personal_anterior_id', 'pce_anterior_idx');
            $table->index('personal_nueva_id', 'pce_nueva_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_codigos_enlaces');

        /*
         * No se elimina el estado ENLAZADO en rollback.
         * Puede estar siendo utilizado por fichas ya enlazadas.
         */
    }
};
