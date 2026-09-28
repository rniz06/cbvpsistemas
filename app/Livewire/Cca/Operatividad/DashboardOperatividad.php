<?php

namespace App\Livewire\Cca\Operatividad;

use App\Models\Cca\Operatividad\Operatividad;
use App\Models\Cca\Operatividad\OperatividadMovil;
use App\Models\Gral\Compania;
use App\Models\Materiales\Movil\Movil;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class DashboardOperatividad extends Component
{
    public string $companiaId = ''; // '' = todas

    private ?Carbon $ahoraCache = null;

    /* ------------------------------------------------------------------
     | Helpers de período
     * ------------------------------------------------------------------ */

    private function ahora(): Carbon
    {
        return $this->ahoraCache ??= now();
    }

    private function desde7(): Carbon
    {
        return now()->subDays(6)->startOfDay();
    }

    private function desdeMes(): Carbon
    {
        return now()->startOfMonth();
    }

    public function color(float $pct): string
    {
        return match (true) {
            $pct >= 90 => 'success',
            $pct >= 70 => 'warning',
            default    => 'danger',
        };
    }

    /** Nombre del móvil: ACRONIMO-movil */
    public function nombreMovil(?Movil $m): string
    {
        if (!$m) return '-';
        return trim(($m->acronimo?->tipo ?? '') . '-' . $m->movil, '-');
    }

    /* ------------------------------------------------------------------
     | Compañías
     * ------------------------------------------------------------------ */

    #[Computed]
    public function companias(): Collection
    {
        return Compania::companiasValidas()
            ->orderBy('orden')
            ->get(['id_compania', 'compania', 'orden']);
    }

    private function companiasFiltradas(): Collection
    {
        return $this->companiaId === ''
            ? $this->companias
            : $this->companias->where('id_compania', (int) $this->companiaId);
    }

    private function ids(): Collection
    {
        return $this->companiasFiltradas()->pluck('id_compania');
    }

    /* ------------------------------------------------------------------
     | Cálculo de intervalos operativos
     * ------------------------------------------------------------------ */

    /**
     * [compania_id => [ ['inicio'=>ts, 'fin'=>ts], ... ]]
     * Se calcula una sola vez desde el inicio más antiguo (7 días o mes).
     */
    #[Computed]
    public function intervalos(): Collection
    {
        $ids   = $this->ids();
        $desde = $this->desde7()->min($this->desdeMes());
        $hasta = $this->ahora();

        $registros = Operatividad::whereIn('compania_id', $ids)
            ->whereBetween('fecha_hora', [$desde, $hasta])
            ->orderBy('fecha_hora')
            ->get(['compania_id', 'fecha_hora', 'operativo'])
            ->groupBy('compania_id');

        return $ids->mapWithKeys(function ($id) use ($registros, $desde, $hasta) {
            $puntos = $registros->get($id, collect())
                ->map(fn ($r) => ['t' => $r->fecha_hora->timestamp, 'op' => (bool) $r->operativo])
                ->values()
                ->all();

            // Estado heredado del último registro previo al período
            $previo = Operatividad::where('compania_id', $id)
                ->where('fecha_hora', '<', $desde)
                ->orderByDesc('fecha_hora')
                ->value('operativo');

            if ($previo !== null) {
                array_unshift($puntos, ['t' => $desde->timestamp, 'op' => (bool) $previo]);
            }

            $tramos = [];
            foreach ($puntos as $i => $p) {
                if (!$p['op']) continue;
                $fin = $puntos[$i + 1]['t'] ?? $hasta->timestamp;
                if ($fin > $p['t']) {
                    $tramos[] = ['inicio' => $p['t'], 'fin' => $fin];
                }
            }

            return [$id => $tramos];
        });
    }

    private function pct(array $tramos, Carbon $ini, Carbon $fin): float
    {
        $total = max($fin->timestamp - $ini->timestamp, 1);

        $seg = collect($tramos)->sum(fn ($t) => max(
            0,
            min($t['fin'], $fin->timestamp) - max($t['inicio'], $ini->timestamp)
        ));

        return round(min($seg / $total * 100, 100), 1);
    }

    private function resumen(Carbon $desde): Collection
    {
        $hasta = $this->ahora();

        return $this->companiasFiltradas()->map(fn ($c) => (object) [
            'id'       => $c->id_compania,
            'compania' => $c->compania,
            'pct'      => $this->pct($this->intervalos->get($c->id_compania, []), $desde, $hasta),
        ])->keyBy('id');
    }

    /* ------------------------------------------------------------------
     | Reportes
     * ------------------------------------------------------------------ */

    #[Computed]
    public function resumen7(): Collection
    {
        return $this->resumen($this->desde7());
    }

    #[Computed]
    public function resumenMes(): Collection
    {
        return $this->resumen($this->desdeMes());
    }

    /** % de operatividad promedio por día (últimos 7 días) */
    #[Computed]
    public function pctPorDia(): Collection
    {
        $ahora = $this->ahora();
        $comps = $this->companiasFiltradas();

        return collect(range(0, 6))->map(function ($i) use ($ahora, $comps) {
            $ini = $this->desde7()->addDays($i);
            $fin = $ini->copy()->endOfDay();
            if ($fin->gt($ahora)) $fin = $ahora->copy();

            $pct = $comps->isEmpty() ? 0 : $comps->avg(
                fn ($c) => $this->pct($this->intervalos->get($c->id_compania, []), $ini, $fin)
            );

            return (object) [
                'dia' => $ini->translatedFormat('D d'),
                'pct' => round($pct, 1),
            ];
        });
    }

    /** Última operatividad registrada por compañía */
    #[Computed]
    public function estadoActual(): Collection
    {
        return Compania::companiasValidas()
            ->whereIn('id_compania', $this->ids())
            ->with(['ultimaOperatividad.acargo_rel', 'ultimaOperatividad.moviles'])
            ->orderBy('orden')
            ->get();
    }

    /** Flota actual (tabla de móviles) por compañía: total y operativos */
    #[Computed]
    public function flota(): Collection
    {
        return Movil::filtrarOperaInope()
            ->whereIn('compania_id', $this->ids())
            ->selectRaw('compania_id, COUNT(*) as total, SUM(CASE WHEN operatividad_id = 1 THEN 1 ELSE 0 END) as operativos')
            ->groupBy('compania_id')
            ->get()
            ->keyBy('compania_id');
    }

    /** Móviles actualmente inoperativos con su último motivo */
    #[Computed]
    public function movilesInoperativos(): Collection
    {
        return Movil::filtrarInoperativos()
            ->whereIn('compania_id', $this->ids())
            ->with(['acronimo', 'compania', 'ultimoComentarioFueraServicio'])
            ->get()
            ->sortBy(fn ($m) => $m->compania?->orden);
    }

    /** Dotación y equipos del mes (por compañía) */
    #[Computed]
    public function promediosMes(): Collection
    {
        return Operatividad::whereIn('compania_id', $this->ids())
            ->whereBetween('fecha_hora', [$this->desdeMes(), $this->ahora()])
            ->selectRaw('compania_id')
            ->selectRaw('COUNT(*) as registros')
            ->selectRaw('AVG(cant_personal) as prom_personal')
            ->selectRaw('AVG(cant_conductor) as prom_conductor')
            ->selectRaw('SUM(CASE WHEN equipo_hidraulico = 1 THEN 1 ELSE 0 END) as con_hidraulico')
            ->selectRaw('SUM(CASE WHEN pileta = 1 THEN 1 ELSE 0 END) as con_pileta')
            ->groupBy('compania_id')
            ->get()
            ->keyBy('compania_id');
    }

    /** Top 5 móviles con mayor % de reportes "fuera de servicio" en el mes */
    #[Computed]
    public function movilesProblematicos(): Collection
    {
        $ids = $this->ids();

        return OperatividadMovil::with('movil.acronimo')
            ->selectRaw('movil_id')
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN operativo = 0 THEN 1 ELSE 0 END) as fuera')
            ->whereHas('operatividadDetalle', fn ($q) => $q
                ->whereIn('compania_id', $ids)
                ->whereBetween('fecha_hora', [$this->desdeMes(), $this->ahora()]))
            ->groupBy('movil_id')
            ->havingRaw('SUM(CASE WHEN operativo = 0 THEN 1 ELSE 0 END) > 0')
            ->orderByDesc('fuera')
            ->limit(5)
            ->get()
            ->map(function ($r) {
                $r->pct = round($r->fuera / max($r->total, 1) * 100, 1);
                return $r;
            });
    }

    #[Computed]
    public function kpis(): array
    {
        $flota = $this->flota;
        $totalMov = $flota->sum('total');

        return [
            'pct7'            => round($this->resumen7->avg('pct') ?? 0, 1),
            'pctMes'          => round($this->resumenMes->avg('pct') ?? 0, 1),
            'operativasAhora' => $this->estadoActual->filter(fn ($c) => $c->ultimaOperatividad?->operativo)->count(),
            'totalCompanias'  => $this->estadoActual->count(),
            'pctFlota'        => $totalMov ? round($flota->sum('operativos') / $totalMov * 100, 1) : 0,
        ];
    }

    public function render()
    {
        return view('livewire.cca.operatividad.dashboard-operatividad');
    }
}