@extends('layouts.app')

@section('content_body')

@livewire(\App\Livewire\ANB\ECB\PsicoTests\Opciones::class,['pregunta'=>$pregunta])

@stop