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
                    <div class="d-flex">
                        <span><strong>Título de la Actividad:</strong> <span>{{ $activity->title }}</span></span>
                    </div>
                    <hr class="custom-hr">
                    <div class="d-flex">
                        <span><strong>Descripción de la Actividad:</strong> <span>{{ $activity->description }}</span></span>
                    </div>
                    <hr class="custom-hr">
                </div>
                <div class="col-md-6">
                    <p><strong>Tema:</strong> <span>{{ $activity->topic->topic_name }}</span></p>
                    <hr class="custom-hr">
                    <div>
                        <p><strong>Fecha de Creación:</strong> <span>{{ $activity->created_at }}</span> || <strong>Última Actualización:</strong> <span>{{ $activity->updated_at }}</span></p>
                        
                    </div>
                    <hr class="custom-hr">
                </div>
            </div>
            <div>
                <span><strong>Ver Actividad H5P:</strong></span>
                 <hr class="custom-hr">
                <iframe src="{{ $embedLink }}" class="iframe-activity"></iframe>
            </div>
            <hr class="custom-hr">
            <a class="btn btn-secondary" href="{{ route('activities.index') }}">Atrás</a>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
        }
        .card-body {
            background-color: #f8f9fa;
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
        .ml-3 {
            margin-left: 1rem;
        }
        .custom-hr {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, rgba(0, 128, 0, 0.75), rgba(0, 128, 0, 0));
            box-shadow: 0 0 10px rgba(0, 128, 0, 0.75);
            margin: 1rem 0;
        }
        .iframe-activity {
            width: 100%;
            height: 500px; /* Aumentado para dar más espacio al iframe */
            border: 2px solid #10c245; /* Borde con color */
            border-radius: 15px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para el iframe */
        }
        .content-images { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 10px; /* Espacio entre las imágenes */ 
        } 
        .content-images img { 
            max-width: 150px; 
            height: auto; 
            margin: 5px; 
        }
    </style>
@stop

@section('js')
    <!-- Añade aquí cualquier script necesario -->
@stop
