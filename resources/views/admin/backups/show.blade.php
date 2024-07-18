
@extends('layouts.admin.app')

@section('title', 'Panel Administrativo')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Ver archivos del Backup</h1>
        </div>
    </div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title">Archivos de Backup en Google Drive</h2>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                    <tr>
                        <td>{{ $file }}</td>
                        <td>
                            <a href="{{ route('backups.download', ['file' => $file]) }}" class="btn btn-primary">Descargar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')

@stop