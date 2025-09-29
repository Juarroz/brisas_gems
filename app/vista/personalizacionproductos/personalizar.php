<?php
if (!function_exists('e')) { function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); } }
$msg   = $_GET['msg']    ?? null;
$perId = $_GET['per_id'] ?? null;

// (cámbialo por el real)
$WHATS_NUMBER = '57XXXXXXXXXX';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Personalización de Anillo · Brisas Gems</title>
  <link rel="icon" href="<?= BASE_URL ?>/assets/icons/icono.png" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/main.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css" />
  <!-- hoja específica de esta vista (si la tienes) -->
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/personalizar.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Personaliza tu anillo con visualización en tiempo real." />
</head>
<body>
<?php include BASE_PATH . '/public/includes/header.php'; ?>

<main class="container my-5">
  <div class="row">
    <div class="col-12 mb-3">
      <?php if ($msg === 'creado' && $perId): ?>
        <div class="alert alert-success">
          ¡Tu personalización <strong>#<?= e($perId) ?></strong> fue guardada!
          <div class="mt-2">
            <?php
              $waText = rawurlencode("Hola, quiero continuar con mi personalización #{$perId} en Brisas Gems.");
              $waLink = "https://wa.me/{$WHATS_NUMBER}?text={$waText}";
            ?>
            <a class="btn btn-success btn-sm" href="<?= e($waLink) ?>" target="_blank" rel="noopener">Hablar con un asesor en WhatsApp</a>
          </div>
        </div>
      <?php elseif ($msg && $msg !== 'creado'): ?>
        <div class="alert alert-danger">Ocurrió un problema (<?= e($msg) ?>). Intenta de nuevo.</div>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">
    <!-- Columna izquierda: Vista previa -->
    <div class="col-md-6 mb-4 mb-md-0">
      <section>
        <h2 class="h5 text-center">Vista previa del anillo</h2>
        <img id="vista-principal"
             src="<?= BASE_URL ?>/assets/img/personalizacionproductos/vistas-anillos/esmeralda/redonda/oro-blanco/superior.jpg"
             alt="Vista previa del anillo"
             class="img-fluid mb-3 d-block mx-auto" style="max-height:300px">

        <div class="d-flex justify-content-center gap-3">
          <img id="vista-superior" class="miniatura" width="70"
               src="<?= BASE_URL ?>/assets/img/personalizacionproductos/vistas-anillos/esmeralda/redonda/oro-blanco/superior.jpg"
               alt="Vista Superior" onclick="cambiarVista(this)">
          <img id="vista-frontal" class="miniatura" width="70"
               src="<?= BASE_URL ?>/assets/img/personalizacionproductos/vistas-anillos/esmeralda/redonda/oro-blanco/frontal.jpg"
               alt="Vista Frontal" onclick="cambiarVista(this)">
          <img id="vista-perfil" class="miniatura" width="70"
               src="<?= BASE_URL ?>/assets/img/personalizacionproductos/vistas-anillos/esmeralda/redonda/oro-blanco/perfil.jpg"
               alt="Vista Perfil" onclick="cambiarVista(this)">
        </div>
      </section>
    </div>

    <!-- Columna derecha: Opciones + Submit -->
    <div class="col-md-6 container-opciones">
      <form method="post" action="<?= BASE_URL ?>/personalizar/guardar" id="form-personalizar">
        <!-- Piedra central -->
        <section class="mb-4">
          <h3 class="h5">Piedra central</h3>
          <div class="d-flex flex-wrap gap-3" id="grupo-gema">
            <button type="button" class="btn btn-opcion btn-gema" data-gema="diamante">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/gemas/diamante.png" alt="Diamante" width="40"><br>Diamante
            </button>
            <button type="button" class="btn btn-opcion btn-gema active" data-gema="esmeralda">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/gemas/esmeralda.png" alt="Esmeralda" width="40"><br>Esmeralda
            </button>
            <button type="button" class="btn btn-opcion btn-gema" data-gema="zafiro">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/gemas/zafiro.png" alt="Zafiro" width="40"><br>Zafiro
            </button>
            <button type="button" class="btn btn-opcion btn-gema" data-gema="rubi">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/gemas/ruby.png" alt="Rubí" width="40"><br>Rubí
            </button>
          </div>
        </section>

        <!-- Forma -->
        <section class="mb-4">
          <h3 class="h5">Forma de la piedra</h3>
          <div class="d-flex flex-wrap gap-3" id="grupo-forma">
            <button type="button" class="btn btn-opcion btn-forma active" data-forma="redonda">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/forma/redonda.png" alt="Redonda" width="40"><br>Redonda
            </button>
            <button type="button" class="btn btn-opcion btn-forma" data-forma="ovalada">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/forma/ovalada.png" alt="Ovalada" width="40"><br>Ovalada
            </button>
            <button type="button" class="btn btn-opcion btn-forma solo-esmeralda" data-forma="corazon">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/forma/corazon.png" alt="Corazón" width="40"><br>Corazón
            </button>
          </div>
        </section>

        <!-- Tamaño -->
        <section class="mb-4">
          <h3 class="h5">Tamaño de la piedra</h3>
          <div class="d-flex flex-wrap gap-3" id="grupo-tamano">
            <button type="button" class="btn btn-opcion btn-tamano" data-tamano="6">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/tama-piedra-central/6mm.png" alt="6mm" width="40"><br>6 mm
            </button>
            <button type="button" class="btn btn-opcion btn-tamano" data-tamano="7">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/tama-piedra-central/7mm.png" alt="7mm" width="40"><br>7 mm
            </button>
          </div>
        </section>

        <!-- Material -->
        <section class="mb-4">
          <h3 class="h5">Material del anillo</h3>
          <div class="d-flex flex-wrap gap-3" id="grupo-material">
            <button type="button" class="btn btn-opcion btn-material" data-material="oro-amarillo">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/material/oro-amarillo.png" alt="Oro Amarillo" width="40"><br>Oro Amarillo
            </button>
            <button type="button" class="btn btn-opcion btn-material active" data-material="oro-blanco">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/material/oro-blanco.png" alt="Oro Blanco" width="40"><br>Oro Blanco
            </button>
            <button type="button" class="btn btn-opcion btn-material" data-material="oro-rosa">
              <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/opciones/material/oro-rosa.png" alt="Oro Rosa" width="40"><br>Oro Rosa
            </button>
          </div>
        </section>

        <!-- Talla -->
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
            <small class="form-text text-muted">
              ¿No sabes tu talla?
              <a href="#" data-bs-toggle="modal" data-bs-target="#guiaTallasModal">Aprende cómo medirla</a>
            </small>
          </div>
        </section>

        <!-- Hidden inputs para enviar -->
        <input type="hidden" name="gema"     id="f-gema">
        <input type="hidden" name="forma"    id="f-forma">
        <input type="hidden" name="material" id="f-material">
        <input type="hidden" name="tamano"   id="f-tamano">
        <input type="hidden" name="talla"    id="f-talla">

        <div class="text-center contenedor-boton">
          <button type="submit" class="btn btn-primary">Guardar y hablar con un asesor</button>
        </div>
      </form>
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
        <img src="<?= BASE_URL ?>/assets/img/personalizacionproductos/guia-tallas.png" alt="Guía de tallas" class="img-fluid mb-3 rounded">
        <p><strong>Enrolla un pedazo de papel o hilo alrededor de tu dedo...</strong></p>
        <p>* Marca el punto donde se junta la tira.</p>
        <p>* Mide en milímetros.</p>
        <p>* Consulta la tabla de tallas.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  const BASE_IMG = "<?= BASE_URL ?>/assets/img/personalizacionproductos";

  let gemaSeleccionada     = localStorage.getItem('gema')     || 'esmeralda';
  let formaSeleccionada    = localStorage.getItem('forma')    || 'redonda';
  let materialSeleccionado = localStorage.getItem('material') || 'oro-blanco';
  let tamanoSeleccionado   = localStorage.getItem('tamano')   || '6';
  let tallaSeleccionada    = localStorage.getItem('talla')    || '';

  function rutaVista(gema, forma, material, vista) {
    return `${BASE_IMG}/vistas-anillos/${gema}/${forma}/${material}/${vista}.jpg`;
  }

  function setImgSafe(imgEl, src, alt) {
    if (!imgEl) return;
    imgEl.onerror = () => { imgEl.style.visibility = 'hidden'; };
    imgEl.onload  = () => { imgEl.style.visibility = 'visible'; };
    imgEl.src = src; imgEl.alt = alt || '';
  }

  function actualizarVistas() {
    ['superior','frontal','perfil'].forEach(v => {
      setImgSafe(document.getElementById(`vista-${v}`),
                 rutaVista(gemaSeleccionada, formaSeleccionada, materialSeleccionado, v),
                 `Vista ${v}`);
    });
    setImgSafe(document.getElementById('vista-principal'),
               rutaVista(gemaSeleccionada, formaSeleccionada, materialSeleccionado, 'superior'),
               'Vista previa del anillo');

    // Persistir
    localStorage.setItem('gema', gemaSeleccionada);
    localStorage.setItem('forma', formaSeleccionada);
    localStorage.setItem('material', materialSeleccionado);
    localStorage.setItem('tamano', tamanoSeleccionado);
    localStorage.setItem('talla', tallaSeleccionada);
  }

  function manejarGrupo(selector, setter) {
    document.querySelectorAll(selector).forEach(btn => {
      btn.addEventListener('click', () => {
        setter(btn);
        const grupo = btn.parentElement.querySelectorAll(selector);
        grupo.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        actualizarVistas();
      });
    });
  }

  // Listeners
  manejarGrupo('.btn-gema',     (btn)=> {
    gemaSeleccionada = btn.dataset.gema;
    const corazonBtn = document.querySelector('.btn-forma[data-forma="corazon"]');
    if (corazonBtn) {
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
  });
  manejarGrupo('.btn-forma',    (btn)=> { formaSeleccionada    = btn.dataset.forma; });
  manejarGrupo('.btn-material', (btn)=> { materialSeleccionado = btn.dataset.material; });
  manejarGrupo('.btn-tamano',   (btn)=> { tamanoSeleccionado   = btn.dataset.tamano; });

  function cambiarVista(imagen) {
    setImgSafe(document.getElementById('vista-principal'), imagen.src, imagen.alt);
  }

  document.addEventListener('DOMContentLoaded', () => {
    // Marcar activos iniciales según localStorage
    const marcar = (sel, val, attr) => {
      document.querySelectorAll(sel).forEach(b => {
        b.classList.toggle('active', b.dataset[attr] === val);
      });
    };
    marcar('.btn-gema',     gemaSeleccionada,     'gema');
    marcar('.btn-forma',    formaSeleccionada,    'forma');
    marcar('.btn-material', materialSeleccionado, 'material');
    marcar('.btn-tamano',   tamanoSeleccionado,   'tamano');

    // Talla
    const inputTalla = document.getElementById('input-talla');
    if (inputTalla) {
      if (tallaSeleccionada) inputTalla.value = tallaSeleccionada;
      inputTalla.addEventListener('input', (e) => {
        tallaSeleccionada = e.target.value;
        localStorage.setItem('talla', tallaSeleccionada);
      });
    }

    // Sincroniza hidden inputs antes de enviar
    document.getElementById('form-personalizar')?.addEventListener('submit', (e) => {
      document.getElementById('f-gema').value     = gemaSeleccionada;
      document.getElementById('f-forma').value    = formaSeleccionada;
      document.getElementById('f-material').value = materialSeleccionado;
      document.getElementById('f-tamano').value   = tamanoSeleccionado;
      document.getElementById('f-talla').value    = tallaSeleccionada || '';
    });

    actualizarVistas();
  });

  // Exponer para los onclick inline
  window.cambiarVista = cambiarVista;
</script>

<?php include BASE_PATH . '/public/includes/footer.php'; ?>
<script src="<?= BASE_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>