<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sistema interactivo de Brisas Gems para la personalización de joyas en línea">
  <meta name="author" content="Johan Bocanegra">
  <link rel="icon" href="../img/icono.png">
  <title>Mis Pedidos</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <!-- Estilos globales y específicos -->
  <link rel="stylesheet" href="../css/assets/css-global/main.css">
  <link rel="stylesheet" href="../css/mis-pedidos.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

  <main class="container py-5 seguimiento-pedidos" id="seguimiento-pedidos">
    <h2 class="mb-4">Seguimiento de Pedidos</h2>
    <!-- Lista de pedidos -->
    <section>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">Código</th>
              <th scope="col">Fecha</th>
              <th scope="col">Estado</th>
              <th scope="col">Progreso</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody id="tbody-pedidos">
            <!-- Aquí se cargarán los pedidos dinámicamente -->
          </tbody>
        </table>
      </div>
    </section>

    <!-- Modal: Detalles del pedido -->
    <div class="modal fade" id="detallesPedidoModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title w-100 text-center">Detalles del Pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <!-- Se llena dinámicamente -->
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal: Render 3D -->
    <div class="modal fade" id="render3DModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title w-100 text-center">Diseño Renderizado</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body text-center">
            <model-viewer src="" alt="Render 3D del anillo" auto-rotate camera-controls ar style="width: 100%; height: 350px;"></model-viewer>
            <div class="no-render text-danger mt-2" style="display:none;">Render 3D no disponible aún.</div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal: Imagen final -->
    <div class="modal fade" id="imagenFinalModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title w-100 text-center">Imagen Final del Producto</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body text-center">
            <img src="" alt="Foto final del producto" class="img-fluid rounded">
            <div class="no-img text-danger mt-2" style="display:none;">Imagen final no disponible aún.</div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </main>



  <!-- Bootstrap JS y Model Viewer -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
  <!-- Script para el menú de usuario -->
  <script>
    const iconoUsuario = document.getElementById('icono-usuario');
    const menuUsuario = document.getElementById('menu-usuario');
    iconoUsuario.addEventListener('click', (e) => {
      e.stopPropagation();
      menuUsuario.classList.toggle('activo');
    });
    document.addEventListener('click', (e) => {
      if (!iconoUsuario.contains(e.target) && !menuUsuario.contains(e.target)) {
        menuUsuario.classList.remove('activo');
      }
    });
    // Inicialización de tooltips de Bootstrap para acciones
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
      new bootstrap.Tooltip(el);
    });
  </script>

  <script>
