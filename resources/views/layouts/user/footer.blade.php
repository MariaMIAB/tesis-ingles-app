<footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        Version: {{ config('app.version', '1.0.0') }}
    </div>
    <strong>
        <a href="{{ config('app.company_url', '#') }}">
            {{ config('app.company_name', 'UJMS-Oliverio Pellicelli') }}
        </a>
    </strong> &copy; {{ date('Y') }}. All rights reserved.
</footer>

<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        min-height: 100vh; /* Asegura que el contenido ocupe al menos la altura completa de la ventana */
        display: flex;
        flex-direction: column;
    }

    .main-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 20px;
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .main-footer .float-right {
        margin-right: 15px;
    }

    .main-footer strong {
        margin-left: 15px;
    }
</style>
