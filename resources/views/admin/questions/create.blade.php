@extends('layouts.admin.app')

@section('title', 'Crear Preguntas')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Agregar Preguntas</h1>
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

        <form id="exam-form" method="POST" action="{{ route('questions.store', ['exam' => $exam->id]) }}">
            @csrf
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <h2 class="card-title">Resumen del Examen</h2>
                </div>
                <div class="card-body">
                    <p><strong>Título:</strong> {{ $exam->title }}</p>
                    <p><strong>Descripción:</strong> {{ $exam->description }}</p>
                    <button id="expand-questions" type="button" class="btn btn-primary">Añadir Preguntas</button>
                </div>
            </div>

            <div id="questions-section" style="display: none;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h3>Añadir Preguntas</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="question-type">Tipo de Pregunta</label>
                                    <select id="question-type" class="form-control">
                                        <option value="true_false">Verdadero/Falso</option>
                                        <option value="short_answer">Respuesta Corta</option>
                                        <option value="multiple_choice">Selección Múltiple</option>
                                    </select>
                                </div>
                                <div id="questions-container"></div>
                                <button id="add-question-btn" type="button" class="btn btn-success">Añadir Pregunta</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar y Enviar</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const examId = {{ $exam->id }};  // ID del examen
            let questionCount = 0;  // Contador para preguntas
            const questionsContainer = document.getElementById('questions-container');
            const expandQuestionsBtn = document.getElementById('expand-questions');
            const questionsSection = document.getElementById('questions-section');
            const addQuestionBtn = document.getElementById('add-question-btn');
            const questionTypeSelect = document.getElementById('question-type');
            
            // Mostrar la sección de preguntas al hacer clic
            expandQuestionsBtn.addEventListener('click', () => {
                questionsSection.style.display = 'block';
                expandQuestionsBtn.style.display = 'none';
            });

            // Añadir una nueva pregunta
            addQuestionBtn.addEventListener('click', () => {
                const selectedType = questionTypeSelect.value;
                addQuestion(selectedType);
            });

            function addQuestion(type) {
                const questionHTML = getQuestionHTML(type);
                const questionDiv = document.createElement('div');
                questionDiv.innerHTML = questionHTML;
                questionsContainer.appendChild(questionDiv.firstElementChild);
                questionCount++;
            }

            // Generar el HTML según el tipo de pregunta
            function getQuestionHTML(type) {
                const commonHTML = `
                    <div class="form-group question" id="question-${questionCount}">
                        <label>Pregunta</label>
                        <input type="text" class="form-control" name="questions[${questionCount}][content]" required>
                        <input type="hidden" name="questions[${questionCount}][type]" value="${type}">
                        <input type="hidden" name="questions[${questionCount}][exam_id]" value="${examId}">
                `;

                if (type === 'multiple_choice') {
                    return `
                        <div class="question" id="question-${questionCount}">
                            <h4>Pregunta de Selección Múltiple</h4>
                            ${commonHTML}
                            <label>Opciones</label>
                            <div id="options-container-${questionCount}" class="mb-3">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" placeholder="Opción 1" required>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" placeholder="Opción 2" required>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary add-option-btn mb-3" type="button" data-question-id="${questionCount}">Añadir Opción</button>
                            <label>Respuesta Correcta</label>
                            <input type="text" class="form-control mb-3" name="questions[${questionCount}][correct_answer]" placeholder="Debe coincidir con una opción" required>
                            <button class="btn btn-danger remove-question-btn" type="button" data-question-id="${questionCount}">Eliminar Pregunta</button>
                        </div>`;
                } else if (type === 'short_answer') {
                    return `
                        <div class="question" id="question-${questionCount}">
                            <h4>Pregunta de Respuesta Corta</h4>
                            ${commonHTML}
                            <label>Respuesta</label>
                            <input type="text" class="form-control mb-3" name="questions[${questionCount}][answer]" required>
                            <button class="btn btn-danger remove-question-btn" type="button" data-question-id="${questionCount}">Eliminar Pregunta</button>
                        </div>`;
                } else if (type === 'true_false') {
                    return `
                        <div class="question" id="question-${questionCount}">
                            <h4>Pregunta de Verdadero/Falso</h4>
                            ${commonHTML}
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${questionCount}][answer]" value="true" required>
                                <label class="form-check-label">Verdadero</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="questions[${questionCount}][answer]" value="false" required>
                                <label class="form-check-label">Falso</label>
                            </div>
                            <button class="btn btn-danger remove-question-btn" type="button" data-question-id="${questionCount}">Eliminar Pregunta</button>
                        </div>`;
                }
            }

            // Event listener para añadir más opciones en las preguntas de selección múltiple
            questionsContainer.addEventListener('click', function (e) {
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











