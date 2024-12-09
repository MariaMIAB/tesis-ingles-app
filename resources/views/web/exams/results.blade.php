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

                <!-- Mostrar puntaje con estilo mejorado -->
                <div class="alert alert-info text-center animated fadeIn">
                    <strong class="puntaje">Puntaje: </strong> <span class="puntaje-number">{{ $score }}</span>   
                    <strong class="correctas">Respuestas correctas:</strong> <span class="correctas-number">{{$correctCount}} / {{ $exam->questions->count() }}</span>
                </div>

                <!-- Listar las preguntas y respuestas -->
                <div id="questions-section">
                    @foreach ($exam->questions as $index => $question)
                        <div class="question mb-4" id="question-{{ $question->id }}">
                            <div class="d-flex align-items-center" style="justify-content: space-between;">
                                <h5><span class="text-primary">{{ $index + 1 }}.</span> {{ $question->content }}</h5>

                                <!-- Mensaje Correcto o Incorrecto al mismo nivel que la pregunta -->
                                @if(isset($userAnswers[$question->id]))
                                    @if($userAnswers[$question->id]->answer == $correctAnswers[$question->id]->content)
                                        <span class="badge badge-success animated fadeIn">Correcto</span>
                                    @else
                                        <span class="badge badge-danger animated fadeIn">Incorrecto</span>
                                    @endif
                                @endif
                            </div>

                            <!-- Opciones de respuesta para las preguntas de tipo multiple_choice -->
                            @if ($question->type === 'multiple_choice')
                                <div class="options">
                                    @foreach ($question->options as $option)
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" disabled
                                                    @if($userAnswers[$question->id]->answer == $option->id) checked @endif>
                                                {{ $option->content }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif ($question->type === 'true_false')
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled
                                            @if($userAnswers[$question->id]->answer == 'true') checked @endif>
                                        Verdadero
                                    </label>
                                </div>

                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" disabled
                                            @if($userAnswers[$question->id]->answer == 'false') checked @endif>
                                        Falso
                                    </label>
                                </div>
                            @elseif ($question->type === 'short_answer')
                                <div class="form-check">
                                    <textarea class="form-control" disabled>{{ $userAnswers[$question->id]->answer }}</textarea>
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
        /* Estilo para el Puntaje */
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

        /* Resaltar respuestas correctas */
        .badge-success {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            margin-left: 10px;
            animation: bounceIn 0.5s ease-out;
        }

        /* Resaltar respuestas incorrectas */
        .badge-danger {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
            margin-left: 10px;
            animation: shake 0.5s ease-out;
        }

        /* Animación para "Correcto" y "Incorrecto" */
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

        /* Estilo para las respuestas */
        .form-check {
            margin-bottom: 10px;
        }

        /* Efecto fadeIn al cargar */
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
@endsection
