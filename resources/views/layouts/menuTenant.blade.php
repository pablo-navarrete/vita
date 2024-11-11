<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- ... Tu código existente en el <head> ... -->
    <!-- Mantén todo lo que ya tienes en tu <head> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('VITA') }} /@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css_before')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    <style>
        /* Hacer que el navbar esté fijo en la parte superior */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            /* Asegura que el menú esté por encima de otros elementos */
        }


        /* Estilos del menú horizontal existente */
        .navbar .navbar-nav {
            margin-left: 20px;
        }

        .navbar .nav-item {
            margin-left: 20px;
        }

        .navbar .nav-link:hover {
            color: rgb(21, 146, 242);
            border-radius: 4px;
        }

        .navbar .nav-link:focus,
        .navbar .nav-link:active {
            background-color: transparent !important;
        }

        .nav-link.active {
            color: rgb(21, 146, 242) !important;
        }

        /* Estilos del menú vertical */
        .sidebar {
            margin-bottom: 20px;
            /* Espacio inferior para que no toque el footer */
            position: relative;
            /* Ajuste para mantener la posición relativa */
            background-color: #2C3E50;
            border-right: 1px solid #dee2e6;
            height: auto;
            /* Ajuste para que la altura se adapte al contenido */
            z-index: 5;
            width: 250px;
            /* Ancho fijo para el menú */
        }

        .sidebar .nav-link {
            color: #ffffff;
            padding: 10px 20px;
        }

        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            color: rgb(21, 146, 242);
        }

        .sidebar .nav-link.active {
            color: rgb(21, 146, 242);
            font-weight: bold;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 56px;
                /* Altura de la navbar */
                left: -250px;
                width: 250px;
                height: calc(100% - 56px);
                /* Altura total menos la altura del navbar */
                overflow-y: auto;
                transition: left 0.3s ease;
                z-index: 1050;
            }

            .sidebar.show {
                left: 0;
            }

            .content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }
        }

        @media (min-width: 768px) {
            .sidebar {
                position: fixed;
                top: 56px;
                /* Altura de la navbar */
                left: 0;
                width: 250px;
                height: calc(100vh - 56px);
                /* Altura total menos la altura del navbar */
                overflow-y: auto;
            }

            .content {
                margin-left: 250px;
            }

            .menu-toggle {
                display: none;
            }
        }

        /* Estilos del footer */
        .footer {
            padding: 20px 0;
            background-color: #2F3640;
            border-top: 1px solid #0a3c6e;
            width: 100%;
            margin-top: auto;
            /* Mantiene el footer al final del contenido */
            position: relative;
            /* Asegúrate de que el footer tenga una posición relativa */
            z-index: 10;
            /* Mayor que el sidebar si está posicionado */
        }

        .footer .text-muted {
            color: #f3efef !important;
        }

        .footer span {
            color: rgb(21, 146, 242);
            font-weight: bold;
        }

        /* Flexbox para hacer que el contenido siempre ocupe el espacio restante */


        .title-sidebar {
            color: #b8b8b8;
        }

        /* Ajustar el margen del logo */
        .navbar-brand {
            margin-left: 20px;
            /* Cambia 10px al valor que desees */
            margin-right: 10px;
            /* Cambia 10px al valor que desees */
        }

        .menu-perfil {
            margin-left: 10px;
            /* Cambia 10px al valor que desees */
            margin-right: 20px;
            /* Cambia 10px al valor que desees */
        }

        /* Selecciona la barra de desplazamiento completa */
        ::-webkit-scrollbar {
            width: 10px;
            /* Ancho de la barra de desplazamiento */
            height: 10px;
            /* Alto de la barra de desplazamiento para scroll horizontal */
        }

        /* Estilo de la "pista" del scroll */
        ::-webkit-scrollbar-track {
            background: #3b436c;
            /* Color de fondo de la pista */
            border-radius: 10px;
            /* Bordes redondeados */
        }

        /* Estilo de la barra de desplazamiento (thumb) */
        ::-webkit-scrollbar-thumb {
            background: #49518c;
            /* Color de la barra de desplazamiento */
            border-radius: 10px;
            /* Bordes redondeados de la barra */
        }

        /* Cambia el color al pasar el mouse por encima */
        ::-webkit-scrollbar-thumb:hover {
            background: #36629f;
            /* Color de la barra al hacer hover */
        }

        .card .card-header {
            background-color: rgb(192, 233, 250);
        }

        .card .card-body {
            background-color: #f2f7fd;
        }
        .modal-header{
            background-color: rgb(192, 233, 250);
        }
        .modal-body{
            background-color: #f2f7fd;
        }
        .modal-footer{
            background-color: #f2f7fd;
        }
    </style>

