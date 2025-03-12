@extends('layouts.user.app')

@section('content')
    <div class="topics-container">
        <div class="row">
            <div class="container mt-5">
                <div class="topic-header">
                    <h1 class="page-title">{{ $topic->topic_name }}</h1>
                    <div class="buttons ml-auto">
                        <form action="{{ route('topics.view', $topic->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn {{ Auth::user()->views->contains('topic_id', $topic->id) ? 'btn-info' : 'btn-secondary' }}">
                                <i class="fas fa-eye{{ Auth::user()->views->contains('topic_id', $topic->id) ? '' : '-slash' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('topics.like', $topic->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn {{ Auth::user()->likes->contains('topic_id', $topic->id) ? 'btn-primary' : 'btn-secondary' }}">
                                <i class="fas fa-thumbs-{{ Auth::user()->likes->contains('topic_id', $topic->id) ? 'up' : 'down' }}"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <hr class="custom-hr-title">
            </div>
            <p class="page-description">{{ $topic->topic_description }}</p>
            <div class="col-md-8">
                @foreach($topic->contents as $content)
                    <div class="card card-dm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title content-title">{{ $content->title }}</h5>
                                </div>
                                <div class="col-2">
                                    <audio id="audio-player-{{ $content->id }}" src="{{ url('/text-to-speech/' . $content->id) }}" type="audio/mpeg"></audio>
                                    <button onclick="toggleAudio({{ $content->id }})" id="audio-button-{{ $content->id }}" class="btn btn-primary">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                            <hr class="custom-hr-content">
                            <div class="row">
                                <div class="col-12">
                                    <p class="card-text text-justify">{!! $content->body !!}</p>
                                </div>
                                <div class="col-12 text-center">
                                    @foreach($content->image_urls as $imageUrl)
                                        <img src="{{ $imageUrl }}" class="content-image" alt="Imagen del Contenido">
                                    @endforeach
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-4 accordion" id="dynamicAccordion">

                <!-- Exámenes Relacionados -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingExams">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExams" aria-expanded="true" aria-controls="collapseExams">
                            Exámenes Relacionados
                        </button>
                    </h2>
                    <div id="collapseExams" class="accordion-collapse collapse show" aria-labelledby="headingExams" data-bs-parent="#dynamicAccordion">
                        <div class="accordion-body">
                            <div class="related-contents">
                                <div class="cards-wrapper">
                                    @forelse($topic->exams as $exam)
                                        @if ($exam->visibility)
                                            <div class="card card-dm exam-card {{ Auth::user()->examsTaken->contains('id', $exam->id) ? 'exam-completed' : '' }}" 
                                                onclick="window.location.href='{{ route('exam.show', $exam->id) }}'">
                                                <div class="card-body">
                                                    <h5 class="card-title exam-title">{{ $exam->title }}</h5>
                                                    <p class="card-text exam-description">{{ $exam->description }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <p>No hay exámenes disponibles.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Actividades Relacionadas -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingActivities">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseActivities" aria-expanded="false" aria-controls="collapseActivities">
                            Actividades Relacionadas
                        </button>
                    </h2>
                    <div id="collapseActivities" class="accordion-collapse collapse" aria-labelledby="headingActivities" data-bs-parent="#dynamicAccordion">
                        <div class="accordion-body">
                            <div class="related-contents">
                                <div class="cards-wrapper">
                                    @forelse($topic->activities as $activity)
                                        <a href="{{ route('activitiesu.show', $activity->id) }}" class="card card-dm activity-card clickable-card">
                                            <div class="card-body">
                                                <h5 class="card-title activity-title">{{ $activity->title }}</h5>
                                                <p class="card-text activity-description">{{ $activity->description }}</p>
                                            </div>
                                        </a>
                                    @empty
                                        <p>No hay actividades disponibles.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Noticias Recomendadas -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingNews">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNews" aria-expanded="false" aria-controls="collapseNews">
                            Noticias Recomendadas
                        </button>
                    </h2>
                    <div id="collapseNews" class="accordion-collapse collapse" aria-labelledby="headingNews" data-bs-parent="#dynamicAccordion">
                        <div class="accordion-body">
                            <div class="recommended-articles">
                                @foreach($recommendations as $recommendation)
                                    <a href="{{ $recommendation->url }}" target="_blank" class="card card-dm clickable-card">
                                        <div class="card-body">
                                            <h5 class="card-title exam-title">{{ $recommendation->title }}</h5>
                                            <p class="card-text">{{ $recommendation->summary }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-5">
                <a href="{{ route('topicsu.index') }}" class="btn btn-primary">Volver a los Temas</a>
            </div>
        </div>
    </div>
@endsection


<style>
  

    /* Estilos generales */
    .topics-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Estilos de la página */
    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #007bff;
        text-align: center;
        flex-grow: 1;
    }

    .page-description {
        text-align: center;
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 30px;
    }

    .custom-hr-title {
        border: none;
        height: 5px;
        background-color: #007bff;
        width: 96% !important;
        margin: 15px auto;
        border-radius: 5px;
    }

    .custom-hr-content {
        border: none;
        height: 2px;
        background: linear-gradient(to right, #007bff, #00d4ff);
        width: 100% !important;
        margin: 15px auto;
        border-radius: 5px;
    }

    /* Estilos de la tarjeta */
    .card {
        margin: 20px 40px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border-radius: 10px;
        height: auto;
        display: flex;
        flex-direction: column;
    }

    .card-dm {
        transition: transform 0.3s ease-in-out;
    }

    .card-dm:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .card-body {
        padding: 20px;
        line-height: 1.6;
    }

    .card-body > div {
        margin-bottom: 15px;
    }

    /* Estilos de la imagen */
    .content-image {
        max-width: 25%; /* Antes estaba en 100px, ajusta según necesidad */
        height: auto; /* Mantiene la proporción */
        padding: 5px;
        margin-top: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 2px solid #007bff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .content-images img {
        padding: 5px;
    }
    .content-image:hover {
        transform: scale(1.55);
    }
    
    /* Estilos del texto */
    .content-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .card-text {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 6;
        -webkit-box-orient: vertical;
    }

    .activity-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .activity-description {
        font-size: 1rem;
        color: #555;
    }

    .activity-status {
        font-size: 0.875rem;
        font-weight: 600;
        color: #fff;
        background-color: #007bff;
    }

    /* Estilos de la tarjeta clickeable */
    .clickable-card {
        display: block;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .clickable-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    /* Estilos del contenido relacionado */
    .related-contents {
        border-left: 5px solid #007bff;
        padding-left: 20px;
        border-radius: 10px 0 0 10px;
        background-color: rgba(255, 255, 255, 0); /* Usamos un color con transparencia */
        position: relative;
    }

    .related-contents .cards-wrapper {
        opacity: 1; /* Mantén la opacidad del contenido dentro de los cards */
    }


    .related-contents .card-dm {
        background-color: #f8f9fa; /* Fondo claro */
        border: 1px solid #ddd; /* Borde suave */
        border-radius: 10px; /* Bordes redondeados */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra ligera */
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        opacity: 1;  /* Los cards no tienen opacidad, están totalmente visibles */
    }

    .related-contents .card-dm:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Ajustes para diferentes dispositivos */
    @media (max-width: 768px) {
        .col-md-7, .col-md-5 {
            flex: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
    }

    /* Estilos del footer */
    .footer {
        background-color: #007bff;
        color: white;
        padding: 20px 0;
        text-align: center;
        border-top: 5px solid #0056b3; /* Separador del contenido */
    }

    .footer a {
        color: #f8f9fa;
        text-decoration: none;
        font-weight: 600;
    }

    .footer a:hover {
        text-decoration: underline;
    }

    /* Estilos del tema */
    .topic-header {
        display: flex;
        align-items: center;
    }

    .buttons {
        display: flex;
        gap: 10px;
    }

    /* Estilos de la tarjeta de examen */
    .exam-card {
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .exam-card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .exam-completed {
        background-color: #e9f7ef;
        border: 1px solid #28a745;
    }

    .exam-completed .card-title {
        color: #28a745;
    }

    /* Contraste de las tarjetas en actividades y exámenes */
    .exam-card, .activity-card {
        background-color: #ffffff;
        border: 1px solid #cccccc;
    }

    .exam-card .exam-title,
    .activity-card .activity-title {
        color: #007bff;
        font-weight: bold;
    }

    .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 12px;
    }

    .exam-card:hover, .activity-card:hover {
        background-color: #f0f8ff;
    }
    .recommended-articles {
        border-left: 5px solid #007bff;
        padding-left: 20px;
        border-radius: 10px 0 0 10px;
        background-color: rgba(255, 255, 255, 0.9);
        position: relative;
    }

    .recommended-articles .card-dm {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .recommended-articles .card-dm:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .accordion-collapse {
        transition: height 0.3s ease-in-out, opacity 0.3s ease-in-out;
    }

</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

<script>
    function toggleAudio(contentId) { 
        var audioPlayer = document.getElementById('audio-player-' + contentId); 
        var audioButton = document.getElementById('audio-button-' + contentId); 
        if (audioPlayer.paused) { 
            audioPlayer.play().then(() => {
                audioButton.innerHTML = '<i class="fas fa-stop"></i>';
            }).catch(error => {
                console.error('Error al reproducir el audio:', error);
            });
        } else { 
            audioPlayer.pause(); 
            audioPlayer.currentTime = 0; 
            audioButton.innerHTML = '<i class="fas fa-play"></i>'; 
        } 
    } 
</script>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let accordionButtons = document.querySelectorAll(".accordion-button");

        accordionButtons.forEach(button => {
            button.addEventListener("click", function () {
                let targetCollapse = document.querySelector(button.getAttribute("data-bs-target"));
                let bsCollapse = new bootstrap.Collapse(targetCollapse, { toggle: true });
            });
        });
    });
</script>