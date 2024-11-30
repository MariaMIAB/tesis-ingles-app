<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio de Sesión</title>

    <!-- Icono de Fuente -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- CSS Principal -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    @php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
    @php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
    @php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )
    
    @if (config('adminlte.use_route_url', false))
        @php( $login_url = $login_url ? route($login_url) : '' )
        @php( $register_url = $register_url ? route($register_url) : '' )
        @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
    @else
        @php( $login_url = $login_url ? url($login_url) : '' )
        @php( $register_url = $register_url ? url($register_url) : '' )
        @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
    @endif
    <div class="main">
        <!-- Formulario de Ingreso -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="imagen de registro"></figure>
                        <a href="{{ $register_url }}" class="signup-image-link">Crear cuenta</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Ingresa</h2>
                        <form action="{{ $login_url }}" method="POST" class="register-form" id="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" class="@error('password') is-invalid @enderror" placeholder="{{ __('adminlte::adminlte.password') }}" autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group icheck-primary" title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                                <input type="checkbox" name="remember" id="remember" class="agree-term" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    {{ __('adminlte::adminlte.remember_me') }}
                                </label>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" class="form-submit {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                                    <span class="fas fa-sign-in-alt"></span>
                                    {{ __('adminlte::adminlte.sign_in') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- JS -->
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
    <style>
        @font-face {
            font-family: 'Material-Design-Iconic-Font';
            src: url('fonts/material-icon/fonts/Material-Design-Iconic-Font.woff2?v=2.2.0') format('woff2');
            font-display: swap;
        }
        .form-submit {
             border-bottom: 2px solid black !important;
             padding-bottom: 12px; /* Ajusta según sea necesario */
         }
     </style>
</body>
</html>

