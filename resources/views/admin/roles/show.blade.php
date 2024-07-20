@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles de Rol</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Permisos del Rol {{ $role->name }}</h2>
            <hr>
            @if ($permissions->isEmpty())
                <div class="alert alert-warning" role="alert">
                    No se encontraron permisos para este rol.
                </div>
            @else
                <ul class="list-group">
                    <div class="row">
                        <div class="col-4"> 
                            @foreach ($permissions as $permission)
                                <li class="list-group-item align-items-center bg-light text-dark p-2">
                                    <span class="badge bg-success text-white">{{ $permission->id }} :</span>
                                    <span>{{ $permission->name }}</span>
                                </li>
                             @endforeach
                        </div>
                    </div>
                </ul>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .list-group-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 5px;
            padding: 0.5rem;
            transition: transform 0.2s, background-color 0.2s;
        }

        .list-group-item:hover {
            transform: scale(1.05);
            background-color: #e9ecef;
        }

        .list-group-item .badge {
            font-size: 0.85rem;
            padding: 0.3em 0.6em;
        }

        .list-group-item span {
            font-weight: bold;
            margin-left: 5px;
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