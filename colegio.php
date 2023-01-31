<?php
include_once "header.php";
?>


<!DOCTYPE html>
<html lang="en">


<body>

  <!--1. Navbar -->
  <header class="header-wrap header-2">
    <div class="top-header d-none d-md-block">
      <div class="container-flud">
        <div class="row">
          <div class="col-md-7 pr-md-0 col-12">
            <div class="header-cta">
              <ul>
                <li>
                  <a href="soporte@imcreativo.edu.co"><i class="fal"></i>
                    soporte@imcreativo.edu.co</a>
                </li>
                <li>
                  <a href="tel:+573154375785"><i class="fal fa-phone"></i> +57 (315) 4375785</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-md-5 col-12">
            <div class="header-right-cta d-flex justify-content-end">
              <div class="social-profile mr-30">
                <a target="_blank" href="https://www.facebook.com/imcreativo.edu.co"><i
                    class="fab fa-facebook-f"></i></a>
                <a target="_blank" href=" https://wa.link/5gai9l"><i class="fab fab fa-whatsapp"></i></a>
                <a target="_blank" href="https://www.youtube.com/channel/UCB9WnOxqDXmPcJwqAauBxWQ"><i
                    class="fab fa-youtube"></i></a>
              </div>
              |
              <div class="lan-select ml-30">
                <a href="./paginas/login_boletines.php">Docentes</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 1.1 NavbarMobile -->
    <div class="main-header-wraper">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
          <div class="header-logo">
            <div class="logo">
              <a href="#">
                <img src="assets/img/logo-navbar-mundocreativo.svg" alt="logo">
              </a>
            </div>
          </div>
          <div class="header-menu d-none d-xl-block">
            <div class="main-menu">
              <ul>
                <li><a href="./index.php">Inicio</a></li>
                <li><a href="#nosotros">Nosotros</a> </li>
                <li><a href="#">Academia<i class="fas fa-angle-down"></i></a>
                  <ul class="sub-menu">
                    <li><a href="#">Pree-Escolar</a></li>
                    <li><a href="#">Primaria</a></li>
                    <li><a href="#">Bachillerato</a></li>
                  </ul>
                </li>
                <li><a href="#contact">Contactos</a></li>
              </ul>
            </div>
          </div>
          <div class="header-right d-flex align-items-center">
            <div class="header-btn-cta">
              <a href="contact.html" class="theme-btn">Estudiantes<i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="mobile-nav-bar d-block ml-3 ml-sm-5 d-xl-none">
              <div class="mobile-nav-wrap">
                <div id="hamburger">
                  <i class="fal fa-bars"></i>
                </div>
                <!-- mobile menu - responsive menu  -->
                <div class="mobile-nav">
                  <button type="button" class="close-nav">
                    <i class="fal fa-times-circle"></i>
                  </button>
                  <nav class="sidebar-nav">
                    <ul class="metismenu" id="mobile-menu">
                      <li><a href="./index.php">Inicio</a></li>
                      <li><a href="#nosotros">Nosotros</a> </li>
                      <li>
                        <a class="has-arrow" href="#">Academia</a>
                        <ul class="sub-menu">
                          <li><a href="#">Pree-Escolar</a></li>
                          <li><a href="#">Primaria</a></li>
                          <li><a href="#">Bachillerato</a></li>
                        </ul>
                      </li>
                      <li><a href="contact">Contactos</a></li>
                    </ul>
                  </nav>
                  <div class="action-bar">
                    <a href="tel:+573154375785"><i class="fal fa-phone"></i> +57 (315) 4375785</a>
                  </div>
                </div>
              </div>
              <div class="overlay"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin NavbarMobile -->
  </header>
  <!-- FIn Navbar -->

  <!-- 2. HomePage -->
  <section class="hero-slide-wrapper hero-2">
    <div class="hero-slider-2 owl-carousel">
      <!--Colegio Baner-->
      <div class="single-slide bg-cover" style="background-image: url(assets/img/home2/slide1.jpg);
            ">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-lg-6">
              <div class="hero-contents">
                <br><br>
                <h1>Matriculas Abiertas <span style="color: #FFDE59;">2023</span></h1>
                <p style="font-family: 'Encode Sans Condensed', sans-serif;">Que esperas para unirte a
                  nuestra familia Creativista, ofrecemos una experiencia formativa de alta calidad
                  para todos nuestros estudiantes.</p>
                <a href="services.html" class="theme-btn">Matricúlate Aqui<i class="fas fa-arrow-right"></i></a>
                <!-- <a style="color: white;" href="about.html" class="theme-btn minimal-btn">Conoce más<i
                                        class="fas fa-arrow-right"></i></a> -->
              </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0 col-12 pl-lg-5">
              <div class="hero-banner">
                <div class="dot"></div>
                <img class="rounded" src="assets/img/home4/hero-4.png"
                  class="d-block mx-lg-auto img-fluid rounded shadow-lg"
                  src="./recursos/img/colegio_instituto_mundo_creativo.jpg">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--Colegio Baner-->
    </div>
  </section>
  <!-- Fin HomePage -->

  <br>
  <br>



  <section>
    <div class="container my-5">
      <h4 style="color:#000529; font-weight: bold; font-size: calc(1.320rem + 2.1vw);" class="text-center display-5">
        Colegio Instituto Mundo Creativo
      </h4>
      <br>
      <p style="color:#000529; font-size: 25px;" class="text-center">Santander de Quilichao - Cauca</p>
      <br>
      <p
        style="color:#000529; width: 85%; margin: auto; text-align: justify; font-size: 20px; background-attachment:scroll;">
        En Mundo Creativo contamos con altos
        entandares de calidad educativa, ofrecemos una experiencia formativa desarrollando estudiantes capaces de
        emprender un proyecto de vida transformador en una sociedad globalizada. Con el apoyo y el compromiso de toda la
        Comunidad Creativista.</p>
    </div>
  </section>



