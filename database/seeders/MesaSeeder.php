<?php

namespace Database\Seeders;

use App\Models\Mesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesas = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

        foreach ($mesas as $mesa) {
            Mesa::create([
                'mesa' => 'Mesa N° ' .$mesa,
                'votos' => 0,
            ]);
        }
    }
}
