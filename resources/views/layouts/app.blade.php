<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
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
       
         .navbar .navbar-nav {
            margin-left: 20px;
            /* Espacio a la izquierda del menú */
        }
        .navbar .nav-item {
            margin-left: 20px;
            /* Espacio entre elementos del menú */
        }
        .navbar .nav-link:hover {
            color: rgb(21, 146, 242);
            /* Color de texto en hover (amarillo en este caso) */
            /*background-color: #333;*/
            /* Fondo oscuro en hover */
            border-radius: 4px;
            /* Bordes redondeados para el efecto de hover */
        }
        .navbar .nav-link:focus,
        .navbar .nav-link:active {
            /* Mantener el texto blanco */
            background-color: transparent !important;
            /* Mantener el fondo transparente */
        }

        .nav-link.active {
            color: rgb(21, 146, 242) !important;
        }

        /* Estilos del footer */
        .footer {
            padding: 20px 0;
            background-color: #fff;
            border-top: 1px solid #dee2e6;
            width: 100%;
            height: 10px !important;
        }

        .footer .text-muted {
            color: #666;
        }

        .footer span {
            color: rgb(21, 146, 242);
            font-weight: bold;
        }


    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/" style="color: rgb(21, 146, 242);">
                   
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo->image_url) }}" alt="Logo" style="width: 50px; height: 50px;">
                      
                        @endif    VITA
                </a>
           
               
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard') ? ' active' : '' }}" href="{{ route('dashboard.index') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/clinicas') ? ' active' : '' }}"
                                href="{{ route('clinica.index') }}">Clínicas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/logo') ? ' active' : '' }}"
                                href="{{ route('admin.logo.index') }}">Logo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/banner') ? ' active' : '' }}"
                                href="{{ route('admin.banner.index') }}">Banner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categorias/buscar') ? ' active' : '' }}"
                                href="#">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categorias/buscar') ? ' active' : '' }}"
                                href="#">Footer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categorias/buscar') ? ' active' : '' }}"
                                href="#">Informaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/fecha-pagos') ? ' active' : '' }}"
                                href="{{ route('paymentDate.index') }}">Fechas de Pagos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('categorias/buscar') ? ' active' : '' }}"
                                href="#">Servicios</a>
                        </li>
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/" target="_blank"><i class="fas fa-globe"></i></a>
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
                                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">
                                        Perfil
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
        <!-- Footer -->
        <footer class="footer">
            <div class="container text-center">
                <span class="text-muted">&copy; {{ date('Y') }} <span>{{ __('VITA') }}</span>. Todos los derechos reservados.</span>
            </div>
        </footer>
    @yield('js_after')
</body>
</html>
