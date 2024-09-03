@extends('layouts.admin.app')

@section('title', 'Usuarios')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Editar Evento</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <form action="{{ route('events.update', $event->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.events.partials._form')
                <button type="submit" class="btn btn-success">Actualizar Evento</button>
            </form>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    
@stop
