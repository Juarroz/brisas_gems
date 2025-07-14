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
          <h2 class="h5 text-center" >Vista previa del anillo</h2>
          <img id="vista-principal" src="./img/personalizacion/vistas-anillos/esmeralda/redonda/oro-blanco/superior.jpg" alt="Vista previa del anillo" class="img-fluid mb-3 d-block mx-auto"  style="max-height: 300px;">

          <!-- Miniaturas para cambiar vista -->
          <div class="d-flex justify-content-center gap-3">
            <img id="vista-superior" src="./img/personalizacion/vistas-anillos/esmeralda/redonda/oro-blanco/superior.jpg" alt="Vista Superior" class="miniatura" width="70" onclick="cambiarVista(this)">
            <img id="vista-frontal" src="./img/personalizacion/vistas-anillos/esmeralda/redonda/oro-blanco/frontal.jpg" alt="Vista Frontal" class="miniatura" width="70" onclick="cambiarVista(this)">
            <img id="vista-perfil" src="./img/personalizacion/vistas-anillos/esmeralda/redonda/oro-blanco/perfil.jpg" alt="Vista Perfil" class="miniatura" width="70" onclick="cambiarVista(this)">
          </div>
        </section>
      </div>



      <!-- Columna derecha: Opciones de personalización -->
      <div class="col-md-6 container-opciones">
        <section class="mb-4">
          <h3 class="h5">Piedra central</h3>
          <div class="d-flex flex-wrap gap-3">
            <button class="btn btn-opcion btn-gema" data-gema="diamante">
              <img src="./img/personalizacion/opciones/gemas/diamante.png" alt="Diamante" width="40"><br>Diamante
            </button>
            <button class="btn btn-opcion btn-gema active" data-gema="esmeralda">
              <img src="./img/personalizacion/opciones/gemas/esmeralda.png" alt="Esmeralda" width="40"><br>Esmeralda
            </button>
            <button class="btn btn-opcion btn-gema" data-gema="zafiro">
              <img src="./img/personalizacion/opciones/gemas/zafiro.png" alt="Zafiro" width="40"><br>Zafiro
            </button>
            <button class="btn btn-opcion btn-gema" data-gema="rubi">
              <img src="./img/personalizacion/opciones/gemas/ruby.png" alt="Rubí" width="40"><br>Rubí
            </button>
          </div>
        </section>

        <section class="mb-4">
          <h3 class="h5">Forma de la piedra</h3>
          <div class="d-flex flex-wrap gap-3">
            <button class="btn btn-opcion btn-forma active" data-forma="redonda">
              <img src="./img/personalizacion/opciones/forma/redonda.png" alt="Redonda" width="40"><br>Redonda
            </button>
            <button class="btn btn-opcion btn-forma" data-forma="ovalada">
              <img src="./img/personalizacion/opciones/forma/ovalada.png" alt="Ovalada" width="40"><br>Ovalada
            </button>
            <button class="btn btn-opcion btn-forma solo-esmeralda" data-forma="corazon">
              <img src="./img/personalizacion/opciones/forma/corazon.png" alt="Corazón" width="40"><br>Corazón
            </button>
          </div>
        </section>

        <section class="mb-4">
          <h3 class="h5">Tamaño de la piedra</h3>
          <div class="d-flex flex-wrap gap-3">
            <button class="btn btn-opcion active"><img src="./img/personalizacion/opciones/tama-piedra-central/6mm.png" alt="6mm" width="40"><br>6 mm</button>
            <button class="btn btn-opcion"><img src="./img/personalizacion//opciones/tama-piedra-central/7mm.png" alt="7mm" width="40"><br>7 mm</button>
          </div>
        </section>

        <section class="mb-4">
          <h3 class="h5">Material del anillo</h3>
          <div class="d-flex flex-wrap gap-3">
            <button class="btn btn-opcion btn-material" data-material="oro-amarillo">
              <img src="./img/personalizacion/opciones/material/oro-amarillo.png" alt="Oro Amarillo" width="40"><br>Oro Amarillo
            </button>
            <button class="btn btn-opcion btn-material active" data-material="oro-blanco">
              <img src="./img/personalizacion/opciones/material/oro-blanco.png" alt="Oro Blanco" width="40"><br>Oro Blanco
            </button>
            <button class="btn btn-opcion btn-material" data-material="oro-rosa">
              <img src="./img/personalizacion/opciones/material/oro-rosa.png" alt="Oro Rosa" width="40"><br>Oro Rosa
            </button>
          </div>
        </section>

        <section class="mb-4">
          <h3 class="h5">Talla del anillo</h3>
          <div class="form-group">
            <select class="form-select" id="input-talla">
              <option disabled selected>Elige tu talla</option>
              <option value="4">Talla 4.0</option>
              <option value="4.5">Talla 4.5</option>
              <option value="5">Talla 5.0</option>
              <option value="5.5">Talla 5.5</option>
              <option value="6">Talla 6.0</option>
              <option value="6.5">Talla 6.5</option>
              <option value="7">Talla 7.0</option>
              <option value="7.5">Talla 7.5</option>
              <option value="8">Talla 8.0</option>
              <option value="8.5">Talla 8.5</option>
              <option value="9">Talla 9.0</option>
            </select>
            <small class="form-text text-muted"> ¿No sabes tu talla? 
            <a href="#" data-bs-toggle="modal" data-bs-target="#guiaTallasModal">Aprende cómo medirla</a>
            </small>
        </section>

        <div class="text-center contenedor-boton ">
          <a href="contacto.php" class="btn btn-primary">Empieza tu solicitud</a>
        </div>
      </div>
    </div>
  </main>

