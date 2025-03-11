@extends('layouts.user.app')

@section('content')
    <div class="dynamic-container">
        <div class="contenedor-titulo">
            <h1 class="titulo animate__animated animate__heartBeat">🌎 APRENDAMOS INGLÉS JUNTOS</h1>
        </div>
        <div class="dynamic-content" id="dynamic-content">
            <div class="dynamic-text hidden" id="dynamic-text">
                <h3><i class="fas fa-handshake text-icon handshake"></i> {{ __('presentation') }}</h3>
                <hr>
                <p>{{ __('welcome_message') }}</p>
            </div>
            <div class="dynamic-image-container" id="dynamic-image-container">
                <img src="storage/imagenes/sistema/image-home.webp" alt="Imagen 1" class="dynamic-image visible" id="dynamic-image">
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .contenedor-titulo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            height: calc(20vh - 60px);
            background-color: #1abc9c;
            margin: 10px 100px;
            width: 88%;
            border-radius: 20px;
            position: relative;
        }

        .titulo {
            color: white;
            font-weight: bold;
            font-size: 2rem;
            text-align: center;
        }

        .dynamic-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: calc(90vh - 60px);
            background: linear-gradient(to right, #f0f4f8, #c3dfe6);
            padding: 20px;
            background: transparent !important;
        }

        .dynamic-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1800px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            border-radius: 20px;
            overflow: hidden;
            background-color: white;
            padding: 20px;
            position: relative;
            margin: 20px 0;
            opacity: 1;
        }

        .dynamic-text {
            flex: 1;
            max-width: 50%;
            text-align: left;
            padding: 20px;
            color: #2c3e50;
            opacity: 0;
            transform: translateX(-50%);
            transition: transform 1s ease, opacity 1s ease;
        }

        .dynamic-text.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .dynamic-image-container {
            flex: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            max-width: 50%;
        }

        .dynamic-image {
            width: 90%;
            height: auto;
            border: 5px solid #16a085;
            border-radius: 15px;
            transition: transform 1s ease-in-out, opacity 1s ease-in-out;
        }

        .dynamic-image.hidden {
            transform: translateX(-100%);
            opacity: 0;
        }

        .dynamic-image.visible {
            transform: translateX(0);
            opacity: 1;
        }

        .text-icon {
            font-size: 3rem;
            margin-right: 10px;
        }

        .text-icon.handshake {
            color: #1abc9c;
        }

        .text-icon.graduation {
            color: #3498db;
        }

        .text-icon.target {
            color: #e74c3c;
        }

        .dynamic-text p {
            color: #34495e;
            font-size: 1.5rem;
        }

        @media screen and (max-width: 768px) {
            .dynamic-content {
                flex-direction: column;
                padding: 10px;
            }

            .dynamic-image-container, .dynamic-text {
                width: 100%;
                flex: none;
            }

            .dynamic-text {
                text-align: center;
                max-width: 100%;
            }

            .dynamic-image-container {
                max-width: 100%;
            }
        }
    </style>
@endsection

@section('js')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const images = [
                'storage/imagenes/sistema/image-home.webp',
                'storage/imagenes/sistema/image-home-2.webp',
                'storage/imagenes/sistema/image-home-3.webp'
            ];

            const texts = [
                `<h3><i class="fas fa-handshake text-icon handshake"></i> {{ __('presentation') }}</h3><hr><p>{{ __('welcome_message') }}</p>`,
                `<h3><i class="fas fa-graduation-cap text-icon graduation"></i> {{ __('course_purpose') }}</h3><hr><p>{{ __('course_purpose_message') }}</p>`,
                `<h3><i class="fas fa-bullseye text-icon target"></i> {{ __('expectations') }}</h3><hr><p>{{ __('expectations_message') }}</p>`
            ];

            let currentIndex = 0;
            const dynamicImage = document.getElementById('dynamic-image');
            const dynamicText = document.getElementById('dynamic-text');

            function showNextContent() {
                dynamicImage.classList.replace('visible', 'hidden');
                dynamicText.classList.remove('visible');

                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % images.length;
                    dynamicImage.src = images[currentIndex];
                    dynamicText.innerHTML = texts[currentIndex];

                    dynamicImage.classList.replace('hidden', 'visible');
                    dynamicText.classList.add('visible');
                }, 1000);
            }

            // Inicializa la primera imagen y texto
            dynamicImage.src = images[currentIndex];
            dynamicText.innerHTML = texts[currentIndex];
            dynamicImage.classList.add('visible');
            dynamicText.classList.add('visible');

            // Cambia el contenido cada 7 segundos
            setInterval(showNextContent, 7000);

            // Repetir la animación del título
            const title = document.querySelector('.titulo');

            function repeatAnimation() {
                title.classList.remove('animate__heartBeat');
                void title.offsetWidth; // Forzar reflujo
                title.classList.add('animate__heartBeat');
            }

            setInterval(repeatAnimation, 5000);
        });
    </script>
@endsection










