@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Roles')
@section('content_header_title', 'Roles')
@section('content_header_subtitle', 'Listar')

{{-- Content body: main page content --}}

@section('content_body')

    {{-- Mostrar un alert en caso de haber algun mensaje --}}
    @if ($message = Session::get('success'))
        <div class="callout callout-success">
            <h5><i class="fas fa-check-circle mr-2" style="color: #28a745"></i>{{ $message }}</h5>
        </div>
    @endif

    {{-- --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Roles <a href="{{ route('roles.create') }}" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Agregar</a></h3> 
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Rol:</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $rol)
                        <tr>
                            <td>#</td>
                            <td>{{ $rol->name }}</td>
                            <td>
                                <x-dropdown>

                                    @if (auth()->user()->can('Roles Editar'))
                                        <x-slot name="edit">{{ Route('roles.edit', $rol->id) }}</x-slot>
                                    @endif

                                    @if (auth()->user()->can('Roles Eliminar'))
                                        <x-slot name="action">{{ Route('roles.destroy', $rol->id) }}</x-slot>
                                    @endif

                                </x-dropdown>
                            </td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center font-italic">Sin Registros coincidentes...</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            {{ $roles->links() }}
        </div>
    </div>


@stop

{{-- Push extra CSS --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    {{-- <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script> --}}
@endpush
