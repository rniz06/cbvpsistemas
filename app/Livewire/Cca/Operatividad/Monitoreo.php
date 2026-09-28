<?php

namespace App\Livewire\Cca\Operatividad;

use App\Models\Gral\Compania;
use Livewire\Component;

class Monitoreo extends Component
{
    /*
    |--------------------------------------------------------------------------
    | DATOS
    |--------------------------------------------------------------------------
    */

    public $datos;


    /*
    |--------------------------------------------------------------------------
    | FILTROS
    |--------------------------------------------------------------------------
    */

    public $companias;

    public string $buscarCompaniaId = '';

    public string $buscarOperatividad = '';

    public int $companiaId = 0;


    /*
    |--------------------------------------------------------------------------
    | PROPIEDADES PARA WIDGETS
    |--------------------------------------------------------------------------
    */

    public int $cant_companias = 0;

    public int $cant_companias_operativas = 0;

    public int $cant_personal = 0;

    public int $cant_hidraulico = 0;

    public int $cant_conductores = 0;


    /*
    |--------------------------------------------------------------------------
    | MOUNT
    |--------------------------------------------------------------------------
    */

    public function mount()
    {
        $this->actualizarDatos();

        $this->companias = Compania::query()
            ->companiasValidas()
            ->orderBy('orden')->get(['id_compania', 'compania']);

    }


    /*
    |--------------------------------------------------------------------------
    | QUERY BASE
    |--------------------------------------------------------------------------
    */

    public function queryBase()
    {
        return Compania::query()
            ->companiasValidas()
            ->with([
                'ultimaOperatividad' => function ($query) {
                    $query->with([
                        'acargo_rel:idpersonal,codigo,categoria_id,fecha_juramento',

                        'moviles.movil:id_movil,movil,movil_tipo_id',

                        'moviles.movil.acronimo:id_movil_tipo,tipo',
                    ]);
                }
            ])
            ->orderBy('orden');
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR DATOS
    |--------------------------------------------------------------------------
    */

    public function actualizarDatos(): void
    {
        $this->datos = $this->queryBase()
            ->buscarIdCompania($this->buscarCompaniaId)
            ->buscarOperatividad($this->buscarOperatividad)
            ->get();

        $this->calcularDatosParaWidget($this->datos);
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR AL CAMBIAR FILTROS
    |--------------------------------------------------------------------------
    */

    public function updatedBuscarCompaniaId(): void
    {
        $this->actualizarDatos();
    }

    public function updatedBuscarOperatividad(): void
    {
        $this->actualizarDatos();
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        return view('livewire.cca.operatividad.monitoreo', [
            'datos' => $this->datos,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | MODAL ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    public function abrirModalActualizar(int $companiaId)
    {
        $this->companiaId = $companiaId;

        $this->dispatch('abrir-modal-actualizar');
    }


    public function cerrarModalActualizar()
    {
        $this->companiaId = 0;
    }


    /*
    |--------------------------------------------------------------------------
    | CALCULAR DATOS PARA WIDGETS
    |--------------------------------------------------------------------------
    */

    private function calcularDatosParaWidget($datos): void
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL DE COMPAÑÍAS
        |--------------------------------------------------------------------------
        */

        $this->cant_companias = $datos->count();


        /*
        |--------------------------------------------------------------------------
        | SOLO COMPAÑÍAS OPERATIVAS
        |--------------------------------------------------------------------------
        */

        $companiasOperativas = $datos->where(
            'cca_operativo',
            true
        );


        /*
        |--------------------------------------------------------------------------
        | CANTIDAD DE COMPAÑÍAS OPERATIVAS
        |--------------------------------------------------------------------------
        */

        $this->cant_companias_operativas = $companiasOperativas->count();


        /*
        |--------------------------------------------------------------------------
        | PERSONAL DE GUARDIA
        |--------------------------------------------------------------------------
        */

        $this->cant_personal = $companiasOperativas->sum(
            fn ($compania) =>
                $compania->ultimaOperatividad?->cant_personal ?? 0
        );


        /*
        |--------------------------------------------------------------------------
        | COMPAÑÍAS CON EQUIPO HIDRÁULICO
        |--------------------------------------------------------------------------
        */

        $this->cant_hidraulico = $companiasOperativas->filter(
            fn ($compania) =>
                $compania->ultimaOperatividad?->equipo_hidraulico === true
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CONDUCTORES
        |--------------------------------------------------------------------------
        */

        $this->cant_conductores = $companiasOperativas->sum(
            fn ($compania) =>
                $compania->ultimaOperatividad?->cant_conductor ?? 0
        );
    }
}