<!-- Modal: Guía de tallas -->
<div class="modal fade" id="guiaTallasModal" tabindex="-1" aria-labelledby="guiaTallasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="guiaTallasLabel">Guía para medir tu talla de anillo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <img src="./img/personalizacion/guia-tallas.png" alt="Guía de tallas" class="img-fluid mb-3 rounde">
        <p class="text">
      <strong>Enrolla un pedazo de papel o hilo alrededor de tu dedo, como si fuera un anillo, 
      este debe quedar ajustado, que no quede flojo ni apretado.</strong></p>
        <p> *Marca con una pluma o lapicero el punto exacto donde se junta la tira de papel.</p>
        <p> *Después con una regla mides el papel, enfócate en los milímetros, justo como aparece en la foto.</p>
        <p> *Por último, te fijas en la tabla de tallas de anillos.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- seleccion dinamica -->
<script>
  let gemaSeleccionada = localStorage.getItem('gema') || 'esmeralda';
  let formaSeleccionada = localStorage.getItem('forma') || 'redonda';
  let materialSeleccionado = localStorage.getItem('material') || 'oro-blanco';
  let tamanoSeleccionado = localStorage.getItem('tamano') || '7';
  let tallaSeleccionada = localStorage.getItem('talla') || '5.5';

  function actualizarVistas() {
    const vistas = ['superior', 'frontal', 'perfil'];

    vistas.forEach(vista => {
      const ruta = `./img/personalizacion/vistas-anillos/${gemaSeleccionada}/${formaSeleccionada}/${materialSeleccionado}/${vista}.jpg`;
      const img = document.getElementById(`vista-${vista}`);
      if (img) {
        img.src = ruta;
        img.alt = `Vista ${vista}`;
      }
    });

    const vistaPrincipal = document.getElementById('vista-principal');
    if (vistaPrincipal) {
      vistaPrincipal.src = `./img/personalizacion/vistas-anillos/${gemaSeleccionada}/${formaSeleccionada}/${materialSeleccionado}/superior.jpg`;
      vistaPrincipal.alt = 'Vista previa del anillo';
    }

    // Guardar en localStorage para el resumen
    localStorage.setItem('gema', gemaSeleccionada);
    localStorage.setItem('forma', formaSeleccionada);
    localStorage.setItem('material', materialSeleccionado);
    localStorage.setItem('tamano', tamanoSeleccionado);
    localStorage.setItem('talla', tallaSeleccionada);
  }

  function manejarBotones(selector) {
    document.querySelectorAll(selector).forEach(btn => {
      btn.addEventListener('click', () => {
        if (selector === '.btn-gema') {
          gemaSeleccionada = btn.dataset.gema;

          const corazonBtn = document.querySelector('.btn-forma[data-forma="corazon"]');
          if (gemaSeleccionada === 'esmeralda') {
            corazonBtn.style.display = 'inline-block';
          } else {
            if (corazonBtn.classList.contains('active')) {
              document.querySelectorAll('.btn-forma').forEach(b => b.classList.remove('active'));
              document.querySelector('.btn-forma[data-forma="redonda"]').classList.add('active');
              formaSeleccionada = 'redonda';
            }
            corazonBtn.style.display = 'none';
          }
        }

        if (selector === '.btn-forma') formaSeleccionada = btn.dataset.forma;
        if (selector === '.btn-material') materialSeleccionado = btn.dataset.material;

        const grupo = btn.parentElement.querySelectorAll(selector);
        grupo.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        actualizarVistas();
      });
    });
  }

  manejarBotones('.btn-gema');
  manejarBotones('.btn-forma');
  manejarBotones('.btn-material');

  function cambiarVista(imagen) {
    const vistaPrincipal = document.getElementById('vista-principal');
    if (vistaPrincipal) {
      vistaPrincipal.src = imagen.src;
      vistaPrincipal.alt = imagen.alt;
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const inputTamano = document.getElementById('input-tamano');
    const inputTalla = document.getElementById('input-talla');

    if (inputTamano) {
      inputTamano.value = tamanoSeleccionado;
      inputTamano.addEventListener('input', (e) => {
        tamanoSeleccionado = e.target.value;
        localStorage.setItem('tamano', tamanoSeleccionado);
      });
    }

    if (inputTalla) {
      inputTalla.value = tallaSeleccionada;
      inputTalla.addEventListener('input', (e) => {
        tallaSeleccionada = e.target.value;
        localStorage.setItem('talla', tallaSeleccionada);
      });
    }

    actualizarVistas(); // Carga inicial con valores actuales
  });
</script>

<script>
  // Script para menú usuario (evita conflicto si se incluye varias veces)
  document.addEventListener('DOMContentLoaded', function() {
    const iconoUsuario = document.getElementById('icono-usuario');
    const menuUsuario = document.getElementById('menu-usuario');
    if (iconoUsuario && menuUsuario) {
      iconoUsuario.addEventListener('click', (e) => {
        e.stopPropagation();
        menuUsuario.classList.toggle('activo');
      });
      document.addEventListener('click', (e) => {
        if (!iconoUsuario.contains(e.target) && !menuUsuario.contains(e.target)) {
          menuUsuario.classList.remove('activo');
        }
      });
    }
  });
</script>

<script src="./js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>