<!DOCTYPE html>
 <html lang="es">
 <head>
  <title>Brisas Gems</title>
  <link rel="icon" href="./img/icono.png"> 
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
  <link rel="stylesheet" href="./css/index.css">
  <meta charset="UTF-8">
  <meta name="author" content="Natalia">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="Brisas Gems permite personalizar joyas en línea con visualización en tiempo real, catálogo inteligente, seguimiento de pedidos y contacto directo con el equipo de diseño.">
 </head>
 <body>

<?php include 'includes/header.php'; ?>


<!-- ---- -->
<!-- MAIN -->
<!-- ---- -->

 <!-- CARRUSEL DE FOTOS -->

     <section class="carrusel">
        <div class="slide active" style="background-image: url('./img/index/Imagen1.png');"></div>
        <div class="slide" style="background-image: url('./img/index/Imagen2.png');"></div>
        <div class="slide" style="background-image: url('./img/index/Imagen3.png');"></div>
     </section>

 <!-- INFORMACIÓN GENERAL --> 
     <section class="info-section">
       <div class="bienvenida">
         <h2><strong>Bienvenido a Brisas Gems</strong></h2>
         <p><strong> Lugar donde tus ideas cobran vida en forma de joyas exclusivas. 
          Diseña paso a paso la pieza que refleje tu esencia y estilo único. 
          Personaliza, crea y luce algo verdaderamente tuyo.</strong></p>
       </div>

<!-- INFORMACIÓN COMPLEMENTARIA-->
    <article class="info-complement">
      <div class="contexto">
        <p><strong>Tradicion, Arte y Elegancia en Cada Pieza </strong></p>
        <p>"En Brisas Gems, creemos firmemente que la joyería va mucho más allá de un accesorio: es identidad, 
          es cultura y es legado. Durante siglos, las piedras preciosas y los metales han contado historias, y hoy, 
          Colombia brilla ante el mundo como cuna de las esmeraldas más puras y admiradas del planeta.</p>
        
        <p>El auge de la joyería colombiana no es casualidad. Es el reflejo del talento de nuestros artesanos, la riqueza de nuestras 
          montañas y el espíritu resiliente de nuestra gente. Desde nuestro taller, honramos ese legado ancestral y lo transformamos en 
          piezas únicas que combinan tradición, diseño contemporáneo y la magia inigualable de nuestras gemas y en especial las.</p> 
          
        <p>Cada joya que creamos lleva consigo el verde profundo de nuestras tierras, la historia de quienes la portan y
          la pasión de manos colombianas que trabajan con dedicación y orgullo. No solo diseñamos joyas, diseñamos símbolos de herencia, 
          autenticidad y belleza que trascienden fronteras."</p>
      </div>
    </article>

    <section class="contexto-ilustracion">
      <div class="contexto-imagen">
        <img src="./img/index/proceso2.jpg" alt="Joyería Colombiana" class="img1">
        <img src="./img/index/proceso3.jpg" alt="Joyería Colombiana" class="img2">
        <img src="./img/index/proceso1.jpg" alt="Joyería Colombiana" class="img3">
      </div>
    </section>

   <!-- Script para carrusel simple -->
    <script>
        let slides = document.querySelectorAll(".slide");
        let index = 0;

        setInterval(() => {
            slides[index].classList.remove("active");
            index = (index + 1) % slides.length;
            slides[index].classList.add("active");
        }, 4000); // Cambia de imagen cada 3 segundos
    </script>
    <!-- Script para el menú de usuario -->
  <script>
  const iconoUsuario = document.getElementById('icono-usuario');
  const menuUsuario = document.getElementById('menu-usuario');

  iconoUsuario.addEventListener('click', () => {
    menuUsuario.classList.toggle('activo');
  });

  // Cierra el menú al hacer clic fuera
  document.addEventListener('click', (e) => {
    if (!iconoUsuario.contains(e.target) && !menuUsuario.contains(e.target)) {
      menuUsuario.classList.remove('activo');
    }
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
