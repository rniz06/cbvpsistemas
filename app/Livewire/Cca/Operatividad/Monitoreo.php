<?php

namespace App\Livewire\Cca\Operatividad;

use App\Models\Gral\Compania;
use Livewire\Component;

class Monitoreo extends Component
{
    /*
    |--------------------------------------------------------------------------
    | FILTROS
    |--------------------------------------------------------------------------
    */

    public string $buscarCompania = '';
    public string $estado = 'todos';
    public int $companiaId;

    /*
    |--------------------------------------------------------------------------
    | QUERY BASE
    |--------------------------------------------------------------------------
    */

    public function queryBase()
    {
        return Compania::query()
            ->with([
                'ultimaOperatividad' => function ($query) {
                    $query->with([
                        'acargo_rel:idpersonal,codigo,categoria_id,fecha_juramento',
                        'moviles.movil:id_movil,movil,movil_tipo_id',
                        'moviles.movil.acronimo:id_movil_tipo,tipo',
                    ]);
                }
            ])
            //->where('id_compania', 19)//K15
            ->orderBy('orden');
    }


    public function render()
    {
        return view('livewire.cca.operatividad.monitoreo', [
            'datos' => $this->queryBase()->get()
        ]);
    }

    public function abrirModalActualizar(int $companiaId)
    {
        $this->companiaId = $companiaId;

        $this->dispatch('abrir-modal-actualizar');
    }
}
