@extends('layouts.menu')
@section('title')
    Sobre VITA
@endsection
@section('content')


<!-- Stats Section -->
<section id="stats" class="stats section light-background" style="background-image: url('{{ asset($logo->image_url) }}'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 200px;">

  <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
    <div class="container section-title" data-aos="fade-up">
      <h2>Sobre Nosotros</h2>
    </div>
  </div>

</section><!-- /Stats Section -->
    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>VITA spa</h3>
            <p>
              Nuestra plataforma web está diseñada para revolucionar la atención médica, ofreciendo un sistema de gestión integral de pacientes que facilita la programación de citas médicas para trabajadores de la salud. Los profesionales pueden administrar sus agendas de manera eficiente, optimizando el tiempo y mejorando la atención al paciente.

              Además, la plataforma cuenta con un catálogo interactivo que permite a los pacientes buscar especialistas y clínicas según su ubicación. Con una interfaz intuitiva, los usuarios pueden encontrar fácilmente opciones de atención médica, ya sea de forma presencial o en línea, garantizando acceso a servicios de salud de calidad en su área. Esta solución innovadora no solo mejora la experiencia del paciente, sino que también apoya a los profesionales de la salud en la gestión de sus consultas.            </p>
            <ul>
              <li>
                <i class="fa-solid fa-calendar-check"></i>
                <div>
                  <h5>Gestión Integral de Pacientes y Citas Médicas</h5>
                  <p>Facilita la organización y administración de citas para profesionales 
                    de la salud, optimizando la atención al paciente.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-map-marker-alt"></i>
                <div>
                  <h5>Catálogo Interactivo de Especialistas y Clínicas Cercanas</h5>
                  <p>Permite a los pacientes localizar fácilmente clínicas y especialistas en su área,
                     tanto para consultas presenciales como en línea.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-stethoscope"></i>
                <div>
                  <h5>Acceso a Servicios de Salud de Calidad y Eficiencia</h5>
                  <p>Una plataforma que mejora la experiencia del usuario y apoya a
                     los profesionales en la gestión de sus consultas y agendas.</p>
                </div>
              </li>
            </ul>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->




@endsection