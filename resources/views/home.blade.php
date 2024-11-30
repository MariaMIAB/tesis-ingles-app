@extends('layouts.user.app')

@section('content')
    <div class="dynamic-container">
        <div class="dynamic-content">
            <div class="dynamic-text" id="dynamic-text">
                <h3>{{ __('presentation') }}</h3>
                <hr>
                <p>{{ __('welcome_message') }}</p>
            </div>
            <div class="dynamic-image-container">
                <img src="storage/imagenes/sistema/image-home.webp" alt="Imagen 1" class="dynamic-image" id="dynamic-image">
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
    .dynamic-container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        height: calc(100vh - 60px);
        margin-top: 30px;
    }

    .dynamic-content {
        display: flex;
        justify-content: space-between;
        width: 100%;
        max-width: 1600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 20px;
        overflow: hidden;
        background-color: white;
        padding: 20px;
    }

    .dynamic-image-container {
        flex: 1.5; /* Aumentar tamaño de la imagen */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dynamic-image {
        width: 100%;
        height: auto;
        border-radius: 20px;
        transition: opacity 2s ease-in-out;
    }

    .dynamic-text {
        flex: 1;
        text-align: left;
        padding: 20px; /* Añadir padding alrededor del texto */
        transition: opacity 2s ease-in-out;
    }

    .dynamic-text h3 {
        font-weight: bold;
        font-size: 28px; /* Tamaño de letra más grande para h3 */
        margin-bottom: 10px; /* Espacio debajo de h3 */
        color: #2c3e50; /* Color del texto */
    }

    .dynamic-text p {
        font-size: 18px;
        line-height: 1.5;
        color: #34495e; /* Color del texto */
    }

    hr {
        border: none;
        height: 2px;
        background-color: #3498db; /* Color del hr */
        margin: 10px 0; /* Espacio arriba y abajo del hr */
    }

    .hidden {
        opacity: 0;
    }

    .visible {
        opacity: 1;
    }
    </style>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const images = [
                'storage/imagenes/sistema/image-home.webp',
                'storage/imagenes/sistema/image-home-2.webp',
                'storage/imagenes/sistema/image-home-3.webp'
            ];

            const texts = [
                `<h3>{{ __('presentation') }}</h3><hr><p>{{ __('welcome_message') }}</p>`,
                `<h3>{{ __('course_purpose') }}</h3><hr><p>{{ __('course_purpose_message') }}</p>`,
                `<h3>{{ __('expectations') }}</h3><hr><p>{{ __('expectations_message') }}</p><h3>{{ __('communication') }}</h3><hr><p>{{ __('communication_message') }}</p>`
            ];

            let currentIndex = 0;
            const dynamicImage = document.getElementById('dynamic-image');
            const dynamicText = document.getElementById('dynamic-text');

            function showNextContent() {
                dynamicImage.classList.replace('visible', 'hidden');
                dynamicText.classList.replace('visible', 'hidden');
                currentIndex = (currentIndex + 1) % images.length;

                setTimeout(() => {
                    dynamicImage.src = images[currentIndex];
                    dynamicText.innerHTML = texts[currentIndex];
                    dynamicImage.classList.replace('hidden', 'visible');
                    dynamicText.classList.replace('hidden', 'visible');
                }, 1000); // Transición rápida para superposición
            }

            // Inicializamos la primera imagen y texto
            dynamicImage.src = images[currentIndex];
            dynamicText.innerHTML = texts[currentIndex];
            dynamicImage.classList.add('visible');
            dynamicText.classList.add('visible');

            // Cambia el contenido cada 7 segundos
            setInterval(showNextContent, 7000);

            // Animación de carga suave
            const courseContainer = document.querySelector('.course-container');
            if (courseContainer) {
                courseContainer.style.opacity = 0;
                setTimeout(function() {
                    courseContainer.style.transition = 'opacity 1.5s';
                    courseContainer.style.opacity = 1;
                }, 200);
            }

            // Cambio de idioma
            const languageSwitcher = document.getElementById('languageSwitcher');
            if (languageSwitcher) {
                languageSwitcher.addEventListener('change', function() {
                    var locale = this.value;
                    var url = "{{ url('lang') }}/" + locale;
                    document.body.style.transition = 'opacity 0.5s';
                    document.body.style.opacity = 0;
                    setTimeout(function() {
                        window.location.href = url;
                    }, 500);
                });
            }
        });
    </script>
@endsection













