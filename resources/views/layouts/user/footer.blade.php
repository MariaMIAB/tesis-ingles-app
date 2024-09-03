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