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
                            <!-- Verificación de si el usuario ya ha visto el tema -->
                            <button type="submit" class="btn {{ Auth::user()->views->contains('topic_id', $topic->id) ? 'btn-info' : 'btn-secondary' }}">
                                <i class="fas fa-eye{{ Auth::user()->views->contains('topic_id', $topic->id) ? '' : '-slash' }}"></i>
                            </button>
                        </form>
                        <form action="{{ route('topics.like', $topic->id) }}" method="POST">
                            @csrf
                            <!-- Verificación de si el usuario ha dado like al tema -->
                            <button type="submit" class="btn {{ Auth::user()->likes->contains('topic_id', $topic->id) ? 'btn-primary' : 'btn-secondary' }}">
                                <i class="fas fa-thumbs-{{ Auth::user()->likes->contains('topic_id', $topic->id) ? 'up' : 'down' }}"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <hr class="custom-hr-title">
            </div>
            <p class="page-description">{{ $topic->topic_description }}</p>
            <div class="col-md-7">
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
                                <div class="col-8">
                                    <p class="card-text">{!! $content->body !!}</p>
                                </div>
                                <div class="col-4 content-images">
                                    @if ($content->hasMedia('content_images'))
                                        @foreach($content->getMedia('content_images') as $image)
                                            <img src="{{ $content->first_content_image_url }}" class="content-image" alt="Imagen del Contenido">
                                        @endforeach
                                    @else
                                        <img src="{{ asset('/storage/imagenes/sistema/alt-de-una-imagen.png') }}" class="content-image" alt="Imagen por defecto">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-5">
                <!-- Exámenes Relacionados -->
                <h4 class="section-title">Exámenes Relacionados</h4>
                <div class="related-contents">
                    @forelse($topic->exams as $exam)
                        <div class="card card-dm exam-card {{ Auth::user()->examsTaken->contains('id', $exam->id) ? 'exam-completed' : '' }}" 
                            onclick="window.location.href='{{ route('exam.show', $exam->id) }}'">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10">
                                        <h5 class="card-title exam-title">{{ $exam->title }}</h5>
                                        <p class="card-text exam-description">{{ $exam->description }}</p>
                                    </div>
                                    <div class="col-2 text-right">
                                        <span class="badge badge-{{ Auth::user()->examsTaken->contains('id', $exam->id) ? 'success' : 'warning' }} exam-status">
                                            <i class="fas fa-{{ Auth::user()->examsTaken->contains('id', $exam->id) ? 'check-circle' : 'hourglass-half' }}"></i> 
                                            {{ Auth::user()->examsTaken->contains('id', $exam->id) ? 'Realizado' : 'Pendiente' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card card-dm">
                            <div class="card-body">
                                <p>No hay exámenes relacionados.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            
                <hr class="custom-hr">
            
                <!-- Actividades Relacionadas -->
                <h4 class="section-title">Actividades Relacionadas</h4>
                <div class="related-contents">
                    @forelse($topic->activities as $activity)
                        <!-- Hacemos que toda la tarjeta sea clickeable -->
                        <a href="{{ route('activitiesu.show', $activity->id) }}" class="card card-dm activity-card clickable-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-10">
                                        <h5 class="card-title activity-title">{{ $activity->title }}</h5>
                                        <p class="card-text activity-description">{{ $activity->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="card card-dm">
                            <div class="card-body">
                                <p>No hay actividades relacionadas.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            
            
        </div>
        
        <!-- Botón atrás -->
        <div class="col-md-12 text-center mt-5">
            <a href="{{ route('topicsu.index') }}" class="btn btn-secondary">Atrás</a>
        </div>
    </div>
@endsection

<style>

    /* Hacer que la tarjeta sea clickeable */
    .clickable-card {
        display: block;  /* Aseguramos que el enlace ocupe todo el espacio de la tarjeta */
        cursor: pointer; /* Cambiar el cursor al pasar sobre la tarjeta */
        text-decoration: none; /* Quitar el subrayado por defecto de los enlaces */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Añadir transiciones suaves */
    }

    /* Efecto de hover para la tarjeta */
    .clickable-card:hover {
        transform: translateY(-5px); /* Mover ligeramente la tarjeta hacia arriba */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra para indicar interactividad */
    }

    /* Estilo para el título y la descripción */
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

    /* Ajuste para la columna de la derecha con el badge */
    .activity-status {
        font-size: 0.875rem;
        font-weight: 600;
        color: #fff;
        background-color: #007bff;
    }


    .topics-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px;
    }

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

    .card {
        margin: 20px 40px; /* Aumentado para separar las tarjetas de los costados */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border-radius: 10px;
        height: auto;
        display: flex;
        flex-direction: column;
    }

    .card-dm:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .card-body {
        padding: 20px;
        line-height: 1.6;
    }

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

    .related-contents {
        border-left: 5px solid #007bff;
        padding-left: 20px;
        border-radius: 10px 0 0 10px;
        background-color: #f8f9fa;
    }

    .content-images img {
        padding: 5px;
    }

    .card-body > div {
        margin-bottom: 15px;
    }

    .content-image {
        max-width: 200px;
        padding: 5px;
        margin-top: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 2px solid #007bff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .col-md-7, .col-md-5 {
            flex: 100%;
            max-width: 100%;
            margin-bottom: 20px;
        }
    }

    .card-dm {
        transition: transform 0.3s ease-in-out;
    }

    .topic-header {
        display: flex;
        align-items: center;
    }

    .buttons {
        display: flex;
        gap: 10px;
    }
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

    .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 12px;
    }
</style>


<!-- Include Bootstrap and SweetAlert scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert integration -->
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




