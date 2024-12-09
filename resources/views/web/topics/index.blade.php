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
    .topics-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 30px;
        text-align: center;
    }

    .card {
        margin: 20px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border-radius: 10px;
        height: 350px;
        display: flex;
        flex-direction: column;
        background-color: #f0f8ff;
        position: relative;
        overflow: hidden;
    }

    .card-dm:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }

    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .topic-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .custom-hr {
        border: 0;
        height: 2px;
        background: linear-gradient(to right, #007bff, #00d4ff);
        margin: 15px 0;
    }

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

    .card-text {
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    .card-activities,
    .card-exams {
        font-size: 0.9rem;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        text-align: center;
        display: inline-block;
        max-width: 50%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-activities {
        background-color: #007bff;
        color: white;
    }

    .card-exams {
        background-color: #ff0077;
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

    .card-exams .badge {
        font-size: 0.8rem;
    }

    .no-activities {
        border: 2px solid red;
    }

    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card-link:hover .card-dm {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        transform: scale(1.05);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `opacity 0.5s ease, transform 0.5s ease ${index * 0.1}s`;
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>


