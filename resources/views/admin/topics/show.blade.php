@extends('layouts.admin.app')

@section('title', 'Ver temas')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles del Tema</h1>
        </div>
    </div>
@stop
@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="d-flex">
                        <span><strong>Nombre del Tema:</strong> <span>{{ $topic->topic_name }}</span></span>
                    </div>
                    <hr class="custom-hr">
                    <div class="d-flex">
                        <span><strong>Descripción del Tema:</strong> <span>{{ $topic->topic_description }}</span></span>
                    </div>
                    <hr class="custom-hr">
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <p><strong>Año:</strong> <span>{{ $topic->semester->year->name }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Semestre:</strong> <span>{{ $topic->semester->name }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Fecha de Inicio del Semestre:</strong> <span>{{ $topic->semester->start_date }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Fecha de Fin del Semestre:</strong> <span>{{ $topic->semester->end_date }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Creado el:</strong> <span>{{ $topic->created_at }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Actualizado el:</strong> <span>{{ $topic->updated_at }}</span></p>
                </div>
            </div>
            <a class="btn btn-secondary" href="{{ route('topics.index') }}">Atras</a>
            <a class="btn btn-secondary" href="{{ route('topics.contents.index', ['topicId' => $topic->id]) }}">Contenidos</a>
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
    </style>
@stop

@section('js') 
@stop
