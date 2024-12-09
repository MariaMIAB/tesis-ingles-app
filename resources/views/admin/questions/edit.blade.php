@extends('layouts.admin.app')

@section('title', 'Editar Preguntas')

@section('content_header')
    <div class="card bg-warning">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Editar Preguntas</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="exam-form" method="POST" action="{{ route('questions.update', $exam->id) }}">
            @csrf
            @method('PUT')
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <h2 class="card-title">Resumen del Examen</h2>
                </div>
                <div class="card-body">
                    <p><strong>Título:</strong> {{ $exam->title }}</p>
                    <p><strong>Descripción:</strong> {{ $exam->description }}</p>
                </div>
            </div>

            <div id="questions-section">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>Editar Preguntas</h3>
                            </div>
                            <div class="card-body">
                                @foreach ($exam->questions as $question)
                                    <div class="form-group question" id="question-{{ $question->id }}">
                                        <label>Pregunta</label>
                                        <input type="text" class="form-control" name="questions[{{ $question->id }}][content]" value="{{ old('questions.' . $question->id . '.content', $question->content) }}" required>
                                        <input type="hidden" name="questions[{{ $question->id }}][type]" value="{{ $question->type }}">
                                        <input type="hidden" name="questions[{{ $question->id }}][exam_id]" value="{{ $exam->id }}">
                                
                                        @if ($question->type == 'multiple_choice')
                                            <label>Opciones</label>
                                            <div id="options-container-{{ $question->id }}" class="mb-3">
                                                @foreach ($question->options as $option)
                                                    <div class="input-group mb-2">
                                                        <input type="text" class="form-control" name="questions[{{ $question->id }}][options][]" value="{{ old('questions.' . $question->id . '.options.' . $loop->index, $option->content) }}" required>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button class="btn btn-outline-secondary add-option-btn mb-3" type="button" data-question-id="{{ $question->id }}">Añadir Opción</button>
                                        @elseif ($question->type == 'true_false')
                                            <label>Respuesta</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="questions[{{ $question->id }}][answer]" value="true" {{ old('questions.' . $question->id . '.answer', $question->answers->first()->content) == 'true' ? 'checked' : '' }} required>
                                                <label class="form-check-label">Verdadero</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="questions[{{ $question->id }}][answer]" value="false" {{ old('questions.' . $question->id . '.answer', $question->answers->first()->content) == 'false' ? 'checked' : '' }} required>
                                                <label class="form-check-label">Falso</label>
                                            </div>
                                        @elseif ($question->type == 'short_answer')
                                            <label>Respuesta</label>
                                            <input type="text" class="form-control mb-3" name="questions[{{ $question->id }}][answer]" value="{{ old('questions.' . $question->id . '.answer', $question->answers->first()->content) }}" required>
                                        @endif
                                
                                        <button class="btn btn-danger remove-question-btn" type="button" data-question-id="{{ $question->id }}">Eliminar Pregunta</button>
                                    </div>
                                @endforeach                       
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-warning">Guardar Cambios</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let questionCount = {{ count($exam->questions) }}; // Número de preguntas existentes

            // Añadir nueva opción a una pregunta de selección múltiple
            document.getElementById('questions-section').addEventListener('click', function (e) {
                if (e.target.classList.contains('add-option-btn')) {
                    const questionId = e.target.getAttribute('data-question-id');
                    const optionsContainer = document.getElementById(`options-container-${questionId}`);
                    const optionCount = optionsContainer.querySelectorAll('.input-group').length;

                    if (optionCount < 5) {
                        optionsContainer.insertAdjacentHTML('beforeend', `  
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" name="questions[${questionId}][options][]" placeholder="Opción ${optionCount + 1}" required>
                            </div>
                        `);
                        if (optionCount + 1 === 5) {
                            e.target.remove(); // Limita a 5 opciones
                        }
                    }
                } else if (e.target.classList.contains('remove-question-btn')) {
                    const questionId = e.target.getAttribute('data-question-id');
                    const questionDiv = document.getElementById(`question-${questionId}`);
                    questionDiv.remove();
                }
            });
        });
    </script>
@endsection


