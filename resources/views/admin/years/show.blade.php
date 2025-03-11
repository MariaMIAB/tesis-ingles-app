@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Estudiantes del Año</h1>
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
                    <h3>Estudiantes y Notas</h3>

                    @if($students->isEmpty())
                        <p class="text-warning">No hay estudiantes registrados para este año.</p>
                    @else
                        <div class="legend">
                            <span><i class="fas fa-tasks"></i> Actividades</span>
                            <span><i class="fas fa-file-alt"></i> Exámenes</span>
                            <span><i class="fas fa-percentage"></i> Total</span>
                            <span><i class="fas fa-chart-line"></i> Nota Estimada</span>
                            <span><i class="fas fa-award"></i> Promedio Final</span>
                            <span><i class="fas fa-graduation-cap"></i> Nota Final Estimada</span>
                        </div>

                        <table class="table table-bordered text-center table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Estudiante</th>
                                    @foreach($year->semesters as $semester)
                                        <th colspan="4" class="text-center">{{ $semester->name }}</th>
                                    @endforeach
                                    <th>Promedio Final</th>
                                    <th>Nota Final Estimada</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    @foreach($year->semesters as $semester)
                                        <th><i class="fas fa-tasks"></i></th>
                                        <th><i class="fas fa-file-alt"></i></th>
                                        <th><i class="fas fa-percentage"></i></th>
                                        <th><i class="fas fa-chart-line"></i></th>
                                    @endforeach
                                    <th><i class="fas fa-award"></i></th>
                                    <th><i class="fas fa-graduation-cap"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td class="font-weight-bold">{{ $student->name }}</td>
                                        @php 
                                            $totalFinal = 0; 
                                            $countFinal = 0; 
                                            $finalEstimated = $studentScores[$student->id]['final_estimated'] ?? 0;
                                        @endphp

                                        @foreach($year->semesters as $semester)
                                            @php
                                                $scores = $studentScores[$student->id][$semester->id] ?? null;
                                                $activity = $scores['activities'] ?? null;
                                                $exam = $scores['exams'] ?? null;
                                                $total = $scores['total'] ?? null;
                                                $estimated = $scores['estimated'] ?? 0;

                                                $activityColor = $activity !== null ? ($activity < 50 ? 'text-danger' : 'text-success') : 'text-warning';
                                                $examColor = $exam !== null ? ($exam < 50 ? 'text-danger' : 'text-success') : 'text-warning';
                                                $totalColor = $total !== null ? ($total < 50 ? 'text-danger' : 'text-success') : 'text-warning';
                                                $estimatedColor = $estimated < 50 ? 'text-danger' : 'text-success';

                                                if ($total !== null) {
                                                    $totalFinal += $total;
                                                    $countFinal++;
                                                }
                                            @endphp
                                            
                                            <td class="font-weight-bold {{ $activityColor }}">
                                                {{ $activity !== null ? number_format($activity, 2) : '-' }}
                                            </td>

                                            <td class="font-weight-bold {{ $examColor }}">
                                                {{ $exam !== null ? number_format($exam, 2) : '-' }}
                                            </td>

                                            <td class="font-weight-bold {{ $totalColor }}">
                                                {{ $total !== null ? number_format($total, 2) : '-' }}
                                            </td>

                                            <td class="font-weight-bold {{ $estimatedColor }}">
                                                {{ number_format($estimated, 2) }}
                                            </td>
                                        @endforeach

                                        <td class="font-weight-bold text-primary">
                                            @if ($countFinal === count($year->semesters))
                                                {{ number_format($totalFinal / $countFinal, 2) }}
                                            @elseif ($countFinal > 0)
                                                <span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Notas incompletas</span>
                                            @else
                                                <span class="text-danger"><i class="fas fa-times-circle"></i> Sin notas</span>
                                            @endif
                                        </td>

                                        <td class="font-weight-bold text-info">
                                            {{ number_format($finalEstimated, 2) }}
                                        </td>
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

        .table th, .table td {
            vertical-align: middle;
        }

        .font-weight-bold {
            font-size: 1.1em;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .text-primary {
            color: #007bff !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .text-info {
            color: #17a2b8 !important;
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

        .legend {
            margin-bottom: 15px;
            font-size: 1em;
            font-weight: bold;
        }

        .legend span {
            margin-right: 15px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
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
