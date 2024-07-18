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
            <ul class="list-group">
                <div class="row">
                    <div class="col-6"> 
                        @foreach ($permissions as $permission)
                            <li class="list-group-item">
                                <span class="badge bg-success">{{ $permission->id }}</span>
                                <span>{{ $permission->name }}</span>
                            </li>
                         @endforeach
                    </div>
                </div>
            </ul>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos adicionales para la lista */
        .list-group-item {
            border: none;
        }
        .badge {
            font-size: 0.8rem;
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