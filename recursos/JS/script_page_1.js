$(document).ready(function(){
    $(window).scroll(function(){
        // sticky navbar on scroll script
        if(this.scrollY > 20){
            $('.navbar_top').addClass("sticky");
        }else{
            $('.navbar_top').removeClass("sticky");
        }

        // scroll-up button show/hide script
        if(this.scrollY > 500){
            $('.scroll-up-btn').addClass("show");
        }else{
            $('.scroll-up-btn').removeClass("show");
        }
    });

    // slide-up script
    $('.scroll-up-btn').click(function(){
        $('html').animate({scrollTop: 0});
        // removing smooth scroll on slide-up button click
        $('html').css("scrollBehavior", "auto");
    });

    $('.navbar_top .menu li a').click(function(){
        // applying again smooth scroll on menu items click
        $('html').css("scrollBehavior", "smooth");
    });

    // toggle menu/navbar script
    $('.menu-btn').click(function(){
        $('.navbar_top .menu').toggleClass("active");
        $('.menu-btn i').toggleClass("active");
    });

    // typing text animation script
    var typed = new Typed(".typing", {
        strings: ["Compromiso", "Responsabilidad", "Entusiasmo","Actitud","Respeto"],
        typeSpeed: 100,
        backSpeed: 60,
        loop: true
    });

    var typed = new Typed(".typing-2", {
        strings: ["Noticias","Nuevos"],
        typeSpeed: 100,
        backSpeed: 60,
        loop: true
    });

    // owl carousel script
    $('.carousel').owlCarousel({
        margin: 20,
        loop: true,
        autoplayTimeOut: 2000,
        autoplayHoverPause: true,
        responsive: {
            0:{
                items: 1,
                nav: false
            },
            600:{
                items: 2,
                nav: false
            },
            1000:{
                items: 3,
                nav: false
            }
        }
    });
});


// Galeria inicio
[...document.querySelectorAll(".single-column")].map(column => {
    column.style.setProperty("--animation", "slide");
    column.style.setProperty("height", "200%");
    column.innerHTML = column.innerHTML + column.innerHTML;
  });
  

  let slider = document.querySelector(".slider-contenedor")
  let sliderIndividual = document.querySelectorAll(".contenido-slider")
  let contador = 1;
  let width = sliderIndividual[0].clientWidth;
  let intervalo = 3000;
  
  window.addEventListener("resize", function(){
      width = sliderIndividual[0].clientWidth;
  })
  
  setInterval(function(){
      slides();
  },intervalo);
  
  
  
  function slides(){
      slider.style.transform = "translate("+(-width*contador)+"px)";
      slider.style.transition = "transform .8s";
      contador++;
  
      if(contador == sliderIndividual.length){
          setTimeout(function(){
              slider.style.transform = "translate(0px)";
              slider.style.transition = "transform 0s";
              contador=1;
          },1500)
      }
  }