@extends('layouts.app')

@section('content_body')

@livewire(\App\Livewire\ANB\ECB\PsicoTests\Preguntas::class,['test'=>$test])

@stop