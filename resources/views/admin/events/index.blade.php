@extends('layouts.admin.app')

@section('title', 'Usuarios')

@section('content_header')
    <div class="card bg-success text-white shadow-sm">
        <div class="card-header text-center">
            <h1 class="font-weight-bold" style="border-bottom: 4px solid white;">📅 Lista de Eventos</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="text-success font-weight-bold">📋 Gestión de Eventos</h4>
            <a href="{{ route('events.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Evento
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Eventos Pasados -->
                <div class="col-md-6">
                    <h4 class="text-danger"><i class="fas fa-history"></i> Eventos Pasados</h4>
                    @if($pastEvents->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-circle"></i> No hay eventos pasados.
                        </div>
                    @else
                        <div class="event-list">
                            <ul class="list-group">
                                @foreach ($pastEvents as $event)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong class="text-danger">{{ $event->title }}</strong>
                                                <p class="mb-1 text-muted">{{ $event->description }}</p>
                                                <small class="text-secondary"><i class="fas fa-calendar-alt"></i> {{ $event->start }} - {{ $event->end }}</small>
                                            </div>
                                            <a href="{{ route('events.edit', $event->id ) }}" class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>    

                <!-- Eventos Futuros -->
                <div class="col-md-6">
                    <h4 class="text-success"><i class="fas fa-calendar-check"></i> Eventos Futuros</h4>
                    @if($upcomingEvents->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            <i class="fas fa-exclamation-circle"></i> No hay eventos futuros.
                        </div>
                    @else
                        <div class="event-list">
                            <ul class="list-group">
                                @foreach ($upcomingEvents as $event)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong class="text-success">{{ $event->title }}</strong>
                                                <p class="mb-1 text-muted">{{ $event->description }}</p>
                                                <small class="text-secondary"><i class="fas fa-calendar-alt"></i> {{ $event->start }} - {{ $event->end }}</small>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>                
            </div>                     
        </div>
    </div>
@stop

@section('css')
    <style>
        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            margin-bottom: 5px;
            border-radius: 8px;
            padding: 15px;
            transition: all 0.3s ease-in-out;
        }
        .list-group-item:hover {
            background-color: #f1f1f1;
        }
        .list-group-item strong {
            font-size: 1.2em;
        }
        .list-group-item small {
            color: #6c757d;
        }
        .event-list {
            max-height: 450px;
            overflow-y: auto;
        }
        .card-header {
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }
    </style>
@stop