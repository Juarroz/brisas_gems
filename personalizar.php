<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personalización de Anillo</title>
  <link rel="icon" href="./img/icono.png">

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
  <link rel="stylesheet" href="./css/personalizar.css">
  <meta name="author" content="Fabian Sanchez">
  <meta name="description" content="Brisas Gems permite personalizar joyas en línea con visualización en tiempo real, catálogo inteligente, seguimiento de pedidos y contacto directo con el equipo de diseño.">
 </head>

<body>

<?php include 'includes/header.php'; ?>

  <!-- ---- -->
  <!-- MAIN -->
  <!-- ---- -->
   
  <main class="container my-5">
  <div class="row">
    <!-- Columna izquierda: Vista previa del anillo -->
    <div class="col-md-6 mb-4 mb-md-0">
      <section>
        <h2 class="h5 text-center">Vista previa del anillo</h2>
        <img id="vista-principal" src="./img/personalizacion/vista-previa/vista-superior.jpg" alt="Vista previa del anillo" class="img-fluid mb-3 d-block mx-auto" style="max-height: 300px;">
        <div class="d-flex justify-content-center gap-3">
          <img src="./img/personalizacion/vista-previa/vista-superior.jpg" alt="Vista Superior" class="img-thumbnail miniatura" width="70" onclick="cambiarVista(this)">
          <img src="./img/personalizacion/vista-previa/vista-frontal.jpg" alt="Vista Frontal" class="img-thumbnail miniatura" width="70" onclick="cambiarVista(this)">
          <img src="./img/personalizacion/vista-previa/vista-perfil.jpg" alt="Vista Perfil" class="img-thumbnail miniatura" width="70" onclick="cambiarVista(this)">
        </div>
      </section>
    </div>

    <!-- Columna derecha: Opciones -->
    <div class="col-md-6 container-opciones">
      <form action="contacto.html" method="POST" id="form-personalizacion">
        
        <!-- Hidden inputs -->
        <input type="hidden" name="piedra" id="input-piedra">
        <input type="hidden" name="forma" id="input-forma">
        <input type="hidden" name="tamano" id="input-tamano">
        <input type="hidden" name="material" id="input-material">

        <!-- Piedra -->
        <section class="mb-4">
          <h3 class="h5">Piedra central</h3>
          <div class="d-flex flex-wrap gap-3">
            <button type="button" class="btn-opcion" data-name="piedra" data-value="diamante"><img src="./img/personalizacion/gemas/diamante.png" alt="Diamante"><br>Diamante</button>
            <button type="button" class="btn-opcion" data-name="piedra" data-value="esmeralda"><img src="./img/personalizacion/gemas/esmeralda.png" alt="Esmeralda"><br>Esmeralda</button>
            <button type="button" class="btn-opcion" data-name="piedra" data-value="zafiro"><img src="./img/personalizacion/gemas/zafiro.png" alt="Zafiro"><br>Zafiro</button>
            <button type="button" class="btn-opcion" data-name="piedra" data-value="rubi"><img src="./img/personalizacion/gemas/ruby.png" alt="Rubí"><br>Rubí</button>
          </div>
        </section>
        <!-- Forma -->
        <section class="mb-4">
          <h3 class="h5">Forma de la piedra</h3>
          <div class="d-flex flex-wrap gap-3">
            <button type="button" class="btn-opcion" data-name="forma" data-value="redonda"><img src="./img/personalizacion/forma/redonda.png" alt="Redonda"><br>Redonda</button>
            <button type="button" class="btn-opcion" data-name="forma" data-value="ovalada"><img src="./img/personalizacion/forma/ovalada.png" alt="Ovalada"><br>Ovalada</button>
          </div>
        </section>

        <!-- Tamaño -->
        <section class="mb-4">
          <h3 class="h5">Tamaño de la piedra</h3>
          <div class="d-flex flex-wrap gap-3">
            <button type="button" class="btn-opcion" data-name="tamano" data-value="6mm"><img src="./img/personalizacion/tama-piedra-central/6mm.png" alt="6mm"><br>6 mm</button>
            <button type="button" class="btn-opcion" data-name="tamano" data-value="7mm"><img src="./img/personalizacion/tama-piedra-central/7mm.png" alt="7mm"><br>7 mm</button>
          </div>
        </section>

        <!-- Material -->
        <section class="mb-4">
          <h3 class="h5">Material del anillo</h3>
          <div class="d-flex flex-wrap gap-3">
            <button type="button" class="btn-opcion" data-name="material" data-value="oro_amarillo"><img src="./img/personalizacion/material/oro-amarillo.png" alt="Oro Amarillo"><br>Oro Amarillo</button>
            <button type="button" class="btn-opcion" data-name="material" data-value="oro_blanco"><img src="./img/personalizacion/material/oro-blanco.png" alt="Oro Blanco"><br>Oro Blanco</button>
            <button type="button" class="btn-opcion" data-name="material" data-value="oro_rosa"><img src="./img/personalizacion/material/oro-rosa.png" alt="Oro Rosa"><br>Oro Rosa</button>
            <button type="button" class="btn-opcion" data-name="material" data-value="platino"><img src="./img/personalizacion/material/platino.png" alt="Platino"><br>Platino</button>
          </div>
        </section>

        <!-- Talla -->
        <section class="mb-4">
          <h3 class="h5">Talla del anillo</h3>
          <div class="form-group">
            <select class="form-select" name="talla" required>
              <option disabled selected>Elige tu talla</option>
              <option value="5">Talla 5</option>
              <option value="6">Talla 6</option>
              <option value="7">Talla 7</option>
              <option value="8">Talla 8</option>
              <option value="9">Talla 9</option>
            </select>
            <small class="form-text text-muted">¿No sabes tu talla? <a href="#">Aprende cómo medirla</a></small>
          </div>
        </section>

        <div class="text-center contenedor-boton">
          <button type="submit" class="btn btn-primary">Adquiere tu anillo</button>
        </div>
      </form>
    </div>
  </div>
</main>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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

<script>
  const botones = document.querySelectorAll('button[data-name]');
  const inputs = {
    piedra: document.getElementById('input-piedra'),
    forma: document.getElementById('input-forma'),
    tamano: document.getElementById('input-tamano'),
    material: document.getElementById('input-material')
  };

  botones.forEach(btn => {
    btn.addEventListener('click', () => {
      const nombre = btn.getAttribute('data-name');
      const valor = btn.getAttribute('data-value');

      // Actualizar input oculto
      inputs[nombre].value = valor;

      // Desactivar botones del mismo grupo
      botones.forEach(b => {
        if (b.getAttribute('data-name') === nombre) {
          b.classList.remove('active');
        }
      });

      // Activar el botón actual
      btn.classList.add('active');
    });
  });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>