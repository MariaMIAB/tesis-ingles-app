@extends('layouts.user.app')

@section('content')
    <div class="py-12"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div id="main-container" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="course-container cardboard">
                    <div class="course-text">
                        <h3>{{ __('presentation') }}</h3>
                        <hr>
                        <p>{{ __('welcome_message') }}</p>
                        <h3>{{ __('course_purpose') }}</h3>
                        <hr>
                        <p>{{ __('course_purpose_message') }}</p>
                        <h3>{{ __('expectations') }}</h3>
                        <hr>
                        <p>{{ __('expectations_message') }}</p>
                        <h3>{{ __('communication') }}</h3>
                        <hr>
                        <p>{{ __('communication_message') }}</p>
                    </div>
                    <div class="course-image">
                        <img src="storage/imagenes/sistema/ingles.png" alt="{{ __('course_image_alt') }}">
                    </div>
                </div>
            </div> 
        </div> 
    </div>
@endsection

@section('css')
    <style>
        .course-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            margin: 40px; /* Agrega un margen al contenedor */
        }
        .course-text {
            flex: 1;
            padding-right: 20px;
        }
        .course-image img {
            max-width: 100%;
            height: auto;
        }
        .cardboard {
            background-color: #8cf594;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            font-weight: bold; /* Grosor en negrita */
        }
        p {
            font-weight: normal;
            font-size: 18px;
            line-height: 1.5; 
        }
        hr {
            border: none;
            height: 2px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        select {
            padding: 5px;
            font-size: 16px;
        }
        option[data-icon]::before {
            content: attr(data-icon) " ";
        }
    </style>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('languageSwitcher').addEventListener('change', function() {
                var locale = this.value;
                var url = "{{ url('lang') }}/" + locale;
                window.location.href = url;
            });
        });
    </script>
@endsection



