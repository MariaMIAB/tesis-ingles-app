@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de estudiantes del Año</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h2>Año Escolar: {{ $year->name }}</h2>
                    <p class="custom-dates">
                        <strong>Fecha de Inicio:</strong> <span>{{ $year->start_date }}</span> |
                        <strong>Fecha de Fin:</strong> <span>{{ $year->end_date }}</span>
                    </p>
                    <hr class="custom-hr">
                    <h3>Semestres</h3>
                    @if($year->semesters->isEmpty())
                        <p>No hay semestres registrados para este año.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre del Semestre</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Fecha de Fin</th>
                                    <th>Días Hábiles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($year->semesters as $semester)
                                    <tr>
                                        <td>{{ $semester->name }}</td>
                                        <td>{{ $semester->start_date }}</td>
                                        <td>{{ $semester->end_date }}</td>
                                        <td>{{ $semester->business_days }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <hr class="custom-hr">
                    <h3>Estudiantes y Notas</h3>
                    @if($year->students->isEmpty())
                        <p>No hay estudiantes registrados para este año.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Primer Trimestre</th>
                                    <th>Segundo Trimestre</th>
                                    <th>Tercer Trimestre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($year->students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')
    <style>
        .card {
            border-radius: 15px;
        }

        .card-body {
            background-color: #f8f9fa;
        }

        p {
            font-size: 1.1em;
        }

        strong {
            color: #343a40;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .img-fluid:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 128, 0, 1);
            border-color: rgba(0, 128, 0, 1);
        }

        .shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .d-flex {
            display: flex;
            align-items: center;
        }

        .ml-3 {
            margin-left: 1rem;
        }

        .custom-hr {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, rgba(0, 128, 0, 0.75), rgba(0, 128, 0, 0));
            box-shadow: 0 0 10px rgba(0, 128, 0, 0.75);
            margin: 1rem 0;
        }
        .custom-dates {
            font-weight: bold;
            color: #333;
        }

        .custom-dates span {
            margin-right: 10px;
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