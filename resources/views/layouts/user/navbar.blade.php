<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ __('ENGLISH_SYSTEM') }}
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent1">
            <ul class="navbar-nav me-auto">
                @if(auth()->user()->hasDirectOrRolePermission('ver-menu-panel'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('panel') ? 'active' : '' }}" href="{{ route('panel') }}">{{ __('Dashboard') }}</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('topicsu.index') ? 'active' : '' }}" href="{{ route('topicsu.index') }}">{{ __('Topics') }}</a>
                </li>
            </ul>                      
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center">
                    <button id="loadCalendarBtn" class="btn btn-primary" data-toggle="modal" data-target="#calendarModal">
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <select id="languageSwitcher" class="form-select ms-3">
                        <option value="en" {{ session('locale') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ session('locale') == 'es' ? 'selected' : '' }}>Español</option>
                    </select>
                </li>
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown d-flex align-items-center">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ Auth::user()->avatar_thumb_url ? asset(Auth::user()->avatar_thumb_url) : asset('storage/imagenes/sistema/user.png') }}" 
                                 srcset="{{ asset('storage/imagenes/sistema/user-small.png') }} 480w, 
                                         {{ asset('storage/imagenes/sistema/user.png') }} 800w" 
                                 sizes="(max-width: 600px) 480px, 800px" 
                                 alt="Imagen de perfil" width="40" class="rounded-circle" style="margin-right: 10px;">
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>



<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />

<!-- Modal -->
<div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="calendarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title" id="calendarModalLabel">Calendario</h5>
                <button type="button" class="close custom-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="calendar"></div>
            </div>
        </div>        
    </div>
</div>

<!-- Mensaje -->
<div id="tooltip-container" style="position: absolute; display: none; background: #333; color: #fff; padding: 5px; border-radius: 3px; z-index: 1000;"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#calendarModal').on('shown.bs.modal', function () {
            var calendarEl = document.getElementById('calendar');
            
            if (!calendarEl.dataset.initialized) {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es', // Configura el idioma a español
                    events: '/events', // URL para obtener los eventos
                    eventContent: function(arg) {
                        let eventTitle = document.createElement('div');
                        eventTitle.innerHTML = arg.event.title;

                        let eventTime = document.createElement('div');
                        eventTime.innerHTML = arg.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                        let arrayOfDomNodes = [ eventTitle, eventTime ];

                        return { domNodes: arrayOfDomNodes };
                    },
                    eventSources: [
                        {
                            url: '/eventsnav',
                            method: 'GET',
                            failure: function() {
                                alert('Error al cargar los eventos.');
                            }
                        }
                    ],
                    eventDidMount: function(info) {
                        $(info.el).tooltip({
                            title: info.event.extendedProps.description || 'No description available',
                            placement: 'top',
                            trigger: 'hover',
                            container: 'body'
                        });
                    }
                });
                calendar.render();
                calendarEl.dataset.initialized = true;
            }
        });
    });
</script>

<style>
    .custom-close {
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 1.2rem;
        background-color: red;
        color: white;
        border: none;
    }
    .custom-close span {
        color: white;
    }
    .custom-close:hover {
        background-color: darkred;
    }
    .modal-dialog {
        max-width:60%;
        width: auto;
    }
    .modal-content {
        height: 80vh;
    }
    .modal-body {
        width: 100%;
        height: 100%;
        padding: 0;
    }
    #calendar {
        max-width: 1000px;
        margin: 0 auto;
        height: 600px;
    }
    .fc-event {
        background-color: #007bff; /* Color de fondo */
        border: none; /* Sin borde */
        color: white; /* Color del texto */
        padding: 5px; /* Espaciado interno */
        border-radius: 4px; /* Bordes redondeados */
        font-size: 14px; /* Tamaño de la fuente */
    }
    .fc-event:hover {
        background-color: #0056b3; /* Color de fondo al pasar el ratón */
    }
    .tooltip-inner {
        background-color: #333; /* Color de fondo */
        color: #fff; /* Color del texto */
        padding: 10px; /* Espaciado interno */
        font-size: 14px; /* Tamaño de la fuente */
        border-radius: 5px; /* Bordes redondeados */
        text-align: center; /* Alineación del texto */
    }

    .tooltip.bs-tooltip-top .arrow::before {
        border-top-color: #333; /* Color de la flecha */
    }

    .tooltip.bs-tooltip-bottom .arrow::before {
        border-bottom-color: #333; /* Color de la flecha */
    }

    .tooltip.bs-tooltip-left .arrow::before {
        border-left-color: #333; /* Color de la flecha */
    }

    .tooltip.bs-tooltip-right .arrow::before {
        border-right-color: #333; /* Color de la flecha */
    }
    .language-select {
          padding: 10px;
          font-size: 16px;
          border-radius: 5px;
          border: 1px solid #ccc;
          background-color: #f9f9f9;
      }
      .nav-link.active {
        position: relative;
    }

    .nav-link.active::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        bottom: 0;
        left: 0;
        background-color: #007bff; /* Cambia el color aquí */
        visibility: visible;
        transform: scaleX(1);
        transition: all 0.3s ease-in-out 0s;
    }

    .nav-link::after {
        visibility: hidden;
        transform: scaleX(0);
    }
</style> 

