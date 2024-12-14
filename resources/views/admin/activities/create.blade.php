@extends('layouts.admin.app')

@section('title', 'Actividad')

@section('content_header')
    <h1>Crear Actividad</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('activities.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    @include('admin.activities.partials._form')
                    <br>
                </div>
                <div>
                    <a class="btn btn-secondary" href="{{ route('activities.index') }}">Atrás</a>
                    <button class="btn btn-success" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>


/* Estilo para el botón */
        .btn-h5p {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            background-color: #28a745; /* Verde H5P */
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Efecto al pasar el ratón */
        .btn-h5p:hover {
            background-color: #218838; /* Color más oscuro cuando se pasa el ratón */
            transform: translateY(-3px); /* Mueve ligeramente el botón hacia arriba */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Sombra más fuerte */
        }

        /* Efecto al hacer clic */
        .btn-h5p:active {
            transform: translateY(0); /* Hace que el botón vuelva a su posición */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra más suave al hacer clic */
        }

        .img-highlight {
            border: 2px solid #10c245;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .img-highlight:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px #10c245;
        }

        .form-control {
            border-radius: 5px;
            transition: border-color 0.2s ease;
        }

        .form-control:hover {
            border-color: #0cb93a;
        }
    </style>
@stop

@section('js')
    <!-- Añade aquí cualquier script necesario -->
@stop
