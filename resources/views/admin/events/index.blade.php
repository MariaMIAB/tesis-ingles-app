@extends('layouts.admin.app')

@section('title', 'Usuarios')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Eventos</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('events.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Evento
            </a>      
            <hr>      
            <div class="row">
                <div class="col-md-6">
                    <h2>Eventos Pasados</h2>
                    @if($pastEvents->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            No hay eventos pasados.
                        </div>
                    @else
                        <div class="event-list">
                            <ul class="list-group">
                                @foreach ($pastEvents as $event)
                                    <li class="list-group-item">
                                        <strong>{{ $event->title }}</strong>
                                        {{ $event->description }}
                                        <a href="{{ route('events.edit', $event->id ) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a><br>
                                        <small>{{ $event->start }} - {{ $event->end }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>                
                <div class="col-md-6">
                    <h2>Eventos Futuros</h2>
                    @if($upcomingEvents->isEmpty())
                        <div class="alert alert-warning" role="alert">
                            No hay eventos futuros.
                        </div>
                    @else
                        <div class="event-list">
                            <ul class="list-group">
                                @foreach ($upcomingEvents as $event)
                                    <li class="list-group-item">
                                        <strong>{{ $event->title }}</strong>
                                        {{ $event->description }}<br>
                                        <small>{{ $event->start }} - {{ $event->end }}</small>
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
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-bottom: 5px;
            border-radius: 5px;
            padding: 10px;
        }
        .list-group-item strong {
            font-size: 1.1em;
        }
        .list-group-item small {
            color: #6c757d;
        }
        .event-list {
            max-height: 550px;
            overflow-y: auto;
        }
    </style>
@stop

@section('js')

@stop
