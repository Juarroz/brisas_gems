<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Portafolio de Inspiración | Brisas Gems</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap y estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --emerald-primary: #009b77;
      --emerald-dark: #007a5f;
      --emerald-light-bg: #f4f7f6;
      --card-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
      --border-radius: 0.75rem;
      --font-family-sans-serif: 'Poppins', sans-serif;
    }

    body {
      font-family: var(--font-family-sans-serif);
      background-color: var(--emerald-light-bg);
    }

    .btn-emerald {
      background-color: var(--emerald-primary);
      border-color: var(--emerald-primary);
      color: #fff;
      font-weight: 600;
    }
    .btn-emerald:hover {
      background-color: var(--emerald-dark);
      border-color: var(--emerald-dark);
      color: #fff;
    }

    .card {
      border: none;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
    }

    .card-header-custom {
      background-color: var(--emerald-primary);
      color: #fff;
      font-weight: 600;
      border-bottom: none;
    }
  </style>
</head>
<body>

  <header class="bg-white shadow-sm py-3 mb-4">
    <div class="container">
      <h1 class="h3 mb-0 fw-bold" style="color: var(--emerald-primary);">
        <i class="bi bi-images me-2"></i>Portafolio de Inspiración
      </h1>
    </div>
  </header>

  <main class="container">
    <div class="row g-4">

      <!-- FORMULARIO CREAR -->
      <aside class="col-lg-4">
        <section class="card sticky-top" style="top: 20px;">
          <header class="card-header card-header-custom">
            <h2 class="h5 mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Nueva Inspiración</h2>
          </header>
          <div class="card-body p-4">
            <?= (!empty($mensaje) && strpos($mensaje, 'creada') !== false) ? $mensaje : '' ?>
            <form method="POST" enctype="multipart/form-data">
              <input type="hidden" name="accion" value="crear">
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label">Título *</label>
                  <input type="text" name="porTitulo" class="form-control" required>
                </div>
                <div class="col-12">
                  <label class="form-label">Descripción *</label>
                  <textarea name="porDescripcion" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-12">
                  <label class="form-label">Imagen</label>
                  <input type="file" name="porImagen" class="form-control" accept="image/*">
                </div>
                <div class="col-12">
                  <label class="form-label">Video</label>
                  <input type="file" name="porVideo" class="form-control" accept="video/*">
                </div>
                <div class="col-12">
                  <label class="form-label">Categoría</label>
                  <input type="text" name="porCategoria" class="form-control">
                </div>
                <div class="col-12">
                  <label class="form-label">Usuario ID</label>
                  <input type="number" name="usuId" class="form-control">
                </div>
                <div class="col-12">
                  <button class="btn btn-emerald w-100" type="submit">
                    <i class="bi bi-check-circle me-2"></i>Crear Inspiración
                  </button>
                </div>
              </div>
            </form>
          </div>
        </section>
      </aside>

      <!-- LISTADO -->
      <section class="col-lg-8">
        <h2 class="h4 fw-bold mb-3">Inspiraciones Registradas</h2>
        <?= (!empty($mensaje) && strpos($mensaje, 'creada') === false) ? $mensaje : '' ?>

        <?php if (!empty($inspiraciones) && is_array($inspiraciones)): ?>
          <div class="accordion" id="accordionInspiraciones">
            <?php foreach ($inspiraciones as $item): 
              $id = htmlspecialchars((string)($item["por_id"] ?? ''));
              $collapseId = "collapse-{$id}";
            ?>
              <div class="accordion-item card mb-3">
                <h3 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>">
                    <span class="flex-grow-1">
                      <?= htmlspecialchars($item["porTitulo"] ?? '') ?>
                      <small class="text-muted fw-normal">(ID: <?= $id ?>)</small>
                    </span>
                    <small class="text-muted fw-normal me-3"><?= htmlspecialchars($item["porFecha"] ?? '') ?></small>
                  </button>
                </h3>
                <div id="<?= $collapseId ?>" class="accordion-collapse collapse" data-bs-parent="#accordionInspiraciones">
                  <div class="accordion-body">
                    <p class="border-start border-4 border-secondary-subtle ps-3 mb-4">
                      <?= nl2br(htmlspecialchars($item["porDescripcion"] ?? '')) ?>
                    </p>
                    <form method="POST" enctype="multipart/form-data" class="mt-3">
                      <input type="hidden" name="accion" value="actualizar">
                      <input type="hidden" name="id" value="<?= $id ?>">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label">Título</label>
                          <input class="form-control" type="text" name="porTitulo" value="<?= htmlspecialchars($item["porTitulo"] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Categoría</label>
                          <input class="form-control" type="text" name="porCategoria" value="<?= htmlspecialchars($item["porCategoria"] ?? '') ?>">
                        </div>
                        <div class="col-12">
                          <label class="form-label">Descripción</label>
                          <textarea class="form-control" name="porDescripcion" rows="3"><?= htmlspecialchars($item["porDescripcion"] ?? '') ?></textarea>
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Imagen</label>
                          <input class="form-control" type="file" name="porImagen" accept="image/*">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Video</label>
                          <input class="form-control" type="file" name="porVideo" accept="video/*">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Usuario ID</label>
                          <input class="form-control" type="number" name="usuId" value="<?= htmlspecialchars($item["usuId"] ?? '') ?>">
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2">
                          <form method="POST" onsubmit="return confirm('¿Eliminar esta inspiración?');" class="d-inline">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                              <i class="bi bi-trash-fill me-1"></i>Eliminar
                            </button>
                          </form>
                          <button type="submit" class="btn btn-sm btn-success">
                            <i class="bi bi-save-fill me-1"></i>Guardar
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="card card-body text-center">
            <p class="mb-0 text-muted">No hay inspiraciones registradas aún.</p>
          </div>
        <?php endif; ?>
      </section>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
