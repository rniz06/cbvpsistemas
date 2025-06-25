@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Editar Ficha')

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

        <x-form method="POST" title="Actualizar Ficha" color="warning"
            action="{{ route('personal.update', $personal->idpersonal) }}">

            @method('PUT')

            <x-input label="Nombre Completo:" type="text" name="nombrecompleto" placeholder="Nombre Completo..."
                value="{{ $personal->nombrecompleto }}" />

            <x-input label="Codigo" type="text" name="codigo" placeholder="Codigo..." value="{{ $personal->codigo }}"
                disabled />

            <x-input label="Fecha de Juramento" type="date" name="fecha_de_juramento" placeholder="Fecha de Juramento..."
                value="{{ $personal->fecha_de_juramento }}" />

                <x-input label="Fecha de Nacimiento" type="date" name="fecha_nacimiento" placeholder="Fecha de Nacimiento..."
                value="{{ $personal->fecha_nacimiento }}" />

            <x-input label="Documento" type="text" name="documento" placeholder="Documento..."
                value="{{ $personal->documento }}" />

            <x-select label="Categoria" name="categoria_id" id="categoria_id">
                <option>Seleccionar...</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->idpersonal_categorias }}"
                        {{ $categoria->idpersonal_categorias == $personal->categoria_id ? 'selected' : '' }}>
                        {{ $categoria->categoria ?? 'N/A' }}
                    </option>
                @endforeach
            </x-select>

            <x-input label="Compañia" type="text" name="compania" placeholder="Documento..."
                value="{{ $personal->vtcompania->compania . ' - ' . $personal->vtcompania->departamento . ' - ' . $personal->vtcompania->ciudad }}" disabled />

            <x-select label="Estado" name="estado_id" id="estado_id">
                <option>Seleccionar...</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->idpersonal_estados }}"
                        {{ $estado->idpersonal_estados == $personal->estado_id ? 'selected' : '' }}>
                        {{ $estado->estado ?? 'N/A' }}</option>
                @endforeach
            </x-select>

            <x-select label="Sexo" name="sexo_id" id="sexo_id">
                <option>Seleccionar...</option>
                @foreach ($sexos as $sexo)
                    <option value="{{ $sexo->idpersonal_sexo }}"
                        {{ $sexo->idpersonal_sexo == $personal->sexo_id ? 'selected' : '' }}>{{ $sexo->sexo ?? 'N/A' }}
                    </option>
                @endforeach
            </x-select>

            <x-select label="Nacionalidad" name="nacionalidad_id">
                <option>Seleccionar...</option>
                @foreach ($paises as $pais)
                    <option value="{{ $pais->idpaises }}"
                        {{ $pais->idpaises == $personal->nacionalidad_id ? 'selected' : '' }}>{{ $pais->pais ?? 'N/A' }}
                    </option>
                @endforeach
            </x-select>

            <x-select label="Grupo Sanguineo" name="grupo_sanguineo_id">
                <option>Seleccionar...</option>
                @foreach ($grupo_sanguineo as $valor)
                    <option value="{{ $valor->idpersonal_grupo_sanguineo }}"
                        {{ $valor->idpersonal_grupo_sanguineo == $personal->grupo_sanguineo_id ? 'selected' : '' }}>
                        {{ $valor->grupo_sanguineo ?? 'N/A' }}</option>
                @endforeach
            </x-select>

            <x-select label="Ficha actualizada completamente?" name="estado_actualizar_id">
                <option>Seleccionar...</option>
                @foreach ($estado_actualizar as $registro)
                    <option value="{{ $registro->idpersonal_estado_actualizar }}"
                        {{ $registro->idpersonal_estado_actualizar == 1 ? 'selected' : '' }}>
                        {{ $registro->estado ?? 'N/A' }}
                    </option>
                @endforeach
            </x-select>

            <x-slot name="buttons">
                <x-button color="warning" type="submit">Actualizar</x-button>
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
