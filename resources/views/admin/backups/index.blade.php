
@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles del Backup</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <div class="d-flex btn-group-custom mb-3">
                <form action="{{ route('backups.create') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Backup del sistema</button>
                </form>
            </div>          
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($backups as $backup)
                        <tr>
                            <td>{{ $backup->path() }}</td>
                            <td class="text-center">{{ $backup->date()->format('Y-m-d H:i:s') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $loop->first ? 'badge-success' : 'badge-danger' }}">
                                    {{ $loop->first ? 'Último' : 'Antiguo' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('backups.download') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="path" value="{{ $backup->path() }}">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </form>
                            </td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
@stop


@section('css')
    <style>
        .btn-group-custom form {
            margin-right: 10px;
        }
        .btn-group-custom form:last-child {
            margin-right: 0;
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
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        });
    </script>
    @endif
@stop