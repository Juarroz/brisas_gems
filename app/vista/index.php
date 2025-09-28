<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Brisas Gems</title>
  <link rel="icon" href="<?= BASE_URL ?>/assets/icons/icono.png" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/index.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Brisas Gems: personalización de joyas, inspiración y seguimiento de pedidos." />
</head>
<body>

<?php include BASE_PATH . '/public/includes/header.php'; ?>

<main>

  <!-- Hero / Carrusel -->
  <section class="carrusel">
    <div class="slide active" style="background-image:url('<?= BASE_URL ?>/assets/img/index/Imagen1.png');"></div>
    <div class="slide" style="background-image:url('<?= BASE_URL ?>/assets/img/index/Imagen2.png');"></div>
    <div class="slide" style="background-image:url('<?= BASE_URL ?>/assets/img/index/Imagen3.png');"></div>

    <div class="cta-hero text-center">
      <h1>Diseña tu joya soñada</h1>
      <p>Personaliza paso a paso con Brisas Gems</p>
      <a class="btn btn-light" href="<?= BASE_URL ?>/personalizar">Comenzar personalización</a>
    </div>
  </section>

  <!-- Bienvenida -->
  <section class="info-section py-5 text-center">
    <h2 class="mb-3">Bienvenido a Brisas Gems</h2>
    <p>Donde tus ideas cobran vida en joyas exclusivas hechas a tu medida.</p>
  </section>

  <!-- Personalización -->
  <section class="modulo-section container py-5">
    <div class="row align-items-center">
      <div class="col-md-6">
        <img class="img-fluid rounded shadow"
             src="<?= BASE_URL ?>/assets/img/index/proceso1.jpg"
             alt="Personalización de joyas">
      </div>
      <div class="col-md-6">
        <h3>Personaliza tu anillo</h3>
        <p>Elige gema, forma, material y talla en tiempo real.</p>
        <a class="btn btn-primary" href="<?= BASE_URL ?>/personalizar">Ir al configurador</a>
      </div>
    </div>
  </section>

  <!-- Inspiración (Fase 2 visible desde ya) -->
  <section class="modulo-section bg-light py-5 text-center">
    <h3>¿Necesitas inspiración?</h3>
    <p>Explora diseños previos y encuentra ideas para tu joya.</p>
    <a class="btn btn-outline-dark" href="<?= BASE_URL ?>/inspiracion">Ver catálogo</a>
  </section>

  <!-- Pedidos -->
  <section class="modulo-section container py-5">
    <div class="row align-items-center">
      <div class="col-md-6 order-md-2">
        <img class="img-fluid rounded shadow"
             src="<?= BASE_URL ?>/assets/img/index/proceso2.jpg"
             alt="Seguimiento de pedidos">
      </div>
      <div class="col-md-6">
        <h3>Sigue tu pedido</h3>
        <p>Revisa el estado desde la confirmación hasta la entrega final.</p>
        <a class="btn btn-success" href="<?= BASE_URL ?>/usuario/mis-pedidos">Mis pedidos</a>
      </div>
    </div>
  </section>

  <!-- Contacto -->
  <section class="modulo-section bg-light py-5 text-center">
    <h3>¿Necesitas ayuda?</h3>
    <p>Escríbenos para resolver dudas o recibir asesoría personalizada.</p>
    <a class="btn btn-outline-primary" href="<?= BASE_URL ?>/contacto">Formulario de contacto</a>
  </section>

</main>

<?php include BASE_PATH . '/public/includes/footer.php'; ?>

<!-- Scripts -->
<script>
  // Carrusel simple
  const slides = document.querySelectorAll(".slide");
  let idx = 0;
  setInterval(() => {
    slides[idx].classList.remove("active");
    idx = (idx + 1) % slides.length;
    slides[idx].classList.add("active");
  }, 4000);

  // Menú usuario
  const iconoUsuario = document.getElementById('icono-usuario');
  const menuUsuario  = document.getElementById('menu-usuario');
  if (iconoUsuario && menuUsuario) {
    iconoUsuario.addEventListener('click', () => menuUsuario.classList.toggle('activo'));
    document.addEventListener('click', e => {
      if (!iconoUsuario.contains(e.target) && !menuUsuario.contains(e.target)) {
        menuUsuario.classList.remove('activo');
      }
    });
  }
</script>
<script src="<?= BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