<section class="img-banner-colegio">

<div>Conoce nuestra institución</div>

</section>

  <section class="container my-5">
<div class="accesorapido">
    <div class="text-center">
        <div  style='background-color: #ededed; font-size: 22px; line-height: 30px; padding: 18px;   font-size: 30px;'>Preescolar </div>
        <img src="./assets/img/Colegio/estudiantes-preescolar-mundocreativo.jpg" class="img-fluid" alt="...">
        <div class="rounded" style=" background-color: #19295E;"><a style="color: white;"href="">Conoce más aquí ></a></div>
    </div>

    <div class="text-center">
        <div style='background-color: #ededed; font-size: 22px; line-height: 30px; padding: 18px;   font-size: 30px;'>Primaria</div>
        <img src="./assets/img/Colegio/estudiantes-primaria-mundocreativo.jpg" class="img-fluid" alt="...">
        <div class="rounded" style=" background-color: #19295E;"><a style="color: white;"href="">Conoce más aquí ></a></div>

    </div>

    <div class="text-center">
        <div style='background-color: #ededed; font-size: 22px; line-height: 30px; padding: 18px;   font-size: 30px;'>Bachillerato</div>
        <img src="./assets/img/Colegio/estudiante-bachillerato-mundocreativo.jpg" class="img-fluid" alt="...">
        <div class="rounded" style=" background-color: #19295E;"><a  style="color: white;" href="">Conoce más aquí ></a></div>

    </div>
</div>
</section>

<br>


    <div class="container my-5">
      <h4 style="color:#000529; font-weight: bold; font-size: calc(1.320rem + 2.1vw);" class="text-center display-5">
        Noticias y Actividades
      </h4>
      <br>
      <p style="color:#000529; font-size: 25px;" class="text-center">#CreativoAlDia</p>
<br>
      <div class="noticias">


      <!-- -->
      <div>
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/m1pcXmX02p4"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
                <div style="padding: 15px;" class="shadow-lg rounded">
                    <h2 style="">Feria de la ciencia y la tecnologia</h2>
                    <p>Como objetivo de mostrar proyectos y experimentos de los estudiantes de primaria, el
                        Instituto Mundo creativo llevó a cabo la Feria de la Ciencia, un espacio donde se promovió
                        la investigación, intercambio y aprendizaje en áreas como matemáticas, biología, entre
                        otros.</p>
                </div>
            </div>
            <!-- -->

            <!-- -->      
            <div>
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/CrVxw4F_FWw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                <div style="padding: 15px;" class="shadow-lg rounded">
                    <h2 style="">Día del idioma y la raza</h2>
                    <p>En el marco del Día del Respeto a la Diversidad Cultural celebrado en el mes de Octubre, el Instituto Mundo Creativos llevó a cabo la Celebración del día de la Raza y el Bilingüismo, una actividad en donde participaron los estudiantes de diferentes grados tanto de primaria como bachillerato de la institución.</p>
                </div>
            </div>
            <!-- -->
     
    </div>
  
    <br><br>

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1446.158790091319!2d-76.4856941400431!3d3.0159642256021235!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e308076a8026be5%3A0x5d7111594c3c9c0b!2sColegio%20Instituto%20Mundo%20Creativo!5e1!3m2!1ses!2sco!4v1674833648969!5m2!1ses!2sco" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

    
</body>

</html>
<?php
include_once "footer.php";
?>