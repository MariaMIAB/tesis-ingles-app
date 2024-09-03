@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles de Usuario</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="d-flex">
                        <span><strong>Titulo:</strong> <span>{{ $event->title }}</span></span>
                    </div>
                    <hr class="custom-hr">
                    <span>{{ $event->description }}</span>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6"> 
                    <hr class="custom-hr">
                    <p><strong>Creado el:</strong> <span>{{ $event->created_at }}</span></p>
                    <hr class="custom-hr">
                    <p><strong>Actualizado el:</strong> <span>{{ $event->updated_at }}</span></p>
                </div>
            </div>
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

        .img-fluid {
            max-width: 100%;
            height: auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .img-fluid:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 128, 0, 1);
            border-color: rgba(0, 128, 0, 1);
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
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif
@stop