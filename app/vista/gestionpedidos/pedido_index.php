<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gestión de Pedidos | Emerald</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --emerald-primary: #009b77;
            --emerald-dark: #007a5f;
            --emerald-light-bg: #f4f7f6;
            --text-dark: #212529;
            --text-light: #6c757d;
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

        .form-control:focus, .form-select:focus {
            border-color: var(--emerald-primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 155, 119, 0.25);
        }

        .card-header-custom {
            background-color: var(--emerald-primary);
            color: #fff;
            font-weight: 600;
            border-bottom: none;
        }
        
        .accordion-button {
            font-weight: 600;
        }
        .accordion-button:not(.collapsed) {
            background-color: var(--emerald-light-bg);
            color: var(--emerald-primary);
            box-shadow: inset 0 -1px 0 rgba(0,0,0,.125);
        }
    </style>
</head>
<body>

    <header class="bg-white shadow-sm py-3 mb-4">
        <div class="container">
            <h1 class="h3 mb-0 fw-bold" style="color: var(--emerald-primary);">
                <i class="bi bi-box-seam-fill me-2"></i>Gestión de Pedidos
            </h1>
        </div>
    </header>

    <main class="container">
        <div class="row g-4">
            
            <aside class="col-lg-4">
                <section class="card sticky-top" style="top: 20px;" aria-labelledby="crear-pedido-heading">
                    <header class="card-header card-header-custom">
                        <h2 class="h5 mb-0" id="crear-pedido-heading">
                            <i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Pedido
                        </h2>
                    </header>
                    <div class="card-body p-4">
                        <?= (!empty($mensaje) && strpos($mensaje, 'creado') !== false) ? $mensaje : '' ?>
                        <form method="POST">
                            <input type="hidden" name="accion" value="crear">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="pedCodigo" class="form-label">Código *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                                        <input id="pedCodigo" class="form-control" type="text" name="pedCodigo" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="pedComentarios" class="form-label">Comentarios *</label>
                                    <textarea id="pedComentarios" class="form-control" name="pedComentarios" rows="3" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="estId" class="form-label">Estado ID</label>
                                    <input id="estId" type="number" name="estId" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for="perId" class="form-label">Personalización ID</label>
                                    <input id="perId" type="number" name="perId" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for="usuId" class="form-label">Usuario ID</label>
                                    <input id="usuId" type="number" name="usuId" class="form-control">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-emerald w-100" type="submit">
                                        <i class="bi bi-check-circle me-2"></i>Crear Pedido
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </aside>

            <section class="col-lg-8" aria-labelledby="listado-pedidos-heading">
                <h2 id="listado-pedidos-heading" class="h4 fw-bold mb-3">Listado de Pedidos</h2>
                <?= (!empty($mensaje) && strpos($mensaje, 'creado') === false) ? $mensaje : '' ?>

                <?php if (!empty($pedidos)): ?>
                    <div class="accordion" id="accordionPedidos">
                        <?php foreach ($pedidos as $p): 
                            $id = htmlspecialchars((string)($p["ped_id"] ?? ''));
                            $collapseId = "collapse-{$id}";
                        ?>
                            <div class="accordion-item card mb-3">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">
                                        <span class="flex-grow-1">
                                            <?= htmlspecialchars($p["pedCodigo"] ?? '') ?> 
                                            <small class="text-muted fw-normal">(ID: <?= $id ?>)</small>
                                        </span>
                                        <small class="text-muted fw-normal me-3"><?= htmlspecialchars($p["pedFechaCreacion"] ?? '') ?></small>
                                    </button>
                                </h3>
                                <div id="<?= $collapseId ?>" class="accordion-collapse collapse" data-bs-parent="#accordionPedidos">
                                    <div class="accordion-body">
                                        <p class="border-start border-4 border-secondary-subtle ps-3 mb-4">
                                            <?= nl2br(htmlspecialchars($p["pedComentarios"] ?? '')) ?>
                                        </p>
                                        <form method="POST">
                                            <input type="hidden" name="accion" value="actualizar">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Código</label>
                                                    <input class="form-control" type="text" name="pedCodigo" value="<?= htmlspecialchars($p["pedCodigo"] ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Estado ID</label>
                                                    <input class="form-control" type="number" name="estId" value="<?= htmlspecialchars($p["estId"] ?? '') ?>">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label form-label-sm">Comentarios</label>
                                                    <textarea class="form-control" name="pedComentarios" rows="3" required><?= htmlspecialchars($p["pedComentarios"] ?? '') ?></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Personalización ID</label>
                                                    <input class="form-control" type="number" name="perId" value="<?= htmlspecialchars($p["perId"] ?? '') ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Usuario ID</label>
                                                    <input class="form-control" type="number" name="usuId" value="<?= htmlspecialchars($p["usuId"] ?? '') ?>">
                                                </div>
                                                <div class="col-12 d-flex justify-content-end align-items-center gap-2 mt-3">
                                                    <form method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este pedido?');" class="d-inline">
                                                        <input type="hidden" name="accion" value="eliminar">
                                                        <input type="hidden" name="id" value="<?= $id ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash-fill me-1"></i>Eliminar
                                                        </button>
                                                    </form>
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-save-fill me-1"></i>Guardar Cambios
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
                        <p class="mb-0 text-muted">Aún no hay pedidos registrados.</p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>