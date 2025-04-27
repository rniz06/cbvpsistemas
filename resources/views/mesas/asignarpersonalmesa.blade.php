@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Mesas')
@section('content_header_title', 'Mesas')
@section('content_header_subtitle', 'Asignar Candidato a Mesa')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    <x-form method="POST" action="{{ route('mesas.asignarpersonalmesapost') }}">

        <x-select label="Mesa" name="mesa_id">
            <option>Seleccionar...</option>
            @foreach ($mesas as $mesa)
                <option value="{{ $mesa->id_mesa }}">
                    {{ $mesa->mesa ?? 'N/A' }}
                </option>
            @endforeach
        </x-select>

        <x-select label="Personal / Candidato" name="personal_id" id="personal">
            <option>Seleccionar...</option>
        </x-select>

        <x-slot name="buttons">
            <x-button type="submit">Asignar</x-button>
            <x-button-back href="{{ route('mesas.index') }}">Cancelar</x-button-back>
        </x-slot>

    </x-form>


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
        $('#personal').select2({
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
    </script>
@endpush
