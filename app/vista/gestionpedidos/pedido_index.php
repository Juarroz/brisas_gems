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

        .badge-estado {
            font-size: 0.75em;
            padding: 0.35em 0.65em;
        }

        .nav-link.active {
            background-color: var(--emerald-primary) !important;
            border-color: var(--emerald-primary) !important;
            color: white !important;
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
        <!-- Navegación entre módulos -->
        <nav class="mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="?vista=pedidos">
                        <i class="bi bi-box-seam me-1"></i>Gestión de Pedidos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?vista=estados">
                        <i class="bi bi-tags me-1"></i>Gestión de Estados
                    </a>
                </li>
            </ul>
        </nav>

        <!-- DEBUG TEMPORAL - Eliminar después de verificar -->
        <div class="container mb-4">
            <div class="card">
                <div class="card-header bg-warning">
                    <h6 class="mb-0">DEBUG Info</h6>
                </div>
                <div class="card-body">
                    <p><strong>Total pedidos:</strong> <?= is_array($pedidos) ? count($pedidos) : '0' ?></p>
                    <p><strong>Backend URL:</strong> http://localhost:8080/api/pedidos</p>
                    <pre class="bg-light p-3 small"><?= htmlspecialchars(print_r($pedidos, true)) ?></pre>
                </div>
            </div>
        </div>

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
                                        <input id="pedCodigo" class="form-control" type="text" name="pedCodigo" required 
                                               placeholder="Ej: PED-001">
                                    </div>
                                    <small class="text-muted">Dejar vacío para generar automáticamente</small>
                                </div>
                                <div class="col-12">
                                    <label for="pedComentarios" class="form-label">Comentarios *</label>
                                    <textarea id="pedComentarios" class="form-control" name="pedComentarios" rows="3" 
                                              placeholder="Descripción del pedido..." required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label for="estId" class="form-label">Estado</label>
                                    <select id="estId" name="estId" class="form-select">
                                        <option value="">Seleccionar estado</option>
                                        <?php
                                        // Cargar estados dinámicamente
                                        require_once __DIR__ . '/../../modelo/gestionpedidos/EstadoPedidoService.php';
                                        $estadoService = new EstadoPedidoService();
                                        echo $estadoService->obtenerEstadosParaSelect();
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label for="perId" class="form-label">Personalización ID</label>
                                    <input id="perId" type="number" name="perId" class="form-control" 
                                           placeholder="ID de personalización">
                                </div>
                                <div class="col-md-12">
                                    <label for="usuId" class="form-label">Usuario ID</label>
                                    <input id="usuId" type="number" name="usuId" class="form-control" 
                                           placeholder="ID del usuario">
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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 id="listado-pedidos-heading" class="h4 fw-bold mb-0">Listado de Pedidos</h2>
                    <span class="badge bg-secondary"><?= is_array($pedidos) ? count($pedidos) : '0' ?> pedidos</span>
                </div>
                
                <?= (!empty($mensaje) && strpos($mensaje, 'creado') === false) ? $mensaje : '' ?>

                <?php if (is_array($pedidos) && !empty($pedidos) && !isset($pedidos['error'])): ?>
                    <div class="accordion" id="accordionPedidos">
                        <?php foreach ($pedidos as $p): 
                            $id = htmlspecialchars((string)($p["ped_id"] ?? ''));
                            $collapseId = "collapse-{$id}";
                            $estadoId = $p["estId"] ?? '';
                            $estadoNombre = $estadoService->obtenerNombreEstado($estadoId);
                        ?>
                            <div class="accordion-item card mb-3">
                                <h3 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="false" aria-controls="<?= $collapseId ?>">
                                        <span class="flex-grow-1">
                                            <?= htmlspecialchars($p["pedCodigo"] ?? '') ?> 
                                            <small class="text-muted fw-normal">(ID: <?= $id ?>)</small>
                                            <span class="badge bg-primary badge-estado ms-2"><?= htmlspecialchars($estadoNombre) ?></span>
                                        </span>
                                        <small class="text-muted fw-normal me-3">
                                            <?= !empty($p["pedFechaCreacion"]) ? date('d/m/Y', strtotime($p["pedFechaCreacion"])) : 'Sin fecha' ?>
                                        </small>
                                    </button>
                                </h3>
                                <div id="<?= $collapseId ?>" class="accordion-collapse collapse" data-bs-parent="#accordionPedidos">
                                    <div class="accordion-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <small class="text-muted">Fecha creación:</small><br>
                                                <strong><?= !empty($p["pedFechaCreacion"]) ? date('d/m/Y H:i', strtotime($p["pedFechaCreacion"])) : 'No disponible' ?></strong>
                                            </div>
                                            <div class="col-md-6">
                                                <small class="text-muted">Estado actual:</small><br>
                                                <strong><?= htmlspecialchars($estadoNombre) ?></strong>
                                            </div>
                                        </div>

                                        <p class="border-start border-4 border-primary ps-3 mb-4 py-2 bg-light">
                                            <strong>Comentarios:</strong><br>
                                            <?= nl2br(htmlspecialchars($p["pedComentarios"] ?? 'Sin comentarios')) ?>
                                        </p>
                                        
                                        <form method="POST">
                                            <input type="hidden" name="accion" value="actualizar">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Código *</label>
                                                    <input class="form-control" type="text" name="pedCodigo" 
                                                           value="<?= htmlspecialchars($p["pedCodigo"] ?? '') ?>" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Estado</label>
                                                    <select class="form-select form-select-sm" name="estId">
                                                        <option value="">Sin estado</option>
                                                        <?= $estadoService->obtenerEstadosParaSelect() ?>
                                                    </select>
                                                    <small class="text-muted">Actual: <?= htmlspecialchars($estadoNombre) ?></small>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label form-label-sm">Comentarios *</label>
                                                    <textarea class="form-control" name="pedComentarios" rows="3" required><?= htmlspecialchars($p["pedComentarios"] ?? '') ?></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Personalización ID</label>
                                                    <input class="form-control" type="number" name="perId" 
                                                           value="<?= htmlspecialchars($p["perId"] ?? '') ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label form-label-sm">Usuario ID</label>
                                                    <input class="form-control" type="number" name="usuId" 
                                                           value="<?= htmlspecialchars($p["usuId"] ?? '') ?>">
                                                </div>
                                                <div class="col-12 d-flex justify-content-end align-items-center gap-2 mt-3">
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="confirmarEliminacion(<?= $id ?>, '<?= htmlspecialchars($p["pedCodigo"] ?? '') ?>')">
                                                        <i class="bi bi-trash-fill me-1"></i>Eliminar
                                                    </button>
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
                    <div class="card card-body text-center py-5">
                        <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                        <p class="mb-0 text-muted">
                            <?php 
                            if (isset($pedidos['error'])) {
                                echo "<strong>Error:</strong> " . htmlspecialchars($pedidos['error']);
                            } else {
                                echo "Aún no hay pedidos registrados. Crea el primero usando el formulario.";
                            }
                            ?>
                        </p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <!-- Formulario oculto para eliminación -->
    <form id="formEliminar" method="POST" style="display: none;">
        <input type="hidden" name="accion" value="eliminar">
        <input type="hidden" name="id" id="eliminarId">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function confirmarEliminacion(id, codigo) {
            if (confirm(`¿Estás seguro de que deseas eliminar el pedido "${codigo}"? Esta acción no se puede deshacer.`)) {
                document.getElementById('eliminarId').value = id;
                document.getElementById('formEliminar').submit();
            }
        }

        // Navegación entre pestañas
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.classList.contains('active')) {
                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>