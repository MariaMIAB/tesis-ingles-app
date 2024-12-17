@extends('layouts.admin.app')

@section('title', 'Ver Examen')

@section('content_header')
<div class="card bg-primary">
    <div class="card-header">
        <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles del Examen</h1>
    </div>
</div>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="d-flex">
                    <span><strong>Título del Examen:</strong> <span>{{ $exam->title }}</span></span>
                </div>
                <hr class="custom-hr">
                <div class="d-flex">
                    <span><strong>Descripción del Examen:</strong> <span>{!! $exam->description !!}</span></span>
                </div>
                <hr class="custom-hr">
                <div class="d-flex">
                    <span><strong>Tipo de Examen:</strong> <span>{{ ucfirst(str_replace('_', ' ', $exam->type)) }}</span></span>
                    <span class="ml-3"><strong>Visible:</strong> <span>{{ $exam->visible ? 'Sí' : 'No' }}</span></span>
                    <span class="ml-3"><strong>Duración:</strong> <span>{{ $exam->duration }} minutos</span></span>
                </div>
                <hr class="custom-hr">
                <div class="d-flex">
                    <span><strong>Año:</strong> 
                        <span>
                            @if($exam->semester && $exam->semester->year)
                                {{ $exam->semester->year->name }} ({{ $exam->semester->year->start_date }} - {{ $exam->semester->year->end_date }})
                            @else
                                No asignado
                            @endif
                        </span>
                    </span>
                </div>
                <hr class="custom-hr">
                <div class="d-flex">
                    <span><strong>Semestre:</strong> <span>{{ $exam->semester->name }}</span></span>
                </div>
                <hr class="custom-hr">
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-6">
                <p><strong>Tema:</strong> <span>{{ $exam->topic->topic_name }}</span></p>
                <hr class="custom-hr">
                <div class="d-flex">
                    <span><strong>Fecha de Creación:</strong> <span>{{ $exam->created_at->format('d/m/Y H:i') }}</span></span>
                    <span class="ml-3"><strong>Última Actualización:</strong> <span>{{ $exam->updated_at->format('d/m/Y H:i') }}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <h3 class="text-primary">Preguntas del Examen</h3>
        <hr class="custom-hr">
        @if($exam->questions->isEmpty())
            <div class="alert alert-warning text-center">
                <strong>No hay preguntas disponibles para este examen.</strong>
                <div class="mt-3">
                    <a class="btn btn-success btn-lg" href="{{ route('questions.create', $exam) }}">
                        <i class="fas fa-plus"></i> Agregar Preguntas
                    </a>
                </div>
            </div>
        @else
            <div class="card questions-container">
                <div class="card-body questions-scroll">
                    @foreach($exam->questions as $question)
                        <div class="card mb-3 question-card" 
                             data-question='{{ json_encode($question) }}' 
                             onclick="showQuestionDetail(this, {{ json_encode($question) }})">
                            <div class="card-body">
                                <p><strong>Pregunta:</strong> {{ $question->content }}</p>
                                <p><strong>Tipo:</strong> {{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal para mostrar los detalles de la pregunta -->
<div class="question-detail-modal" id="questionDetailModal">
    <div class="modal-content" id="modalContent">
        <!-- Aquí se cargarán los detalles -->
    </div>
</div>

<div class="d-flex justify-content-between mt-4">
    <a class="btn btn-secondary" href="{{ route('exams.index') }}">
        <i class="fas fa-arrow-left"></i> Atrás
    </a>
    <a class="btn btn-primary" href="{{ route('questions.edit', $exam) }}">
        <i class="fas fa-edit"></i> Editar preguntas
    </a>
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

        .question-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border-radius: 25px;
            background-color: #e9f7ef;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            overflow: hidden;
        }

        .question-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .question-card.zoomed {
            animation: 1.5s cubic-bezier(.25, 1, .30, 1) square-in-center both;
            z-index: 1000;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1);
            border-radius: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .questions-container {
            background: linear-gradient(135deg, #e9f7ef, #d4edda);
            border-radius: 20px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .questions-scroll {
            max-height: 500px;
            overflow-y: auto;
        }

        .question-detail-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .question-detail-modal.show {
            display: block;
            opacity: 1;
        }

        .modal-content {
            background-color: transparent;
            margin: 10% auto;
            padding: 20px;
            border: none;
            width: 80%;
            max-width: 600px;
            border-radius: 20px;
            box-shadow: none;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }

        .btn-lg {
            font-size: 1.25rem;
            padding: 10px 20px;
        }

        .d-flex.justify-content-between a {
            padding: 10px 20px;
        }

        [transition-style="in:square:center"] {
            animation: 1.5s cubic-bezier(.25, 1, .30, 1) square-in-center both;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('questionDetailModal');
            const modalContent = document.getElementById('modalContent');

            if (!modal || !modalContent) {
                console.error("Modal or Modal Content not found in DOM.");
                return;
            }

            // Función para mostrar los detalles de la pregunta al hacer clic
            window.showQuestionDetail = (element, questionData) => {
                modalContent.innerHTML = ''; // Limpiamos el contenido anterior

                // Clonamos el card que fue clickeado y le añadimos clase para la animación
                const cardClone = element.cloneNode(true);
                cardClone.classList.add('zoomed');

                // Agregamos estilo de transición personalizado
                cardClone.setAttribute('transition-style', 'in:square:center');

                // Agregamos el card clonado al modal
                modalContent.appendChild(cardClone);
                modal.classList.add('show');
            };

            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('show');
                    modalContent.innerHTML = ''; // Limpiamos el contenido del modal
                }
            });
        });
    </script>
@stop

