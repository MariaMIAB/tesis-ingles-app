@extends('layouts.admin.app')

@section('title', 'Usuarios')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Usuarios</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <ul>
                @foreach($students as $student)
                    <li>{{ $student->name }} - {{ $student->email }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')

@stop