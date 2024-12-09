@extends('layouts.user.app')

@section('title', 'Realizar Examen')

@section('content_header')
    <div class="card bg-primary">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Realizar Examen</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="container my-4">
        <div id="exam-container" class="card shadow">
            <div class="card-body">
                <h2 class="text-center">{{ $exam->title }}</h2>
                <p class="text-muted text-center">{{ $exam->description }}</p>

                <!-- Temporizador -->
                <div class="alert alert-warning text-center font-weight-bold" id="timer">
                    Tiempo restante: <span id="time-remaining">00:00</span>
                </div>

                <form id="user-exam-form" method="POST" action="{{ route('exam.submit', $exam->id) }}">
                    @csrf
                    <div id="questions-section">
                        @foreach ($exam->questions as $index => $question)
                            <div class="question mb-4" id="question-{{ $question->id }}">
                                <h5><span class="text-primary">{{ $index + 1 }}.</span> {{ $question->content }}</h5>

                                @if ($question->type === 'multiple_choice')
                                    <div class="options">
                                        @foreach ($question->options as $option)
                                            <div class="form-check">
                                                <input 
                                                    type="radio" 
                                                    name="answers[{{ $question->id }}]" 
                                                    value="{{ $option->id }}"
                                                    id="option-{{ $loop->index }}-question-{{ $question->id }}" 
                                                    class="form-check-input" 
                                                    required>
                                                <label class="form-check-label" for="option-{{ $loop->index }}-question-{{ $question->id }}">
                                                    {{ $option->content }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($question->type === 'true_false')
                                    <div class="form-check">
                                        <input 
                                            type="radio" 
                                            name="answers[{{ $question->id }}]" 
                                            value="true" 
                                            id="true-question-{{ $question->id }}" 
                                            class="form-check-input" 
                                            required>
                                        <label class="form-check-label" for="true-question-{{ $question->id }}">Verdadero</label>
                                    </div>
                                    <div class="form-check">
                                        <input 
                                            type="radio" 
                                            name="answers[{{ $question->id }}]" 
                                            value="false" 
                                            id="false-question-{{ $question->id }}" 
                                            class="form-check-input" 
                                            required>
                                        <label class="form-check-label" for="false-question-{{ $question->id }}">Falso</label>
                                    </div>
                                @elseif ($question->type === 'short_answer')
                                    <textarea 
                                        class="form-control" 
                                        name="answers[{{ $question->id }}]" 
                                        rows="3" 
                                        required
                                        placeholder="Escribe tu respuesta aquí"></textarea>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg mt-4">Enviar Examen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const questions = document.querySelectorAll('.question');
            const examForm = document.getElementById('user-exam-form');
            const timeRemainingElement = document.getElementById('time-remaining');
            
            // Configura el tiempo límite en minutos
            const timeLimitInMinutes = {{ $exam->duration ?? 10 }}; // Cambia '10' por el tiempo en minutos
            let timeRemaining = timeLimitInMinutes * 60; // Convierte a segundos

            // Función para actualizar el temporizador
            function updateTimer() {
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                timeRemainingElement.textContent = 
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    alert('El tiempo ha terminado. El examen será enviado automáticamente.');
                    examForm.submit(); // Envía automáticamente el formulario
                }
                timeRemaining--;
            }

            // Actualiza el temporizador cada segundo
            const timerInterval = setInterval(updateTimer, 1000);
            updateTimer();

            // Animación de entrada para las preguntas
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
