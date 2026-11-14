
@extends('adminlte::page')

@section('title', 'Crear período de asistencia')

@section('content_header')
    <h1>Períodos de asistencia</h1>
@stop

@section('content')
    @livewire('personal.asistencias.crear-periodo')
@stop
