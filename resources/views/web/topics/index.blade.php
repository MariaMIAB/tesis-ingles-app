@extends('layouts.user.app')

@section('content')
    <div class="topics-container">
        <div class="row">
            <div>
                <h1 class="page-title">Lista de Temas</h1>
                <hr class="custom-hr2">
            </div>
            @foreach($topics as $topic)
                <div class="col-md-4">
                    <a href="{{ route('topicsu.show', $topic->id) }}" class="card-link">
                        <div class="card card-dm {{ $topic->activities_count == 0 ? 'no-activities' : '' }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title topic-title">{{ $topic->topic_name }}</h5>
                                <hr class="custom-hr">
                                <p class="card-text">{{ Str::limit($topic->topic_description, 100, '...') }}</p>
                                <div class="card-info mt-auto d-flex justify-content-between">
                                    <p class="card-activities {{ $topic->activities_count == 0 ? 'no-activities-text' : '' }}">
                                        @if($topic->activities_count == 0)
                                            <span class="badge badge-secondary">Sin Actividades</span>
                                        @else
                                            <span class="badge badge-success">Actividades: {{ $topic->activities_count }}</span>
                                        @endif
                                    </p>
                                    <p class="card-exams {{ $topic->exams_count == 0 ? 'no-exams-text' : '' }}">
                                        @if($topic->exams_count == 0)
                                            <span class="badge badge-secondary">Sin exámenes</span>
                                        @else
                                            <span class="badge badge-success">Exámenes disponibles: {{ $topic->exams_count }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Examen enviado exitosamente!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar',
            });
        });
    </script>
@endif

<style>
    /* Contenedor de los temas */
    .topics-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Título de la página */
    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 30px;
        text-align: center;
    }

    /* Estilo general de las cards */
    .card {
        margin: 20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        height: 350px;
        display: flex;
        flex-direction: column;
        background-color: #f9f9f9;
        overflow: hidden;
        position: relative;
        will-change: opacity, transform;
        animation-fill-mode: forwards;
    }

    /* Hover de las cards */
    .card-dm:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.3);
        transform: scale(1.05);
    }

    /* Estilo del cuerpo de las cards */
    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Títulos de las cards */
    .topic-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    /* Línea decorativa */
    .custom-hr {
        border: 0;
        height: 2px;
        background: linear-gradient(to right, #007bff, #00d4ff);
        margin: 15px 0;
    }

    /* Línea principal */
    .custom-hr2 {
        border: 3px solid #007bff;
        height: 10px;
        background-color: #007bff;
        margin: 15px 0;
        width: 98%;
        margin-left: auto;
        margin-right: auto;
        border-radius: 5px;
    }

    /* Descripción de las cards */
    .card-text {
        flex-grow: 1;
        color: #555;
        font-size: 1rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    /* Badges para actividades y exámenes */
    .card-activities,
    .card-exams {
        font-size: 0.9rem;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        text-align: center;
    }

    .card-activities {
        background-color: #007bff;
        color: white;
    }

    .card-exams {
        background-color: #28a745;
        color: white;
    }

    .no-activities-text {
        background-color: #dc3545;
        color: white;
    }

    .no-exams-text {
        background-color: #ffc107;
        color: white;
    }

    /* Cards con actividades vacías */
    .no-activities {
        border: 2px dashed #dc3545;
    }

    /* Transiciones y animaciones */
    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card-link:hover .card-dm {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.3);
        transform: scale(1.05);
    }
    /* Estilo del footer para asegurarlo */
    footer {
        position: relative;
        z-index: 10;
        padding: 20px 0;
        background: #007bff;
        color: white;
        text-align: center;
        font-size: 1rem;
    }

    footer a {
        color: #ffc107;
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.card');
        const footer = document.querySelector('footer');

        // Aseguramos que el footer no sea bloqueado
        if (footer) {
            footer.style.position = 'relative';
            footer.style.zIndex = '10';
        }

        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)'; // Desde arriba del footer
            card.style.transition = `opacity 0.7s ease, transform 0.7s ease ${index * 0.2}s`;
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });
</script>