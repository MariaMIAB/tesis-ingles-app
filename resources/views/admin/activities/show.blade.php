@extends('layouts.admin.app')

@section('title', 'Ver Actividad')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles de la Actividad</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div>
                        <p><strong>Título de la Actividad:</strong> {{ $activity->title }}</p>
                        <p><strong>Descripción:</strong> {{ $activity->description }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <p><strong>Tema:</strong> {{ $activity->topic->topic_name }}</p>
                    <p><strong>Fecha de Creación:</strong> {{ $activity->created_at }}</p>
                </div>
            </div>

            <hr>

            @if($embedLink)
                <div>
                    <span><strong>Vista Previa de la Actividad:</strong></span>
                    <iframe src="{{ $embedLink }}" class="iframe-activity"></iframe>
                </div>
            @else
                <div class="alert alert-warning">
                    No hay contenido disponible para esta actividad.
                </div>
            @endif

            <hr>
            <a class="btn btn-secondary" href="{{ route('activities.index') }}">Atrás</a>
        </div>
    </div>
@stop

@section('css')
    <style>
        .iframe-activity {
            width: 100%;
            height: 500px;
            border: 2px solid #10c245;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
@stop