</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app">
        <!-- Menú horizontal existente -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <!-- ... Tu código existente del navbar ... -->
            <div class="container-fluid">
                <a class="navbar-brand" href="/" style="color: rgb(21, 146, 242);">
                    @if ($logo)
                        <img src="{{ asset($logo->image_url) }}" alt="" style="width: 30px; height:30px;">
                    @endif
                    Clinica Alemana
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">

                        <!-- ... Añade más elementos según necesites ... -->

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto menu-perfil">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tenant.web.inicio') }}" target="_blank"><i
                                    class="fas fa-globe"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownNotification" class="nav-link " href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-bell"></i>
                                <span class="badge " style="background-color:red;">0</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end text-center"
                                aria-labelledby="navbarDropdownNotification">
                                <p class="m-3">no hay notificaciones</p>
                            </div>
                        </li>
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tenant.login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Perfil</a>
                                    <a class="dropdown-item" href="{{ route('tenant.logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('tenant.logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="mt-5">
            <div class="mt-5">
                <br>
                <!-- Botón para mostrar/ocultar el menú vertical en móviles -->
                <button class="btn btn-outline-primary menu-toggle d-md-none" type="button" onclick="toggleSidebar()"
                    style="margin: 10px;">
                    <i class="fas fa-bars"></i> Menú
                </button>
            </div>


            <div class="container-fluid flex-grow-1">
                <div class="row">
                    <!-- Menú vertical -->
                    <nav id="sidebar" class="col-md-2 d-md-block sidebar">
                        <div class="">
                            <ul class="nav flex-column">
                                <br>
                                <h6 class="m-2 title-sidebar">Inicio</h6>
                                <li class="nav-item">
                                    <a class="nav-link{{ request()->is('dashboard') ? ' active' : '' }}"
                                        href="{{ route('tenant.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Panel de control
                                    </a>
                                </li>

                                <h6 class="m-2 title-sidebar">Pacientes</h6>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('listado-pacientes') ? ' active' : '' }}"
                                        href="{{ route('tenant.paciente.index') }}">
                                        <i class="fa-solid fa-list"></i>Listado de Pacientes
                                    </a>
                                    <a class="nav-link {{ request()->is('paciente/create') ? ' active' : '' }}"
                                        href="{{ route('tenant.paciente.create') }}">
                                        <i class="fas fa-user-plus"></i>Crear Paciente
                                    </a>

                                </li>

                                <h6 class="m-2 title-sidebar">Citas</h6>
                                <li class="nav-item">
                                    <a class="nav-link{{ request()->is('listado-citas') ? ' active' : '' }}" href="{{ route('tenant.cita.list') }}">
                                        <i class="fas fa-list"></i>Listado de Citas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('citas') ? ' active' : '' }}" href="{{ route("tenant.cita.index") }}">
                                        <i class="fas fa-calendar-alt"></i>Calendario de Citas
                                    </a>
                                </li>
                             

                                <h6 class="m-2 title-sidebar">Pre-Consultas Médicas</h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-list"></i>Listado Pre-Consultas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-stethoscope"></i>Crear Pre-Consulta
                                    </a>
                                </li>

                                <h6 class="m-2 title-sidebar">Consultas Médicas</h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-list"></i>Listado de Consultas
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-stethoscope"></i>Crear Consulta
                                    </a>
                                </li>

                                <h6 class="m-2 title-sidebar">Hospitalización</h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-procedures"></i> Gestión de Hospitalización
                                    </a>
                                </li>

                                <h6 class="m-2 title-sidebar">Laboratorios y Exámenes</h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-vial"></i> Solicitud de Exámenes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-flask"></i> Resultados de Laboratorio
                                    </a>
                                </li>

                                <h6 class="m-2 title-sidebar">Facturación</h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-file-invoice-dollar"></i> Facturación
                                    </a>
                                </li>

                                <h6 class="m-2 title-sidebar">Personal Médico</h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-user-md"></i> Gestión de Personal
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-calendar-alt"></i> Horarios y Turnos
                                    </a>
                                </li>

                                <h6 class="m-2 title-sidebar">Web</h6>
                                <li class="nav-item">
                                    <a class="nav-link{{ request()->is('logo') ? ' active' : '' }}"
                                        href="{{ route('tenant.logo.index') }}">
                                        <i class="fas fa-clinic-medical"></i> Logo
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-bars"></i> Menu
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-envelope"></i> Contacto
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link{{ request()->is('banner') ? ' active' : '' }}" href="{{ route('tenant.banner.index') }}">
                                        <i class="fas fa-image"></i> Banner
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-shoe-prints"></i> Footer
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-project-diagram"></i> Redes Sociales
                                    </a>
                                </li>
                                <h6 class="m-2 title-sidebar">Soporte y Recursos</h6>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-headset"></i> Ayuda
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fa-solid fa-comment-medical"></i> Comentario
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-envelope"></i> Contactar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        <i class="fas fa-book-open"></i> Guia
                                    </a>
                                </li>
                            </ul>

                        </div>
                        <br>
                        <br>
                        <br>
                        <br>
                    </nav>

                    <!-- Contenido principal -->
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                        <div class="pt-3">
                            @yield('content')
                        </div>
                    </main>
                </div>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container ">
            <span class="text-muted">&copy; {{ date('Y') }} <span>{{ __('VITA') }}</span>. Todos los derechos
                reservados.</span>
        </div>
    </footer>
    <!-- Scripts -->
    @yield('js_after')
    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');

            if (sidebar.classList.contains('show')) {
                // Si el menú está abierto, agrega un evento de clic al documento para cerrarlo si se hace clic fuera
                document.addEventListener('click', closeSidebarOnClickOutside);
            } else {
                // Si el menú se cierra, eliminamos el event listener
                document.removeEventListener('click', closeSidebarOnClickOutside);
            }
        }

        function closeSidebarOnClickOutside(event) {
            var sidebar = document.getElementById('sidebar');
            var toggleButton = document.querySelector('.menu-toggle');

            // Si el clic ocurre fuera del menú y del botón de toggle
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                sidebar.classList.remove('show'); // Cierra el menú
                document.removeEventListener('click', closeSidebarOnClickOutside); // Eliminamos el event listener
            }
        }
    </script>

</body>

</html>
