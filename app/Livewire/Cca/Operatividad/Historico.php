<?php

namespace App\Livewire\Cca\Operatividad;

use App\Exports\Excel\Cca\Operatividad\ExcelCondicionGuardiaCompaniaExport;
use App\Exports\Excel\Cca\Operatividad\ExcelCondicionGuardiaExport;
use App\Models\Cca\Operatividad\Operatividad;
use App\Models\Gral\Compania;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Historico extends Component
{
    use WithPagination, WithoutUrlPagination;

    public int $companiaId;
    public string $cia;

    public function mount(int $companiaId)
    {
        $this->companiaId = $companiaId;
        $this->cia        = Compania::where('id_compania', $companiaId)->value('compania');
    }

    public function queryBase()
    {
        return Operatividad::select(
            'id_operatividad_detalle',
            'operativo',
            'fecha_hora',
            'acargo',
            'acargo_aux',
            'cant_personal',
            'cant_conductor',
            'equipo_hidraulico',
            'pileta',
            'cant_autonomo',
            'cant_espuma',
            'comunicado_por',
            'compania_id',
            'creadoPor',
        )->with([
            'acargo_rel:idpersonal,codigo,categoria_id,fecha_juramento',
            'moviles.movil.acronimo',
            'compania:id_compania,compania'
        ])
            ->where('compania_id', $this->companiaId)
            ->latest();
    }

    public function render()
    {
        return view('livewire.cca.operatividad.historico', [
            'datos' => $this->queryBase()->paginate(15)
        ]);
    }

    public function excelParaCondicionGuardia()
{
    $datos = $this->queryBase()->get();

    return Excel::download(
        new ExcelCondicionGuardiaCompaniaExport($datos),
        'Condicion de Guardia.xlsx'
    );
}
}
