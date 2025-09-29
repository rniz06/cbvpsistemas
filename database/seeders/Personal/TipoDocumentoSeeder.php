<?php

namespace Database\Seeders\Personal;

use App\Models\Personal\TipoDocumento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Personal\\TipoDocumentoSeeder
     */
    public function run(): void
    {
        $tipos = [
            'CEDULA PARAGUAYA',
            'DNI',
            'PASAPORTE'
        ];

        foreach ($tipos as $tipo) {
            TipoDocumento::create([
                'tipo_documento' => $tipo,
                'creadoPor'      => 10231 // MARCOS MEZA
            ]);
        }
    }
}
