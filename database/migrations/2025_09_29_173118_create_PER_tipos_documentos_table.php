<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('PER_tipos_documentos', function (Blueprint $table) {
            $table->id('id_tipo_documento');
            $table->string('tipo_documento', 75);
            $table->foreignId('creadoPor')->nullable()->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('actualizadoPor')->nullable()->constrained('users', 'id_usuario')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\Personal\\TipoDocumentoSeeder'
        ]);

        Schema::table('personal', function (Blueprint $table) {
            $table->foreignId('tipo_documento_id')->default(1)->constrained('PER_tipos_documentos', 'id_tipo_documento')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personal', function (Blueprint $table) {
            $table->dropForeign(['tipo_documento_id']);
            $table->dropColumn('tipo_documento_id');
        });

        Schema::dropIfExists('PER_tipos_documentos');
    }
};
