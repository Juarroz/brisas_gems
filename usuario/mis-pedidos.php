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
          <tbody>
            <!-- Fila de ejemplo (debe poblarse dinámicamente desde backend) -->
            <tr>
              <td>BRG-0001</td>
              <td>2025-06-20</td>
              <td>En producción</td>
              <td>
                <div class="progress" style="height: 1rem;">
                  <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
              </td>
              <td>
                <div class="btn-group acciones-pedido" role="group" aria-label="Acciones del pedido">
                  <button type="button" class="btn btn-outline-primary btn-lg d-flex flex-column align-items-center justify-content-center px-2 py-1" data-bs-toggle="modal" data-bs-target="#detallesPedidoModal" title="Ver detalles" aria-label="Ver detalles" data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="bi bi-list" style="font-size:1.5rem;"></i>
                    <span class="small">Detalle</span>
                  </button>
                  <button type="button" class="btn btn-outline-info btn-lg d-flex flex-column align-items-center justify-content-center px-2 py-1" data-bs-toggle="modal" data-bs-target="#render3DModal" title="Ver diseño 3D" aria-label="Ver diseño 3D" data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="bi bi-cube" style="font-size:1.5rem;"></i>
                    <span class="small">3D</span>
                  </button>
                  <button type="button" class="btn btn-outline-success btn-lg d-flex flex-column align-items-center justify-content-center px-2 py-1" data-bs-toggle="modal" data-bs-target="#imagenFinalModal" title="Ver imagen final" aria-label="Ver imagen final" data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="bi bi-camera" style="font-size:1.5rem;"></i>
                    <span class="small">Final</span>
                  </button>
                </div>
              </td>
            </tr>
            <!-- /fila de ejemplo -->
          </tbody>
        </table>
      </div>
    </section>

    <!-- Modal: Detalles del pedido -->
    <div class="modal fade" id="detallesPedidoModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title w-100 text-center">Detalles del Pedido BRG-0001</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <ul class="list-group">
              <li class="list-group-item"><strong>Gema:</strong> Rubí</li>
              <li class="list-group-item"><strong>Forma:</strong> Redonda</li>
              <li class="list-group-item"><strong>Metal:</strong> Oro Blanco</li>
            </ul>
            <div class="mt-3">
              <h6>Comentarios:</h6>
              <p>Por favor incluir el estuche de terciopelo rojo.</p>
            </div>
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
            <!-- Ajuste de ruta para Go Live: usa ruta absoluta desde la raíz del servidor local -->
            <model-viewer src="/img/progreso-pedido/metaretail-anillo-simple/anillo.glb" alt="Render 3D del anillo" auto-rotate camera-controls ar style="width: 100%; height: 350px;"></model-viewer>
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
            <img src="../img/progreso-pedido/vista previa 1.jpg" alt="Foto final del producto" class="img-fluid rounded">
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

  <?php include '../includes/footer.php'; ?>
</body>
</html>