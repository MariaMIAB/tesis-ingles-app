@extends('layouts.user.app')

@section('title', 'Ver Actividad')

@section('content_header')
    <div class="card bg-primary">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles de la Actividad</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title">{{ $activity->title }}</h2>
                        <p class="text-muted"><strong>Tema:</strong> {{ $activity->topic->topic_name }}</p>
                    </div>
                    <hr class="custom-hr">
                    <p class="card-text">{{ $activity->description }}</p>
                    <hr class="custom-hr">
                    <div class="d-flex justify-content-between text-muted">
                        <p><strong>Creado:</strong> {{ $activity->created_at }}</p>
                        <p><strong>Actualizado:</strong> {{ $activity->updated_at }}</p>
                    </div>
                    <hr class="custom-hr">
                </div>
                <div class="col-md-12">
                    <span><strong>Ver Actividad H5P:</strong></span>
                    <hr class="custom-hr">
                    <iframe src="{{ $embedLink }}" class="iframe-activity"></iframe>
                </div>
            </div>
            <hr class="custom-hr">
            <div class="d-flex justify-content-end mb-4"> <!-- Añadido margen inferior -->
                <a class="btn btn-secondary" href="{{ route('activities.index') }}">Atrás</a>
                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-primary ml-2">Ir a la Actividad</a>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
            margin: 20px 40px; /* Aumentado para separar las tarjetas de los costados */
        }
        .card-body {
            background-color: #f8f9fa;
        }
        .card-title {
            font-size: 1.75rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1.2rem;
            line-height: 1.5;
        }
        p {
            font-size: 1.1em;
        }
        strong {
            color: #343a40;
        }
        .shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .d-flex {
            display: flex;
            align-items: center;
        }
        .custom-hr {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, rgba(0, 123, 255, 0.75), rgba(0, 123, 255, 0));
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.75);
            margin: 1rem 0;
        }
        .iframe-activity {
            width: 100%;
            height: 500px; /* Reducido para dar más espacio al iframe */
            border: 2px solid #007bff; /* Borde con color */
            border-radius: 15px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para el iframe */
        }
    </style>
@stop

@section('js')
    <!-- Añade aquí cualquier script necesario -->
@stop





