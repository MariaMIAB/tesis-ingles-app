@extends('layouts.admin.app')
@section('title', 'Ver Contenido')
@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles del Contenido</h1>
        </div>
    </div>
@stop
@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="d-flex">
                        <span><strong>Título del Contenido:</strong> <span>{{ $content->title }}</span></span>
                    </div>
                    <hr class="custom-hr">
                    <div class="d-flex">
                        <span><strong>Cuerpo del Contenido:</strong> <span>{!! $content->body !!}</span></span>
                    </div>
                    <hr class="custom-hr">
                    <div>
                        <div>
                            <span><strong>Imágenes del Contenido:</strong></span>
                        </div>
                        <div>
                            @if ($content->hasMedia('content_images'))
                                @foreach($content->getMedia('content_images') as $image)
                                <img src="{{ $content->first_content_image_url }}" class="img-fluid rounded shadow border border-success mt-3 mb-3" alt="Imagen del Contenido" style="max-width: 150px;">
                                @endforeach
                            @else
                            <img src="{{ asset('/storage/imagenes/sistema/alt-de-una-imagen.png') }}" class="img-fluid rounded shadow border border-success mt-3 mb-3" alt="Imagen por defecto" style="max-width: 150px;">
                            @endif
                        </div>
                    </div>
                    <hr class="custom-hr">
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <p><strong>Tema:</strong> <span>{{ $content->topic->topic_name }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Año:</strong> <span>{{ $content->topic->semester->year->name }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Semestre:</strong> <span>{{ $content->topic->semester->name }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Fecha de Creación:</strong> <span>{{ $content->created_at }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Última Actualización:</strong> <span>{{ $content->updated_at }}</span></p>
                </div>
            </div>
            <a class="btn btn-secondary" href="{{ route('topics.contents.index', ['topicId' => $content->topic_id]) }}">Atrás</a>
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
        .content-images { 
            display: flex; flex-wrap: wrap; 
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
@stop


