@extends('layouts.user.app')

@section('content')
    <div class="dynamic-container">
        <div class="contenedor-titulo">
            <h1 class="titulo">APRENDAMOS INGLES JUNTOS</h1>
        </div>
        <div class="dynamic-content" id="dynamic-content">
            <div class="dynamic-text hidden" id="dynamic-text">
                <h3><i class="fas fa-handshake"></i> {{ __('presentation') }}</h3>
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
    <style>
        .contenedor-titulo {
            display: flex;
            justify-content: center; /* Centra el contenido horizontalmente */
            align-items: center; /* Centra el contenido verticalmente */
            padding: 20px;
            height: calc(20vh - 60px);
            background-color: #1abc9c; /* Fondo oscuro para resaltar el texto */
            margin-top: 10px; /* Espacio de 30px en la parte superior */
            margin-left: 100px; /* Espacio de 40px a la izquierda */
            margin-right: 100px; /* Espacio de 40px a la derecha */
            margin-bottom: 10px; /* Espacio de 20px en la parte inferior */
            width: 88%; /* Asegura que el título ocupe todo el ancho disponible */
            border-radius: 20px;
            position: relative;
        }

        .titulo {
            color: white;
            font-weight: bold;
            display: inline-block;
            padding-bottom: 10px;
            font-size: 2rem;
            text-align: center; /* Asegura que el texto esté centrado */
            border-bottom: 4px solid transparent; /* Inicialmente transparente */
            width: auto; /* Permite que el título se ajuste al contenido */
            max-width: 100%; /* Evita que el título se salga de su contenedor */
            opacity: 0; /* Comienza invisible */
            transform: translateY(-30px); /* Comienza desplazado hacia arriba */
            animation: animarCaida 2s ease-out forwards, animarSubrayado 0.5s 2s forwards; /* Caída primero, luego subrayado */
            position: relative; /* Necesario para la correcta posición del subrayado */
        }

        /* Animación de caída de las palabras del título */
        @keyframes animarCaida {
            0% {
                opacity: 0;
                transform: translateY(-30px); /* Empieza fuera de la pantalla hacia arriba */
            }
            100% {
                opacity: 1;
                transform: translateY(0); /* Termina en su posición original */
            }
        }

        /* Animación de subrayado */
        @keyframes animarSubrayado {
            0% {
                opacity: 0;
                border-bottom-color: transparent;
                width: 0; /* Empieza sin subrayado */
            }
            25% {
                opacity: 0.2;
                border-bottom-color: transparent;
                width: 20%; /* Aparece lentamente el subrayado */
            }
            50% {
                opacity: 0.4;
                border-bottom-color: transparent;
                width: 40%; /* Aumenta gradualmente */
            }
            75% {
                opacity: 0.6;
                border-bottom-color: transparent;
                width: 60%; /* Continúa aumentando */
            }
            100% {
                opacity: 1; /* Llega al 100% de opacidad */
                border-bottom-color: white; /* El subrayado se vuelve blanco */
                width: 100%; /* El subrayado ocupa el 100% del ancho del título */
            }
        }

        .dynamic-container {
            display: flex;
            flex-direction: column; /* Apila los elementos en una columna */
            justify-content: center; /* Centra el contenido verticalmente */
            align-items: center; /* Centra el contenido horizontalmente */
            height: calc(90vh - 60px);
            background: linear-gradient(to right, #f0f4f8, #c3dfe6);
            padding: 20px;
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
            margin: 20px 0; /* Separación con el contenedor de título */
        }

        .dynamic-text {
            flex: 1;
            max-width: 50%; /* Asegurar que el texto no exceda la mitad del ancho */
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

        .dynamic-text h3 {
            font-weight: bold;
            font-size: 28px;
            color: #1abc9c;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dynamic-text p {
            font-size: 18px;
            line-height: 1.5;
            color: #34495e;
        }

        hr {
            border: none;
            height: 2px;
            background-color: #16a085;
            margin: 10px 0;
        }

        .dynamic-image-container {
            flex: 1.5;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            max-width: 50%; /* Limitar el ancho de la imagen */
        }

        .dynamic-image {
            width: 100%;
            height: auto;
            border: 5px solid #16a085; /* Borde agregado */
            border-radius: 15px; /* Bordes redondeados */
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
                max-width: 100%; /* Permitir que el texto use todo el ancho */
            }

            .dynamic-image-container {
                max-width: 100%; /* Ajustar la imagen al ancho completo en pantallas pequeñas */
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
                `<h3><i class="fas fa-handshake"></i> {{ __('presentation') }}</h3><hr><p>{{ __('welcome_message') }}</p>`,
                `<h3><i class="fas fa-graduation-cap"></i> {{ __('course_purpose') }}</h3><hr><p>{{ __('course_purpose_message') }}</p>`,
                `<h3><i class="fas fa-bullseye"></i> {{ __('expectations') }}</h3><hr><p>{{ __('expectations_message') }}</p>`
            ];

            let currentIndex = 0;
            const dynamicImage = document.getElementById('dynamic-image');
            const dynamicText = document.getElementById('dynamic-text');

            function showNextContent() {
                dynamicImage.classList.replace('visible', 'hidden');
                dynamicText.classList.remove('visible');

                setTimeout(() => {
                    dynamicImage.src = images[currentIndex];
                    dynamicText.innerHTML = texts[currentIndex];

                    dynamicText.style.transform = 'scale(0.8)';

                    dynamicImage.classList.add('visible');
                    dynamicText.classList.add('visible');

                    setTimeout(() => {
                        dynamicText.style.transform = 'scale(1)';
                    }, 500);

                    currentIndex = (currentIndex + 1) % images.length;
                }, 1000);
            }


            // Inicializa la primera imagen y texto
            dynamicImage.src = images[currentIndex];
            dynamicText.innerHTML = texts[currentIndex];
            dynamicImage.classList.add('visible');
            dynamicText.classList.add('visible');

            // Cambia el contenido cada 7 segundos
            setInterval(showNextContent, 7000);

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














