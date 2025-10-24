<?php

namespace Database\Seeders\Gral;

use App\Models\Gral\Anho;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=Database\\Seeders\\Gral\\AnhoSeeder
     */
    public function run(): void
    {
        Anho::create(['anho' => 2025]);
    }
}
