<?php

namespace App\Livewire\Cca\Operatividad;

use App\Models\Gral\Compania;
use Livewire\Component;

class MonitoreoVisual extends Component
{
    /**
     * Organiza las compañías por Departamento -> Ciudad -> Compañías.
     * Orden de departamentos:
     * 1. Capital (ID 18)
     * 2. Central (ID 1)
     * 3. Los demás alfabéticamente.
     */
    private function obtenerDatos()
    {
        $companias = Compania::query()
            ->companiasValidas()
            ->with([
                'ciudad.departamento',
                'ultimaOperatividad.moviles',
            ])
            ->orderBy('orden')
            ->get();

        // Excluir compañías sin ciudad o departamento relacionado.
        $companias = $companias->filter(function ($compania) {
            return $compania->ciudad !== null
                && $compania->ciudad->departamento !== null;
        });

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

                $ciudades = $companiasDepartamento
                    ->groupBy(function ($compania) {
                        return $compania->ciudad->id_ciudad;
                    })
                    ->map(function ($companiasCiudad) {
                        return [
                            'nombre' => $companiasCiudad
                                ->first()
                                ->ciudad
                                ->ciudad,
                            'companias' => $companiasCiudad->values(),
                        ];
                    })
                    ->sortBy('nombre')
                    ->values();

                return [
                    'id' => (int) $departamento->id_departamento,
                    'nombre' => $departamento->departamento,
                    'ciudades' => $ciudades,
                    'total_companias' => $companiasDepartamento->count(),
                    'companias_operativas' => $companiasDepartamento
                        ->where('cca_operativo', true)
                        ->count(),
                ];
            });

        // Capital primero, Central segundo y luego orden alfabético.
        return $departamentos
            ->sort(function ($a, $b) {
                $prioridadA = match ((int) $a['id']) {
                    18 => 0, // Capital
                    1  => 1, // Central
                    default => 2,
                };

                $prioridadB = match ((int) $b['id']) {
                    18 => 0, // Capital
                    1  => 1, // Central
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

    public function render()
    {
        return view(
            'livewire.cca.operatividad.monitoreo-visual',
            [
                'departamentos' => $this->obtenerDatos(),
            ]
        );
    }
}
