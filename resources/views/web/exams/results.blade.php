@extends('layouts.user.app')

@section('title', 'Resultados del Examen')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold">Resultados del Examen: {{ $exam->title }}</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="container my-4">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="text-center animated fadeIn">Resultados del Examen</h2>
                <p class="text-muted text-center">Has completado el examen <strong>{{ $exam->title }}</strong></p>

                @if(isset($attemptResults) && count($attemptResults) > 0)
                    <div class="card mt-4">
                        <div class="card-header bg-info text-white">
                            <h4 class="mb-0">Tus últimos intentos</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nota</th>
                                        <th>Correctas</th>
                                        <th>Resultado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attemptResults as $index => $attempt)
                                        <tr class="{{ $attempt['is_best'] ? 'table-success' : '' }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $attempt['score'] }}%</td>
                                            <td>{{ $attempt['correctCount'] ?? '-' }}</td> <!-- Evitar error si falta correctCount -->
                                            <td>
                                                @if ($attempt['is_best'])
                                                    <span class="badge bg-success">Mejor intento 🎉</span>
                                                @else
                                                    <span class="badge bg-secondary">Intento previo</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

<br>
                <!-- Mostrar puntaje con estilo mejorado -->
                <div class="alert alert-info text-center animated fadeIn">
                    <strong class="puntaje">Puntaje:</strong> <span class="puntaje-number">{{ $score }}%</span>
                    <strong class="correctas">Respuestas correctas:</strong> <span class="correctas-number">{{ $correctCount }} / {{ $exam->questions->count() }}</span>
                </div>

                <!-- Listar las preguntas y respuestas -->
                <div id="questions-section">
                    @foreach ($exam->questions as $index => $question)
                        <div class="question mb-4" id="question-{{ $question->id }}">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5><span class="text-primary">{{ $index + 1 }}.</span> {{ $question->content }}</h5>

                                <!-- Mensaje Correcto o Incorrecto -->
                                @php
                                    $isCorrect = isset($userAnswers[$question->id]) && 
                                        ($question->type === 'multiple_choice' ? 
                                            (int) $userAnswers[$question->id]->answer === (int) $correctAnswers[$question->id]->id :
                                            strtolower(trim($userAnswers[$question->id]->answer)) === strtolower(trim($correctAnswers[$question->id]->content)));
                                @endphp

                                @if(isset($userAnswers[$question->id]))
                                    @if($isCorrect)
                                        <span class="badge badge-success animated fadeIn">Correcto</span>
                                    @else
                                        <span class="badge badge-danger animated fadeIn">Incorrecto</span>
                                    @endif
                                @else
                                    <span class="badge badge-warning animated fadeIn">No respondida</span>
                                @endif
                            </div>

                            <!-- Opciones de respuesta para las preguntas de tipo multiple_choice -->
                            @if ($question->type === 'multiple_choice')
                                <div class="options">
                                    @foreach ($question->options as $option)
                                        <div class="form-check">
                                            <label class="form-check-label @if($option->is_correct) text-success font-weight-bold @endif">
                                                <input type="radio" class="form-check-input" disabled
                                                    @if(isset($userAnswers[$question->id]) && (int) $userAnswers[$question->id]->answer === $option->id) checked @endif>
                                                {{ $option->content }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($question->type === 'true_false')
                                <div class="form-check">
                                    <label class="form-check-label @if($correctAnswers[$question->id]->content === 'true') text-success font-weight-bold @endif">
                                        <input type="radio" class="form-check-input" disabled
                                            @if(isset($userAnswers[$question->id]) && $userAnswers[$question->id]->answer === 'true') checked @endif>
                                        Verdadero
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="form-check-label @if($correctAnswers[$question->id]->content === 'false') text-success font-weight-bold @endif">
                                        <input type="radio" class="form-check-input" disabled
                                            @if(isset($userAnswers[$question->id]) && $userAnswers[$question->id]->answer === 'false') checked @endif>
                                        Falso
                                    </label>
                                </div>
                            @elseif ($question->type === 'short_answer')
                                <div class="form-check">
                                    <textarea class="form-control" disabled>{{ $userAnswers[$question->id]->answer ?? '' }}</textarea>
                                    <small class="text-success">Respuesta correcta: {{ $correctAnswers[$question->id]->content }}</small>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('topicsu.show', $exam->topic->id) }}" class="btn btn-primary">Volver al Tema</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .puntaje {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
        }

        .puntaje-number {
            font-size: 1.5em;
            color: #28a745;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 123, 255, 0.3);
        }

        .correctas {
            font-size: 1.2em;
            font-weight: bold;
            color: #007bff;
        }

        .correctas-number {
            font-size: 1.5em;
            color: #28a745;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 123, 255, 0.3);
        }

        .badge-success {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            margin-left: 10px;
            animation: bounceIn 0.5s ease-out;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
            margin-left: 10px;
            animation: shake 0.5s ease-out;
        }

        .badge-warning {
            background-color: #ffc107;
            color: white;
            font-weight: bold;
            margin-left: 10px;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            60% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes shake {
            0% {
                transform: translateX(-10px);
            }
            25% {
                transform: translateX(10px);
            }
            50% {
                transform: translateX(-10px);
            }
            75% {
                transform: translateX(10px);
            }
            100% {
                transform: translateX(0);
            }
        }

        .form-check {
            margin-bottom: 10px;
        }

        .animated.fadeIn {
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = document.querySelectorAll('.question');
            questions.forEach((question, index) => {
                question.style.opacity = '0';
                question.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    question.style.opacity = '1';
                }, index * 200);
            });
        });
    </script>
@stop