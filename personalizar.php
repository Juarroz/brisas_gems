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
      <form id="form-personalizacion">
        <div id="opciones-personalizacion"></div>
        <section class="mb-4">
          <h3 class="h5">Talla del anillo</h3>
          <div class="form-group">
            <select class="form-select" name="talla" id="talla" required>
              <option disabled selected>Elige tu talla</option>
              <option value="5">Talla 5</option>
              <option value="6">Talla 6</option>
              <option value="7">Talla 7</option>
              <option value="8">Talla 8</option>
              <option value="9">Talla 9</option>
            </select>
            <small class="form-text text-muted">¿No sabes tu talla? <a href="#" data-bs-toggle="modal" data-bs-target="#modalTallas">Aprende cómo medirla</a></small>
          </div>
        </section>
        <div class="text-center contenedor-boton">
          <button type="submit" class="btn btn-primary">Adquiere tu anillo</button>
        </div>
      </form>
      <div id="alerta-personalizacion" class="mt-3"></div>
    </div>
  </div>
</main>
<!-- Modal guía de tallas -->
<div class="modal fade" id="modalTallas" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Guía de Tallas</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">
        <img src="./img/tallas-anillo.png" alt="Guía de tallas" class="img-fluid">
        <p class="mt-2">Sigue las instrucciones de la imagen para conocer tu talla.</p>
      </div>
    </div>
  </div>
</div>
<script src="./js/bootstrap.bundle.min.js"></script>
<script>
// Menú usuario desplegable (igual que en otros módulos)
document.addEventListener('DOMContentLoaded', function() {
  const iconoUsuario = document.getElementById('icono-usuario');
  const menuUsuario = document.getElementById('menu-usuario');
  if (iconoUsuario && menuUsuario) {
    iconoUsuario.addEventListener('click', function(e) {
      e.stopPropagation();
      menuUsuario.classList.toggle('activo');
    });
    document.addEventListener('click', function(e) {
      if (!menuUsuario.contains(e.target) && e.target !== iconoUsuario) {
        menuUsuario.classList.remove('activo');
      }
    });
  }
});
// Cargar opciones de personalización dinámicamente
fetch('php/personalizacion/listar_opciones.php')
  .then(r => r.json())
  .then(opciones => {
    const cont = document.getElementById('opciones-personalizacion');
    cont.innerHTML = '';
    opciones.forEach(opcion => {
      let html = `<section class='mb-4'>`;
      html += `<h3 class='h5 mb-1 d-flex align-items-center gap-2'>`;
      if(opcion.opc_imagen) html += `<img src='${opcion.opc_imagen}' alt='${opcion.opc_nombre}' style='width:40px;height:40px;object-fit:contain;'>`;
      html += `${opcion.opc_nombre}</h3>`;
      if(opcion.opc_descripcion) html += `<div class='text-muted mb-2' style='font-size:0.95em;'>${opcion.opc_descripcion}</div>`;
      html += `<div class='d-flex flex-wrap gap-3'>`;
      opcion.valores.forEach(val => {
        html += `<button type='button' class='btn-opcion' data-name='${opcion.opc_nombre}' data-value='${val.id}'>`;
        if (val.imagen) html += `<img src='${val.imagen}' alt='${val.nombre}'><br>`;
        html += `${val.nombre}</button>`;
      });
      html += '</div></section>';
      cont.innerHTML += html;
    });
    // Reasignar eventos
    asignarEventosOpciones();
  });
function asignarEventosOpciones() {
  const botones = document.querySelectorAll('#opciones-personalizacion button[data-name]');
  const seleccion = {};
  botones.forEach(btn => {
    btn.addEventListener('click', () => {
      const nombre = btn.getAttribute('data-name');
      const valor = btn.getAttribute('data-value');
      seleccion[nombre] = valor;
      // Desactivar botones del mismo grupo
      botones.forEach(b => {
        if (b.getAttribute('data-name') === nombre) {
          b.classList.remove('active');
        }
      });
      btn.classList.add('active');
      // Vista previa (simulada)
      document.getElementById('vista-principal').src = './img/personalizacion/vista-previa/vista-superior.jpg';
    });
  });
  // Guardar personalización
  document.getElementById('form-personalizacion').onsubmit = function(e) {
    e.preventDefault();
    const selecciones = Object.values(seleccion);
    const talla = document.getElementById('talla').value;
    fetch('php/personalizacion/guardar_personalizacion.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ selecciones, talla })
    })
    .then(r => r.json())
    .then(res => {
      const alerta = document.getElementById('alerta-personalizacion');
      if (res.success) {
        alerta.innerHTML = `<div class='alert alert-success'>¡Personalización guardada! Código de pedido: ${res.codigo}</div>`;
        setTimeout(() => { window.location.href = 'usuario/mis-pedidos.php'; }, 1500);
      } else {
        alerta.innerHTML = `<div class='alert alert-danger'>${res.error || 'Error al guardar.'}</div>`;
      }
    });
  }
}
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>