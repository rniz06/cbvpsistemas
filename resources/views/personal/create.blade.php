@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Personal')
@section('content_header_title', 'Personal')
@section('content_header_subtitle', 'Registrar')

{{-- Content body: main page content --}}

@section('content_body')

    <div class="card card-info">
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('personal.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="card-body">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre Completo:</label>
                    <div class="col-sm-10">
                        <input type="text" name="nombrecompleto" value="{{ old('nombrecompleto') }}" class="form-control"
                            id="inputEmail3" placeholder="Nombre Completo..." required>
                        @error('nombrecompleto')
                            <p class="text-danger">*{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Codigo:</label>
                    <div class="col-sm-10">
                        <input type="text" name="codigo" value="{{ old('codigo') }}" class="form-control"
                            id="inputEmail3" placeholder="Codigo..." required>
                        @error('codigo')
                            <p class="text-danger">*{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha Juramento:</label>
                    <div class="col-sm-10">
                        <input type="number" name="fecha_juramento" value="{{ old('fecha_juramento') }}"
                            class="form-control" id="inputEmail3" placeholder="Fecha Juramento..." minlength="4" maxlength="4" required>
                        @error('fecha_juramento')
                            <p class="text-danger">*{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Documento:</label>
                    <div class="col-sm-10">
                        <input type="text" name="documento" value="{{ old('documento') }}" class="form-control"
                            id="inputEmail3" placeholder="Documento..." required>
                        @error('documento')
                            <p class="text-danger">*{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Categoría:</label>
                    <div class="col-sm-10">
                        <select name="categoria_id" class="form-control" id="inputEmail3" required>
                            <option>Seleccionar...</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->idpersonal_categorias }}">
                                    {{ $categoria->categoria ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Compañia:</label>
                    <div class="col-sm-10">
                        {{-- <input type="email" class="form-control" id="inputEmail3" placeholder="Compañia..."> --}}
                        <select class="js-example-basic-single form-control" name="compania_id" required>
                            <option value="">Seleccionar...</option>
                            @foreach ($companias as $compania)
                                <option value="{{ $compania->idcompanias }}">{{ $compania->compania ?? 'N/A' }} -
                                    {{ $compania->departamento ?? 'N/A' }} - {{ $compania->ciudad ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Estado:</label>
                    <div class="col-sm-10">
                        <select name="estado_id" class="form-control" id="inputEmail3" required>
                            <option>Seleccionar...</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->idpersonal_estados }}">{{ $estado->estado ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Sexo:</label>
                    <div class="col-sm-10">
                        <select name="sexo_id" class="form-control" id="inputEmail3" required>
                            <option>Seleccionar...</option>
                            @foreach ($sexos as $sexo)
                                <option value="{{ $sexo->idpersonal_sexo }}">{{ $sexo->sexo ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nacionalidad:</label>
                    <div class="col-sm-10">
                        <select name="nacionalidad_id" class="form-control" id="inputEmail3" required>
                            <option>Seleccionar...</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->idpaises }}">{{ $pais->pais ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Grupo Sanguineo:</label>
                    <div class="col-sm-10">
                        <select name="grupo_sanguineo_id" class="form-control" id="inputEmail3" required>
                            <option>Seleccionar...</option>
                            @foreach ($grupo_sanguineo as $valor)
                                <option value="{{ $valor->idpersonal_grupo_sanguineo }}">
                                    {{ $valor->grupo_sanguineo ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="{{ route('personal.index') }}" class="btn btn-secondary float-right"><i
                        class="fas fa-arrow-left"></i>
                    Volver</a>
            </div>
            <!-- /.card-footer -->
        </form>
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
            $('.js-example-basic-single').select2({
                placeholder: 'Seleccionar...',
                language: "es",

            });
        });
    </script>
@endpush
