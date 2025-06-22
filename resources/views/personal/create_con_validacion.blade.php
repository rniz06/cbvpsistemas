@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Registrar')

{{-- Content body: main page content --}}

@section('content_body')

    <div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>¡Vaya!</strong> Hubo algunos problemas con su entrada.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-form method="POST" action="{{ route('personal.store') }}">

            <x-input label="Nombre Completo:" type="text" name="nombrecompleto" placeholder="Nombre Completo..." />

            <x-input label="Codigo" type="text" name="codigo" placeholder="Codigo..." />

            <x-input label="Fecha de Juramento" type="date" name="fecha_de_juramento"
                placeholder="Fecha de Juramento..." />

            <x-input label="Documento" type="text" name="documento" placeholder="Documento..." />

            <x-select label="Categoria" name="categoria_id" id="categoria_id">
                <option>Seleccionar...</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->idpersonal_categorias }}">
                        {{ $categoria->categoria ?? 'N/A' }}
                    </option>
                @endforeach
            </x-select>

            <x-select label="Compañia" name="compania_id" id="compania">
                <option>Seleccionar...</option>
                @foreach ($companias as $compania)
                    <option value="{{ $compania->idcompanias }}">{{ $compania->compania ?? 'N/A' }} -
                        {{ $compania->departamento ?? 'N/A' }} - {{ $compania->ciudad ?? 'N/A' }}</option>
                @endforeach
            </x-select>

            <x-select label="Estado" name="estado_id" id="estado_id">
                <option>Seleccionar...</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->idpersonal_estados }}">{{ $estado->estado ?? 'N/A' }}</option>
                @endforeach
            </x-select>

            <x-select label="Sexo" name="sexo_id" id="sexo_id">
                <option>Seleccionar...</option>
                @foreach ($sexos as $sexo)
                    <option value="{{ $sexo->idpersonal_sexo }}">{{ $sexo->sexo ?? 'N/A' }}</option>
                @endforeach
            </x-select>

            <x-select label="Nacionalidad" name="nacionalidad_id">
                <option>Seleccionar...</option>
                @foreach ($paises as $pais)
                    <option value="{{ $pais->idpaises }}">{{ $pais->pais ?? 'N/A' }}</option>
                @endforeach
            </x-select>

            <x-select label="Grupo Sanguineo" name="grupo_sanguineo_id">
                <option>Seleccionar...</option>
                @foreach ($grupo_sanguineo as $valor)
                    <option value="{{ $valor->idpersonal_grupo_sanguineo }}">
                        {{ $valor->grupo_sanguineo ?? 'N/A' }}</option>
                @endforeach
            </x-select>

            <x-slot name="buttons">
                <x-button type="submit">Registrar</x-button>
                <x-button-back href="{{ route('personal.index') }}">Cancelar</x-button-back>
            </x-slot>

        </x-form>
    </div>

@stop

@section('plugins.Select2', true)

{{-- Push extra CSS --}}

@push('css')
    <style>
        /* Corrige estilos del select2 */
        .selection span {
            height: 38px !important;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script>
        $(document).ready(function() {
            $('#compania').select2({
                placeholder: 'Seleccionar...',
                language: "es",

            });
        });
    </script>
@endpush
