@extends('layouts.user.app')

@section('content')
    <div class="topics-container">
        <div class="row">
            <div>
                <h1 class="page-title">Liste de Temas</h1>
                <hr class="custom-hr2">
            </div>
            @foreach($topics as $topic)
                <div class="col-md-4">
                    <div class="card card-dm">
                        <div class="card-body">
                            <h5 class="card-title topic-title">{{ $topic->topic_name }}</h5>
                            <hr class="custom-hr">
                            <p class="card-text">{{ Str::limit($topic->topic_description, 200, '...') }}</p>
                            <a href="{{ route('topicsu.show', $topic->id) }}" class="btn btn-primary btn-block mt-auto">Contenidos</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .topics-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 30px;
        text-align: center;
    }

    .card {
        margin: 20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border-radius: 10px;
        height: 250px !important; /* Altura fija para todas las tarjetas */
        display: flex;
        flex-direction: column;
    }

    .card-dm:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .topic-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .custom-hr {
        border: 0;
        height: 2px;
        background: linear-gradient(to right, #007bff, #00d4ff);
        margin: 15px 0;
    }

    .custom-hr2 { 
        border: 3px solid #007bff; /* Borde sólido más grande */ 
        height: 10px; /* Ajustar la altura para darle más cuerpo */ 
        background-color: #007bff; /* Color de fondo */ 
        margin: 15px 0; /* Espacio superior e inferior */ 
        width: 98%; /* Ancho del hr */ 
        margin-left: auto; 
        margin-right: auto; 
        border-radius: 5px; /* Bordes redondeados */ 
    }

    .card-text {
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Número de líneas que se muestran */
        -webkit-box-orient: vertical;
    }

    .btn-block {
        width: 100%;
    }

    .mt-auto {
        margin-top: auto; 
    }
</style>

