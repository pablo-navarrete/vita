<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('title') | VITA</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    @if ($logo)
        <link rel="icon" href="{{ asset('storage/' . $logo->image_url) }}" type="image/x-icon">
    @endif
 

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    
    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css_before')
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
      

        .search-container {
            display: flex;
            align-items: center;
            background-color: #fffdfd;
            border-radius: 25px;
            padding: 8px 15px;
            width: 450px;
            /* Aumentado el ancho */
            box-shadow: 0 4px 8px rgba(1, 25, 121, 0.1);
            transition: all 0.3s ease;
        }

        .search-input {
            border: none;
            background: transparent;
            outline: none;
            flex: 1;
            font-size: 16px;
            color: #333;
            padding: 5px;
        }

        .search-button {
            background: #cae0ff;
            border: none;
            border-radius: 50%;
            padding: 8px;
            cursor: pointer;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .search-button:hover {
            background: #1978cb;
        }

        .fa-magnifying-glass {
            font-size: 18px;
        }

        .search-container:focus-within {
            box-shadow: 0 6px 12px rgba(7, 36, 198, 0.2);
        }

        a{
            text-decoration: none;
        }
    </style>

</head>

<body class="index-page">

    <header id="header" class="header sticky-top">



        <div class="branding d-flex align-items-center">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.web.inicio') }}" class="logo d-flex align-items-center me-auto">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    @if ($logo)
                        <img src="{{ asset('storage/' . $logo->image_url) }}" alt=""
                            style="width: 30px; height:30px;">
                    @endif

                    <h1 class="sitename">VITA</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li>
                            <div class="search-container">
                                <input type="text" placeholder="Buscar..." class="search-input">
                                <button class="search-button">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </li>

                        <li><a href="{{ route('admin.web.inicio') }}" class="nav-link {{ request()->is('/') ? ' active' : '' }}">Clínicas y Especialistas<br></a>
                        </li>
                        <li class="dropdown"><a href="#"><span>Servicios</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">Medicina General</a></li>
                                <li class="dropdown"><a href="#"><span>Cardiología</span> <i
                                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                                    <ul>
                                        <li><a href="#">Adulto</a></li>
                                        <li><a href="#">Infantil</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Fonoaudiología</a></li>
                                <li><a href="#">Geriatría</a></li>
                                <li class="dropdown"><a href="#"><span>Psicología</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                                    <ul>
                                        <li><a href="#">Adulto</a></li>
                                        <li><a href="#">Infanto/Juvenil</a></li>
                                    </ul>
                                </li>
                                <li><a href="#">Ginecología</a></li>
                                <li><a href="#">Nutrición</a></li>
                                <li><a href="#">Pediatría</a></li>
                                <li><a href="#">Dermatología</a></li>
                                <li><a href="#">Medicina Interna</a></li>
                                <li><a href="#">Neurología</a></li>
                                <li><a href="#">Kinesiología</a></li>
                                <li><a href="#">Sexología</a></li>
                                <li><a href="#">Urología</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('admin.web.about') }}" class="nav-link {{ request()->is('sobre-vita') ? ' active' : '' }}">Sobre VITA</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                <a class="cta-btn d-none d-sm-block" href="#appointment" data-bs-toggle="modal" data-bs-target="#ubicacionModal"><i class="fa-solid fa-location-dot"></i> Mi
                    ubicación</a>

            </div>

        </div>

    </header>
<!-- Modal ubicación-->
<div class="modal fade" id="ubicacionModal" tabindex="-1" aria-labelledby="ubicacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ubicacionModalLabel">Ingresa tu dirección</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Para buscar la clínica o el especialista más cercano a ti.</p>
          <div class=" mb-3">
            <label for=""class="col-md-4 col-form-label">Dirección</label>
            <input id="" type="text" class="form-control" name="" value="">
          </div>
          
            <br>
            <div class="mb-3 text-center" style="color: #1978cb;">
                <i class="fa-solid fa-location-dot"></i> <a href="#" class="col-md-4 col-form-label" >Usar ubicación actual</a>

            </div>

        </div>
        <div class="modal-footer justify-content-center">
          
          <button type="button" class="btn btn-primary">Confirmar dirección</button>
        </div>
      </div>
    </div>
  </div>
    <main class="py-4">
        @yield('content')
    </main>

    <footer id="footer" class="footer light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        @if ($logo)
                            <img src="{{ asset('storage/' . $logo->image_url) }}" alt=""
                                style="width: 30px; height:30px;">
                        @endif
                        <span class="sitename">VITA</span>
                    </a>
                    <div class="footer-contact pt-2">
                        <p>VITA ofrece un sistema de gestión de pacientes
                            con citas médicas para trabajadores de la salud y un catálogo
                            que permite a los pacientes buscar especialistas y clínicas
                            cercanas. Los usuarios pueden acceder a atención médica, ya sea
                            en línea o presencial, facilitando el proceso de atención y 
                            mejorando la experiencia del paciente.</p>
                        <p class="mt-3"><strong>Telefono:</strong> <span>+569 56231127</span></p>
                        <p><strong>Correo:</strong> <span>contacto@vita.cl</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Menú</h4>
                    <ul>
                        <li><a href="#">Clínicas y Especialistad</a></li>
                        <li><a href="#">Sobre VITA</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Servicios Para Clínicas o Especialistas</h4>
                    <ul>
                        <li><a href="#">Básico</a></li>
                        <li><a href="#">Estandar</a></li>
                        <li><a href="#">Premium</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Terminos y Politica</h4>
                    <ul>
                        <li><a href="#">Politicas de Privacidad</a></li>
                        <li><a href="#">Terminos y Condiciones</a></li>
                        <li><a href="#">Politicas de cookies</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Trabaja con nosotros</h4>
                    <ul>
                        <li><a href="{{ route('admin.web.contact') }}">Contactar</a></li>
                        <li><a href="#">Dejar una opinión</a></li>
                        <li><a href="#">Dinera</a></li>
                        <li><a href="#">Trodelas</a></li>
                        <li><a href="#">Flexo</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">VITA</strong> <span>Todos los derechos reservados</span>
            </p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Desarrollado por <a href="https://bootstrapmade.com/">VITA</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
@yield('js_after')

</body>

</html>
