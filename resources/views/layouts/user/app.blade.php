<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>STM-OVAs</title>

    @yield('css')
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('js')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        @keyframes hero-gradient-animation {
            0% {
                --y-0: 80%;
                --c-0: hsla(180, 80%, 58%, 1);
                --s-start-0: 9%;
                --s-end-0: 55%;
                --x-0: 85%;
                --y-1: 24%;
                --x-1: 60%;
                --s-start-1: 5%;
                --s-end-1: 72%;
                --c-1: hsla(201, 84%, 67%, 1);
                --y-2: 82%;
                --c-2: hsla(186, 88%, 46%, 1);
                --s-start-2: 5%;
                --s-end-2: 52%;
                --x-2: 13%;
                --s-start-3: 13%;
                --s-end-3: 68%;
                --c-3: hsla(194, 89%, 45%, 1);
                --y-3: 7%;
                --x-3: 24%;
            }
            25% {
                --y-0: 85%;
                --c-0: hsla(185, 78%, 60%, 1);
                --s-start-0: 12%;
                --s-end-0: 50%;
                --x-0: 75%;
                --y-1: 30%;
                --x-1: 50%;
                --s-start-1: 7%;
                --s-end-1: 70%;
                --c-1: hsla(198, 82%, 65%, 1);
                --y-2: 75%;
                --c-2: hsla(180, 85%, 50%, 1);
                --s-start-2: 8%;
                --s-end-2: 55%;
                --x-2: 20%;
                --s-start-3: 15%;
                --s-end-3: 65%;
                --c-3: hsla(190, 87%, 48%, 1);
                --y-3: 12%;
                --x-3: 30%;
            }
            50% {
                --y-0: 90%;
                --c-0: hsla(188, 76%, 62%, 1);
                --s-start-0: 10%;
                --s-end-0: 57%;
                --x-0: 65%;
                --y-1: 35%;
                --x-1: 40%;
                --s-start-1: 6%;
                --s-end-1: 75%;
                --c-1: hsla(192, 80%, 63%, 1);
                --y-2: 68%;
                --c-2: hsla(176, 83%, 47%, 1);
                --s-start-2: 6%;
                --s-end-2: 50%;
                --x-2: 30%;
                --s-start-3: 10%;
                --s-end-3: 70%;
                --c-3: hsla(185, 85%, 46%, 1);
                --y-3: 20%;
                --x-3: 40%;
            }
            75% {
                --y-0: 92%;
                --c-0: hsla(190, 74%, 55%, 1);
                --s-start-0: 11%;
                --s-end-0: 53%;
                --x-0: 50%;
                --y-1: 40%;
                --x-1: 30%;
                --s-start-1: 4%;
                --s-end-1: 78%;
                --c-1: hsla(194, 77%, 68%, 1);
                --y-2: 62%;
                --c-2: hsla(182, 84%, 48%, 1);
                --s-start-2: 7%;
                --s-end-2: 52%;
                --x-2: 40%;
                --s-start-3: 12%;
                --s-end-3: 66%;
                --c-3: hsla(187, 82%, 50%, 1);
                --y-3: 28%;
                --x-3: 60%;
            }
            100% {
                --y-0: 94%;
                --c-0: hsla(190, 74%, 54%, 1);
                --s-start-0: 9%;
                --s-end-0: 55%;
                --x-0: 31%;
                --y-1: 25%;
                --x-1: 2%;
                --s-start-1: 5%;
                --s-end-1: 72%;
                --c-1: hsla(187, 92%, 77%, 1);
                --y-2: 20%;
                --c-2: hsla(197, 78%, 56%, 1);
                --s-start-2: 5%;
                --s-end-2: 52%;
                --x-2: 98%;
                --s-start-3: 13%;
                --s-end-3: 68%;
                --c-3: hsla(182, 60%, 62%, 1);
                --y-3: 92%;
                --x-3: 95%;
            }
        }
        @property --y-0 {
            syntax: '<percentage>';
            inherits: false;
            initial-value: 80%;
        }
        body {
            margin: 0;
            font-family: 'Nunito', sans-serif;
            min-height: 100vh;
            background-color: hsla(358, 0%, 100%, 1);
            background-image: radial-gradient(circle at var(--x-0) var(--y-0), var(--c-0) var(--s-start-0), transparent var(--s-end-0)), 
                              radial-gradient(circle at var(--x-1) var(--y-1), var(--c-1) var(--s-start-1), transparent var(--s-end-1)), 
                              radial-gradient(circle at var(--x-2) var(--y-2), var(--c-2) var(--s-start-2), transparent var(--s-end-2)), 
                              radial-gradient(circle at var(--x-3) var(--y-3), var(--c-3) var(--s-start-3), transparent var(--s-end-3));
            animation: hero-gradient-animation 10s linear infinite alternate-reverse;
            background-blend-mode: normal, normal, normal, normal;
        }
    </style>
</head>
<body>
    <div id="app">
        @include('layouts.user.navbar')
            <main class="py-4">
                @yield('content')
            </main>
        @include('layouts.user.footer')
    </div>
</body>
</html>
