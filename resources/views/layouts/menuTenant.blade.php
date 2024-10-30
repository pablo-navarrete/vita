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
            z-index: 1030; /* Asegura que el menú esté por encima de otros elementos */
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
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            height: calc(100vh - 56px); /* Altura total menos la altura del navbar */
        }
        .sidebar .nav-link {
            color: #333;
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
                top: 56px; /* Altura de la navbar */
                left: -250px;
                width: 250px;
                height: calc(100% - 56px); /* Altura total menos la altura del navbar */
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
                top: 56px; /* Altura de la navbar */
                left: 0;
                width: 250px;
                height: calc(100vh - 56px); /* Altura total menos la altura del navbar */
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
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            width: 100%;
            position: relative;
            z-index: 9999; /* Asegura que esté por encima de otros elementos */
            margin-top: auto; /* Asegura que el footer siempre esté al final */
        }
    
        .footer .text-muted {
            color: #666;
        }
    
        .footer span {
            color: rgb(21, 146, 242);
            font-weight: bold;
        }
    
        /* Flexbox para hacer que el contenido siempre ocupe el espacio restante */
        .d-flex {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
    .title-sidebar{
        color: #908e8e;
    }
    /* Ajustar el margen del logo */
.navbar-brand {
    margin-left: 20px; /* Cambia 10px al valor que desees */
    margin-right: 10px; /* Cambia 10px al valor que desees */
}
.menu-perfil {
    margin-left: 10px; /* Cambia 10px al valor que desees */
    margin-right: 20px; /* Cambia 10px al valor que desees */
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
                    @if($logo)
                    <img src="{{ asset($logo->image_url) }}" alt="" style="width: 30px; height:30px;">
                    @endif
                     Clinica Alemana
                    </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                            <a class="nav-link" href="{{ route('tenant.web.inicio') }}" target="_blank"><i class="fas fa-globe"></i></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdownNotification" class="nav-link " href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-bell"></i>
                                <span class="badge " style="background-color:red;">0</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="navbarDropdownNotification">
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
    
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">Perfil</a>
                                    <a class="dropdown-item" href="{{ route('tenant.logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('tenant.logout') }}" method="POST" class="d-none">
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
 <button class="btn btn-outline-primary menu-toggle d-md-none" type="button" onclick="toggleSidebar()" style="margin: 10px;">
    <i class="fas fa-bars"></i> Menú
</button>
    </div>
 

<div class="container-fluid flex-grow-1">
    <div class="row">
        <!-- Menú vertical -->
        <nav id="sidebar" class="col-md-2 d-md-block sidebar">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <br>
                    <h6 class="m-2 title-sidebar">Inicio</h6>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('/dashboard') ? ' active' : '' }}" href="{{ route('tenant.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Resumen
                        </a>
                    </li>
                
                    <h6 class="m-2 title-sidebar">Pacientes</h6>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tenant.consultas.index') }}">
                            <i class="fas fa-user-injured"></i> Gestión de Pacientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-file-medical"></i> Historial Clínico
                        </a>
                    </li>
                
                    <h6 class="m-2 title-sidebar">Citas</h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-alt"></i> Programar Citas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-check"></i> Calendario de Citas
                        </a>
                    </li>
                
                    <h6 class="m-2 title-sidebar">Consultas Médicas</h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-stethoscope"></i> Gestión de Consultas
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
                
                    <h6 class="m-2 title-sidebar">Farmacia</h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-pills"></i> Gestión de Medicamentos
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
                
                    <h6 class="m-2 title-sidebar">Reportes</h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-chart-line"></i> Generar Reportes
                        </a>
                    </li>
                
                    <h6 class="m-2 title-sidebar">Administración</h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-cogs"></i> Configuración del Sistema
                        </a>
                    </li>
                    <h6 class="m-2 title-sidebar">Web</h6>
                    <li class="nav-item">
                        <a class="nav-link{{ request()->is('/logo') ? ' active' : '' }}" href="{{ route('tenant.logo.index') }}">
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
                        <a class="nav-link" href="{{ route('tenant.banner.index') }}">
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
            <span class="text-muted">&copy; {{ date('Y') }} <span>{{ __('Tu Empresa') }}</span>. Todos los derechos reservados.</span>
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