// Cargar pedidos dinámicamente
fetch('../php/usuario/listar_pedidos.php')
  .then(r => r.json())
  .then(pedidos => {
    const tbody = document.getElementById('tbody-pedidos');
    if (!pedidos.length) {
      tbody.innerHTML = '<tr><td colspan="5" class="text-center">No tienes pedidos registrados.</td></tr>';
      return;
    }
    tbody.innerHTML = '';
    pedidos.forEach((p, i) => {
      // Calcular progreso según est_id
      let progreso = 0;
      switch (parseInt(p.est_id)) {
        case 1: progreso = 30; break; // Diseño
        case 2: progreso = 60; break; // Producción
        case 3: progreso = 60; break; // Ensamblaje
        case 4: progreso = 80; break; // Envío
        case 5: progreso = 100; break; // Finalizado
        default: progreso = 10; // Confirmado u otro
      }
      let barra = `<div class='progress' style='height:20px;'>
        <div class='progress-bar' role='progressbar' style='width:${progreso}%;' aria-valuenow='${progreso}' aria-valuemin='0' aria-valuemax='100'>${progreso}%</div>
      </div>`;
      // Notificaciones "¡Nuevo!" solo si el usuario no ha visto el render/final
      let vistoRender = localStorage.getItem('visto_render_' + p.ped_id);
      let vistoFinal = localStorage.getItem('visto_final_' + p.ped_id);
      let badgeRender = (!vistoRender && p.render_3d) ? "<span class='badge bg-success ms-1'>¡Nuevo!</span>" : '';
      let badgeFinal = (!vistoFinal && p.imagen_final) ? "<span class='badge bg-success ms-1'>¡Nuevo!</span>" : '';
      let btn3d = p.render_3d ?
        `<button type='button' class='btn btn-outline-info btn-lg d-flex flex-column align-items-center justify-content-center px-2 py-1 fw-bold' data-bs-toggle='modal' data-bs-target='#render3DModal' data-render='${p.render_3d}' data-pedid='${p.ped_id}' title='Ver diseño 3D'><i class='bi bi-cube' style='font-size:1.5rem;'></i><span class='small'>3D</span>${badgeRender}</button>`
        : `<button type='button' class='btn btn-outline-info btn-lg d-flex flex-column align-items-center justify-content-center px-2 py-1' disabled title='No disponible'><i class='bi bi-cube' style='font-size:1.5rem;'></i><span class='small'>3D</span></button>`;
      let btnFinal = p.imagen_final ?
        `<button type='button' class='btn btn-outline-success btn-lg d-flex flex-column align-items-center justify-content-center px-2 py-1 fw-bold' data-bs-toggle='modal' data-bs-target='#imagenFinalModal' data-img='${p.imagen_final}' data-pedid='${p.ped_id}' title='Ver imagen final'><i class='bi bi-camera' style='font-size:1.5rem;'></i><span class='small'>Final</span>${badgeFinal}</button>`
        : `<button type='button' class='btn btn-outline-success btn-lg d-flex flex-column align-items-center justify-content-center px-2 py-1' disabled title='No disponible'><i class='bi bi-camera' style='font-size:1.5rem;'></i><span class='small'>Final</span></button>`;
      tbody.innerHTML += `
        <tr>
          <td>${p.ped_codigo}</td>
          <td>${p.ped_fecha_creacion}</td>
          <td>${p.est_nombre}</td>
          <td>${barra}</td>
          <td>
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#detallesPedidoModal' data-index='${i}'>Detalles</button>
            ${btn3d}
            ${btnFinal}
          </td>
        </tr>
      `;
    });
    window._pedidos = pedidos;
  });

// Modales dinámicos
const detallesModal = document.getElementById('detallesPedidoModal');
detallesModal.addEventListener('show.bs.modal', function (event) {
  const btn = event.relatedTarget;
  if (!btn) return;
  const index = btn.getAttribute('data-index');
  const pedido = window._pedidos[index];
  detallesModal.querySelector('.modal-title').textContent = `Detalles del Pedido ${pedido.ped_codigo}`;
  let html = '<ul class="list-group">';
  pedido.detalles.forEach(det => {
    html += `<li class='list-group-item'><strong>${det.opc_nombre}:</strong> ${det.val_nombre}</li>`;
  });
  html += '</ul>';
  html += `<div class='mt-3'><h6>Comentarios:</h6><p>${pedido.ped_comentarios || 'Sin comentarios.'}</p></div>`;
  html += `<div class='mt-3'><h6>Estado actual:</h6><p>${pedido.est_nombre}</p></div>`;
  detallesModal.querySelector('.modal-body').innerHTML = html;
});
const render3DModal = document.getElementById('render3DModal');
render3DModal.addEventListener('show.bs.modal', function (event) {
  const btn = event.relatedTarget;
  if (!btn) return;
  const src = btn.getAttribute('data-render');
  const pedid = btn.getAttribute('data-pedid');
  const viewer = render3DModal.querySelector('model-viewer');
  viewer.setAttribute('src', src ? '../' + src : '');
  render3DModal.querySelector('.no-render').style.display = src ? 'none' : 'block';
  // Marcar como visto el render
  if (src && pedid) localStorage.setItem('visto_render_' + pedid, '1');
});
const imagenFinalModal = document.getElementById('imagenFinalModal');
imagenFinalModal.addEventListener('show.bs.modal', function (event) {
  const btn = event.relatedTarget;
  if (!btn) return;
  const src = btn.getAttribute('data-img');
  const pedid = btn.getAttribute('data-pedid');
  const img = imagenFinalModal.querySelector('img');
  img.setAttribute('src', src ? '../' + src : '');
  imagenFinalModal.querySelector('.no-img').style.display = src ? 'none' : 'block';
  // Marcar como vista la imagen final
  if (src && pedid) localStorage.setItem('visto_final_' + pedid, '1');
});
  </script>

  <?php include '../includes/footer.php'; ?>
</body>
</html>