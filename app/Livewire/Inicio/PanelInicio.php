<?php

namespace App\Livewire\Inicio;

use App\Models\Gral\Compania;
use App\Models\Materiales\Movil\Movil;
use Livewire\Component;

class PanelInicio extends Component
{
    /**
     * Obtiene los datos de la compañía del usuario,
     * su última condición de guardia y sus móviles.
     */
    private function obtenerMiCompania(): array
    {
        $personal = auth()->user()?->personal;

        $compania = null;
        $ultimaFicha = null;
        $moviles = collect();
        $movilesGuardia = collect();

        if (!$personal || !$personal->compania_id) {
            return [
                'compania' => null,
                'ultimaFicha' => null,
                'moviles' => collect(),
                'movilesGuardia' => collect(),
            ];
        }

        $compania = Compania::query()
            ->where('id_compania', $personal->compania_id)
            ->with([
                'ultimaOperatividad.moviles.movil.acronimo',
            ])
            ->first();

        if (!$compania) {
            return [
                'compania' => null,
                'ultimaFicha' => null,
                'moviles' => collect(),
                'movilesGuardia' => collect(),
            ];
        }

        $ultimaFicha = $compania->ultimaOperatividad;

        // Móviles declarados en la última condición de guardia de CCA.
        $movilesGuardia = $ultimaFicha?->moviles ?? collect();

        /*
         * Material Mayor:
         * - Solo móviles de la compañía del usuario.
         * - Excluye registros eliminados lógicamente.
         * - Muestra únicamente móviles activos (operativo = 1).
         */
        $moviles = Movil::query()
            ->with([
                'acronimo',
                'operatividad',
            ])
            ->where('compania_id', $compania->id_compania)
            ->whereNull('deleted_at')
            ->where('operativo', 1)
            ->orderBy('movil')
            ->get();

        return [
            'compania' => $compania,
            'ultimaFicha' => $ultimaFicha,
            'moviles' => $moviles,
            'movilesGuardia' => $movilesGuardia,
        ];
    }

    /**
     * Obtiene la situación nacional agrupada únicamente
     * por departamento, sin separar por ciudad.
     *
     * Orden:
     * 1. Capital (ID 18).
     * 2. Central (ID 1).
     * 3. Demás departamentos alfabéticamente.
     *
     * Las compañías mantienen el orden definido por
     * el campo "orden" de la tabla de compañías.
     */
    private function obtenerDatosNacionales()
    {
        $companias = Compania::query()
            ->companiasValidas()
            ->with([
                'ciudad.departamento',
                'ultimaOperatividad',
            ])
            ->orderBy('orden')
            ->get();

        // Excluir compañías sin ciudad o departamento.
        $companias = $companias->filter(function ($compania) {
            return $compania->ciudad !== null
                && $compania->ciudad->departamento !== null;
        });

        // Agrupar directamente por departamento.
        $departamentos = $companias
            ->groupBy(function ($compania) {
                return $compania->ciudad
                    ->departamento
                    ->id_departamento;
            })
            ->map(function ($companiasDepartamento) {
                $departamento = $companiasDepartamento
                    ->first()
                    ->ciudad
                    ->departamento;

                return [
                    'id' => (int) $departamento->id_departamento,
                    'nombre' => $departamento->departamento,

                    // El Blade utiliza esta clave directamente.
                    'companias' => $companiasDepartamento->values(),

                    'total_companias' => $companiasDepartamento->count(),

                    'companias_operativas' => $companiasDepartamento
                        ->where('cca_operativo', true)
                        ->count(),
                ];
            });

        // Capital primero, Central segundo y luego alfabéticamente.
        return $departamentos
            ->sort(function ($a, $b) {
                $prioridadA = match ((int) $a['id']) {
                    18 => 0,
                    1 => 1,
                    default => 2,
                };

                $prioridadB = match ((int) $b['id']) {
                    18 => 0,
                    1 => 1,
                    default => 2,
                };

                if ($prioridadA !== $prioridadB) {
                    return $prioridadA <=> $prioridadB;
                }

                return strcasecmp(
                    trim($a['nombre']),
                    trim($b['nombre'])
                );
            })
            ->values();
    }

    /**
     * Renderiza el panel de inicio.
     */
    public function render()
    {
        $datosCompania = $this->obtenerMiCompania();

        return view('livewire.inicio.panel-inicio', [
            'compania' => $datosCompania['compania'],
            'ultimaFicha' => $datosCompania['ultimaFicha'],
            'moviles' => $datosCompania['moviles'],
            'movilesGuardia' => $datosCompania['movilesGuardia'],
            'departamentos' => $this->obtenerDatosNacionales(),
        ]);
    }
}