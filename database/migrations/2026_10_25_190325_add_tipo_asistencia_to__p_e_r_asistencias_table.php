
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('PER_asistencias', function (Blueprint $table) {
            if (!Schema::hasColumn('PER_asistencias', 'tipo_asistencia')) {
                $table->string('tipo_asistencia', 2)
                    ->nullable()
                    ->after('estado_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('PER_asistencias', function (Blueprint $table) {
            if (Schema::hasColumn('PER_asistencias', 'tipo_asistencia')) {
                $table->dropColumn('tipo_asistencia');
            }
        });
    }
};
