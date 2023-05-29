<?php
include_once "./assets/templates/header.php";
?>

<!--HOme-->
<section style="background-image: url(./assets/img/Colegio/baner-main-colegio.jpg);" class="page-banner-wrap bg-cover baner-small">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 col-12">
                <div class="page-heading text-white">
                    <div class="page-title">
                        <h1>Colegio</h1>
                    </div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Colegio</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<?php
include_once "./assets/templates/baner-info.php";
?>
<!--HOme-->

<br>
<br>
<br>
<br>
<!-- Test services  -->

<!-- Feature Area Start -->
<div class="feature_area section_gap">
    <div class="feature_shape circle_round"></div>
    <div class="feature_shape_2"></div>
    <div class="container">


    <div class="row mb-70">
            <div class="col-lg-6 col-12">
                <div class="section-title style-3">
                    <span>Servicios</span>
                    <p>Los mejores</p>
                    <h1>Servicios Educativos</h1>
                </div>
            </div>
            <div class="col-lg-6 mt-4 mt-lg-0 col-12 text-lg-right">
                <div class="work-process-nav"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 wow fadeInUp animated" data-wow-duration="1500ms" data-wow-delay="200ms">
                <a href="./colegio.php">
                <div class="single_feature">

                    <img src="./assets/img/Colegio/colegioservice-preescolar.jpg" alt="features-images">
                </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp animated" data-wow-duration="1500ms" data-wow-delay="400ms">
                <a href="./educacionciclos.php">
                <div class="single_feature">
                    <img src="./assets/img/Colegio/colegioservice-primaria.jpg" alt="features-images">
                </div>
                </a>
            </div>

            <div class="col-lg-4 col-md-6 wow fadeInUp animated" data-wow-duration="1500ms" data-wow-delay="600ms">
                <a href="./tecnicoslaborales.php">
                <div class="single_feature single-last-item">
                    <img src="./assets/img/Colegio/colegioservice-bachillerato.jpg" alt="features-images">
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Feature Area End -->
<!-- Test services  -->

<br><br><br>





<section class="consultations-wrapper section-padding bg-contain pb-0" style="background-image: url('assets/img/circle-bg-2.png')">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 col-xl-5">
                <h1 style="line-height: 42px;">No Dudes En<br>
                    Ponerte En Contacto Con Nosotros </h1>
                <p style="font-family: sans-serif; font-size: 19px;" class="mt-3">Si tienes alguna pregunta o
                    necesitas más información, no dudes en ponerte en contacto con nosotros.</p>

                <div class="call-consultation mt-30 mb-40">
                    <div class="icon">
                        <i class="fal fa-phone-plus"></i>
                    </div>
                    <div class="content">
                        <span>Phone Number</span>
                        <h5><a href="tel:+012 (345) 789 66">(+57) 316 628-8374</a></h5>
                    </div>
                </div>

               

            </div>

            <div class="col-12 col-lg-6 col-xl-6 offset-xl-1">
                <div class="consultations-form text-white">
                    <p>Habla Con Nosotros</p>
                    <h1>Escribenos aqui</h1>
                    <form id="formulario">
                        <input name="nombre" id="nombre" type="text" placeholder="Nombre Completo" required>
                        <input name="correo" id="correo" type="email" placeholder="Correo electrónico" required>
                        <textarea name="mensaje" id="mensaje" placeholder="Escribenos aqui tu mensaje" required></textarea>
                        <button class="theme-btn" type="submit">Enviar<i class="fas fa-arrow-right"></i></button>
                    </form>


                    <script>
                        document.getElementById('formulario').addEventListener('submit', function(e) {
                            e.preventDefault(); // Evita que se envíe el formulario de forma predeterminada

                            var nombre = document.getElementById('nombre').value;
                            var correo = document.getElementById('correo').value;
                            var mensaje = document.getElementById('mensaje').value;

                            // Realiza una solicitud HTTP POST al servidor
                            var xhr = new XMLHttpRequest();
                            var url = 'enviar_correo.php'; // Cambia esto por la URL de tu archivo de backend
                            xhr.open('POST', url, true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    console.log(xhr.responseText); // Muestra la respuesta del servidor en la consola

                                    Swal.fire(
                                        'Mensaje enviado con exito',
                                        'success'
                                    )

                                    // Recargar la página
                                    location.reload();

                                }
                            };
                            var data = 'nombre=' + encodeURIComponent(nombre) + '&correo=' + encodeURIComponent(correo) + '&mensaje=' + encodeURIComponent(mensaje);
                            xhr.send(data);
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</section>

<br><br>

<section style="margin-top: -80px;" class="our-process clear-fix section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-12 text-center">
                <div class="section-title mb-40">
                    <p>Lo que nos hace unicos</p>
                    <h1>En santander de Quilichao</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-work-process">
                    <div class="icon">
                        <i class="fal fa-gem"></i>

                        <span>01</span>
                    </div>
                    <div class="content">
                        <h3>Educación de calidad</h3>
                        <p style="font-family: sans-serif;">Contamos con un plan de educación para el trabajo y el
                            desarrollo humano.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-work-process">
                    <div class="icon">
                        <i class="fal fa-bullseye-arrow"></i>
                        <span>02</span>
                    </div>
                    <div class="content">
                        <h3>Educación en Valores</h3>
                        <p style="font-family: sans-serif;">Contamos con formación en valores para nuestros
                            estudiantes</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-work-process">
                    <div class="icon">
                        <i class="fal fa-users"></i>
                        <span>03</span>
                    </div>
                    <div class="content">
                        <h3>Liderazgo</h3>
                        <p style="font-family: sans-serif;">Inspiramos a nuestros estudiantes, para transformar el
                            mundo</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="work-link d-none d-lg-block">
        <svg width="1292px" height="136px">
            <path fill-rule="evenodd" stroke="rgb(9, 107, 216)" stroke-width="2px" stroke-dasharray="8, 8" stroke-linecap="butt" stroke-linejoin="miter" opacity="0.2" fill="none" d="M1.000,131.999 C1.000,131.999 190.931,8.144 400.000,91.999 C626.535,182.860 763.243,66.417 833.000,32.000 C931.956,-16.824 1115.947,-22.085 1289.774,130.874 " />
        </svg>
    </div>
</section>





<br><br>
<!--Btn whatsapp-->
<div class=" float2">
    <div class="nshare">
        <a class="nshare-item nshare-ws" href="https://wa.link/5gai9l">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>
</div>
<!--Btn whatsapp-->
<!-- FIN REDES SOCIALES -->


<?php
include_once "./assets/templates/footer.php";

?>