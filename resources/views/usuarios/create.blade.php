@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Usuarios')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Crear')

{{-- Content body: main page content --}}

@section('content_body')

    <div class="card card-info">
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="card-body">

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Personal:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="personal_id" id="personal_id" required>
                        </select>
                        @error('personal_id')
                        <p class="text-danger">*{{ $message }}</p>
                    @enderror
                    </div>                    
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Roles:</label>
                    <div class="col-sm-10">
                        <select name="roles[]" id="roles" class="form-control" multiple="multiple" style="width: 100%">
                            @foreach ($roles as $value => $label)
                                <option value="{{ $value }}" {{ isset($userRole[$value]) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('roles')
                        <p class="text-danger">*{{ $message }}</p>
                    @enderror
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary float-right"><i
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
        $('#personal_id').select2({
            placeholder: 'Seleccionar...',
            language: "es",
            ajax: {
                url: '{{ route('personal.search') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 10) < data.total_count
                        }
                    };
                },
                cache: true
            },
            minimumInputLength: 2,
            templateResult: formatPersonal,
            templateSelection: formatPersonalSelection
        });

        // Formato para mostrar los resultados en el dropdown
        function formatPersonal(personal) {
            if (personal.loading) return personal.text;

            return $('<div class="select2-result-personal">' +
                personal.nombrecompleto + ' - ' + personal.codigo + ' - ' + personal.categoria +
                '</div>');
        }

        // Formato para mostrar el elemento seleccionado
        function formatPersonalSelection(personal) {
            return personal.nombrecompleto ? personal.nombrecompleto + ' - ' + personal.codigo + ' - ' + personal
                .categoria : personal.text;
        }

        $(document).ready(function() {
            $('#roles').select2({
                placeholder: 'Seleccionar...',
                language: "es",

            });
        });
    </script>
@endpush
