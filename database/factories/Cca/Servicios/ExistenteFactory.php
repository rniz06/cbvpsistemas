<?php

namespace Database\Factories\Cca\Servicios;

use App\Models\Admin\CiudadGral;
use App\Models\Admin\CompaniaGral;
use App\Models\Cca\Servicios\Clasificacion;
use App\Models\Cca\Servicios\Existente;
use App\Models\Cca\Servicios\Servicio;
use App\Models\Materiales\Movil\Movil;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ExistenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Existente::class;

    public function definition(): array
    {
        $servicio = Servicio::inRandomOrder()->first();

        // Fecha base: fija o relativa
        $fechaAlfa = \Carbon\Carbon::create(2025, 7, 15, 12, 25, 10);

        // Fechas posteriores: añadir minutos u horas aleatorias
        $fechaCia = (clone $fechaAlfa)->addMinutes(fake()->numberBetween(1, 30));
        $fechaMovil = (clone $fechaCia)->addMinutes(fake()->numberBetween(1, 30));
        $fechaServicio = (clone $fechaMovil)->addMinutes(fake()->numberBetween(1, 30));
        $fechaBase = (clone $fechaServicio)->addMinutes(fake()->numberBetween(1, 30));

        return [
            'informacion_servicio' => fake()->text(),
            'calle_referencia' => fake()->address(),
            'cantidad_tripulantes' => fake()->numberBetween(1, 10),
            'compania_id' => CompaniaGral::inRandomOrder()->value('id_compania'),
            'servicio_id' => $servicio->id_servicio,
            'clasificacion_id' => Clasificacion::where('servicio_id', $servicio->id_servicio)
                ->inRandomOrder()
                ->value('id_servicio_clasificacion'),
            'ciudad_id' => CiudadGral::inRandomOrder()->value('id_ciudad'),
            'movil_id' => Movil::inRandomOrder()->value('id_movil'),
            'acargo' => Personal::inRandomOrder()->value('idpersonal'),
            'acargo' => '1029',
            'estado_id' => 4,
            'fecha_alfa' => $fechaAlfa,
            'fecha_cia' => $fechaCia,
            'fecha_movil' => $fechaMovil,
            'fecha_servicio' => $fechaServicio,
            'fecha_base' => $fechaBase,
            'falsa_alarma' => 0,
            'creadoPor' => 10231,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
