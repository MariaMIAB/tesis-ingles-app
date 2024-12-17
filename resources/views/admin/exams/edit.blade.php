@extends('layouts.admin.app')

@section('title', 'Editar Examen')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Editar Examen</h1>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Formulario para crear examen -->
            <form action="{{ route('exams.update', $exam) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.exams.partials._form')
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
@endsection