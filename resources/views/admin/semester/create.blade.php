@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Agregar Semestre</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <h2>Año Escolar: {{ $year->name }}</h2>
            <p class="custom-dates">
                <strong>Fecha de Inicio:</strong> <span>{{ $year->start_date }}</span>|
                <strong>Fecha de Fin:</strong> <span> {{ $year->end_date }}</span>
            </p>
            <hr class="custom-hr">
            <h3>Semestres:</h3>
            <form action="{{ route('semesters.storeOrUpdate', $year->id) }}" method="POST">
                @csrf
                @method('POST')
                @include('admin.semester.partials._form')
                <a class="btn btn-secondary" href="{{ route('years.index') }}">Atras</a>
                <button type="submit" class="btn btn-primary">Guardar Semestres</button>
            </form>
        </div>
    </div>
@stop

@section('css')

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