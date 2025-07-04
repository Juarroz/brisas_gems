<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistema interactivo de Brisas Gems para la personalización de joyas en línea">
  <meta name="author" content="Johan Bocanegra">
  <link rel="icon" href="./img/icono.png">
  <title>Seguimiento de Pedido | Brisas Gems</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
  <link rel="stylesheet" href="./css/inspiracion.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<!-- CONTENIDO PRINCIPAL -->

<div class="main-content">
  <div class="portafolio">
    <h3><strong>CREACIONES DESTACADAS</strong></h3>
    <!-- Tarjetas de portafolio -->
    <div class="card carta">
      <div class="cara card-body frente">
        <div class="card-img-container">
          <img src="./img/Portafolio/anillo1.jpg" alt="Joyería">
        </div>
        <h5 class="card-title"><strong>Anillo de Compromiso</strong></h5>
        <p class="card-text">Diseño exclusivo, elegante y con un toque juvenil.</p>
      </div>
      <div class="cara card-body atras">
        <h5 class="card-title"><strong>Detalles del Anillo</strong></h5>
        <ul class="list-unstyled">
          <li>○ Material: Plata</li>
          <li>○ Gema: Tanzanita</li>
          <li>○ Forma gema: Cuadrada</li>
          <li>○ Tamaño gema: 3mm</li>
        </ul>
      </div>
    </div>

    <div class="card carta">
      <div class="cara card-body frente">
        <div class="card-img-container">
        <img src="./img/Portafolio/anillo2.png" alt="Joyería">
        </div>
        <h5 class="card-title"><strong>Anillo de Sello</strong></h5>
        <p class="card-text">Diseño sofisticado, único y con tradición incrustada.</p>
      </div>
      <div class="cara card-body atras">
        <h5 class="card-title"><strong>Detalles del Anillo</strong></h5>
        <ul class="list-unstyled">
          <li>○ Material: Plata</li>
          <li>○ Gema: Esmeralda</li>
          <li>○ Forma gema: Ovalada</li>
          <li>○ Tamaño gema: 10mm</li>
        </ul>
      </div>
    </div>

    <div class="card carta">
      <div class="cara card-body frente">
        <div class="card-img-container">
        <img src="./img/Portafolio/anillo3.jpg" alt="Joyería">
        </div>
        <h5 class="card-title"><strong>Anillo de Promesa</strong></h5>
        <p class="card-text">Diseño inspirado en el mar, en la calidad del amor y la elegancia.</p>
      </div>
      <div class="cara card-body atras">
        <h5 class="card-title"><strong>Detalles del Anillo</strong></h5>
        <ul class="list-unstyled">
          <li>○ Material: Oro amarillo</li>
          <li>○ Gema:Zafiro </li>
          <li>○ Forma gema: Ovalada</li>
          <li>○ Tamaño gema: 5mm</li>
        </ul>
      </div>
    </div>

    <div class="card carta">
      <div class="cara card-body frente">
        <div class="card-img-container">
        <img src="./img/Portafolio/anillo4.jpg" alt="Joyería">
        </div>
        <h5 class="card-title"><strong>Anillo de 15 Años</strong></h5>
        <p class="card-text">Diseño extravagante, único, con un llamado a las nuevas etapas.</p>
      </div>
      <div class="cara card-body atras">
        <h5 class="card-title"><strong>Detalles del Anillo</strong></h5>
        <ul class="list-unstyled">
          <li>○ Material: Plata</li>
          <li>○ Gema: Rubí</li>
          <li>○ Forma gema: Ovalada</li>
          <li>○ Tamaño gema: 10mm</li>
        </ul>
      </div>
    </div>

    <div class="card carta">
      <div class="cara card-body frente">
        <div class="card-img-container">
        <img src="./img/Portafolio/anillo2.png" alt="Joyería">
        </div>
        <h5 class="card-title"><strong>Anillo de Compromiso</strong></h5>
        <p class="card-text">Diseño exclusivo, elegante y con un toque juvenil.</p>
      </div>
      <div class="cara card-body atras">
        <h5 class="card-title"><strong>Detalles del Anillo</strong></h5>
        <ul class="list-unstyled">
          <li>○ Material: Oro amarillo</li>
          <li>○ Gema: Rubí</li>
          <li>○ Forma gema: Ovalada</li>
          <li>○ Tamaño gema: 7mm</li>
        </ul>
      </div>
    </div>

    <div class="card carta">
      <div class="cara card-body frente">
        <div class="card-img-container">
        <img src="./img/Portafolio/anillo2.png" alt="Joyería">
        </div>
        <h5 class="card-title"><strong>Anillo de Compromiso</strong></h5>
        <p class="card-text">Diseño exclusivo, elegante y con un toque juvenil.</p>
      </div>
      <div class="cara card-body atras">
        <h5 class="card-title"><strong>Detalles del Anillo</strong></h5>
        <ul class="list-unstyled">
          <li>○ Material: Oro amarillo</li>
          <li>○ Gema: Rubí</li>
          <li>○ Forma gema: Ovalada</li>
          <li>○ Tamaño gema: 7mm</li>
        </ul>
      </div>
    </div>
</div>
</div>


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

<?php include 'includes/footer.php'; ?>
</body>
</html>