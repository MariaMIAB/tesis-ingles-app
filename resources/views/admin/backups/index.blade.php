@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-dark shadow-sm">
        <div class="card-header">
            <h1 class="text-white font-weight-bold text-center">📂 Gestión de Backups</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="d-flex justify-content-center gap-3 mb-4">
                <form action="{{ route('backups.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="database">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-database"></i> Backup Base de Datos
                    </button>
                </form>
            
                <form action="{{ route('backups.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="files">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-folder"></i> Backup del Sistema
                    </button>
                </form>
            
                <form action="{{ route('backups.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" value="full">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-archive"></i> Backup Completo
                    </button>
                </form>
            </div>
            

            <div class="table-responsive">
                <table class="table table-hover table-striped border rounded shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>📄 Nombre del Backup</th>
                            <th class="text-center">🕒 Fecha</th>
                            <th class="text-center">📌 Estado</th>
                            <th class="text-center">⚡ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups as $backup)
                            <tr>
                                <td class="align-middle">
                                    <i class="fas fa-file-archive text-secondary"></i> {{ $backup->path() }}
                                </td>
                                <td class="text-center align-middle">
                                    {{ $backup->date()->format('Y-m-d H:i:s') }}
                                </td>
                                <td class="text-center align-middle">
                                    <span class="badge {{ $loop->first ? 'bg-success' : 'bg-danger' }} p-2">
                                        {{ $loop->first ? 'Último' : 'Antiguo' }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('backups.download') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="path" value="{{ $backup->path() }}">
                                        <button type="submit" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-download"></i> Descargar
                                        </button>
                                    </form>
                                </td>                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: #343a40 !important;
            color: #ffffff !important;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .btn {
            font-weight: bold;
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