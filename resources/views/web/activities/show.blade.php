@extends('layouts.user.app')

@section('title', 'Ver Actividad')

@section('content_header')
    <div class="card bg-primary">
        <div class="card-header text-white font-weight-bold">
            <h1 style="border-bottom: 4px solid white;">Detalles de la Actividad</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-lg mt-4">
        <div class="card-body">
            {{-- Mensajes de error y éxito --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Datos generales de la actividad --}}
            <div class="d-flex justify-content-between">
                <h2 class="card-title">{{ $activity->title }}</h2>
                <p class="text-muted"><strong>Tema:</strong> {{ $activity->topic->topic_name }}</p>
            </div>
            <hr class="custom-hr">
            <p class="card-text">{{ $activity->description }}</p>
            <hr class="custom-hr">
            <div class="d-flex justify-content-between text-muted">
                <p><strong>Creado:</strong> {{ $activity->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $activity->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <hr class="custom-hr">

            {{-- Mostrar contenido o resumen según el estado de la actividad --}}
            @if($isCompleted)
                <div class="alert alert-info">
                    <h4 class="text-center">✅ Actividad Completada</h4>
                    <p><strong>Puntaje final:</strong> {{ $userActivity->score }}</p>
                    <p><strong>Fecha de finalización:</strong> {{ $userActivity->completed_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Estado:</strong> <span class="badge badge-success">Completado</span></p>
                    <a class="btn btn-secondary" href="{{ route('topicsu.index') }}">Atrás</a>
                </div>
            @else
                <span><strong>Ver Actividad:</strong></span>
                <hr class="custom-hr">
                @if(!empty($embedLink))
                    <iframe id="activityFrame" src="{{ $embedLink }}" class="iframe-activity"></iframe>
                @else
                    <p class="text-danger">No se encontró un contenido válido para esta actividad.</p>
                @endif

                {{-- Sección de progreso --}}
                <div class="mt-4">
                    <h4>Progreso de la Actividad</h4>
                    <p><strong>Puntaje:</strong> <span id="score">--</span></p>
                    <p><strong>Estado:</strong> <span id="status">No iniciado</span></p>
                </div>

                {{-- Formulario para guardar progreso --}}
                <form id="progressForm" action="{{ route('store.user.activity') }}" method="POST">
                    @csrf
                    <input type="hidden" name="activity_id" value="{{ $activity->id }}">
                    <input type="hidden" name="score" id="scoreInput">

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-secondary" href="{{ route('activities.index') }}">Atrás</a>
                        <button type="submit" class="btn btn-success ml-2">Guardar Progreso</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
            margin: 20px 40px;
        }
        .card-body {
            background-color: #f8f9fa;
        }
        .card-title {
            font-size: 1.75rem;
            font-weight: bold;
        }
        .custom-hr {
            border: 0;
            height: 1px;
            background: linear-gradient(to right, rgba(0, 123, 255, 0.75), rgba(0, 123, 255, 0));
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.75);
            margin: 1rem 0;
        }
        .iframe-activity {
            width: 100%;
            height: 500px;
            border: 2px solid #007bff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var iframe = document.getElementById("activityFrame");
            if (iframe) {
                iframe.onload = function () {
                    var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                    var submitButton = iframeDoc.querySelector("input[name='submitB']");
                    if (submitButton) {
                        submitButton.addEventListener("click", function () {
                            setTimeout(getScormScore, 2000);
                        });
                    }
                };
            }
        });

        function getScormScore() {
            var iframe = document.getElementById("activityFrame");
            if (!iframe || !iframe.contentWindow || !iframe.contentDocument) {
                console.log("El iframe no está cargado aún.");
                return;
            }

            var scoreElement = iframe.contentDocument.querySelector("#quizFormScore14");
            if (scoreElement) {
                var scoreText = scoreElement.innerText.trim();
                var scoreMatch = scoreText.match(/\d+/);
                if (scoreMatch) {
                    var score = parseInt(scoreMatch[0], 10);
                    console.log("Puntaje capturado:", score);

                    document.getElementById("score").innerText = score;
                    document.getElementById("status").innerText = "Completado";
                    document.getElementById("scoreInput").value = score;

                    document.getElementById("progressForm").submit();
                }
            }
        }
    </script>
@stop
