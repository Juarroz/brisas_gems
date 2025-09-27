<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Formularios | Emerald</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --emerald-primary: #009b77;
            --emerald-dark: #007a5f;
            --emerald-light-bg: #f8f9fa;
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
        
        /* Estilos para la interfaz tipo bandeja de entrada */
        .inbox-layout {
            display: flex;
            gap: 1.5rem;
            min-height: 80vh;
        }
        .inbox-sidebar {
            width: 320px;
            flex-shrink: 0;
        }
        .inbox-content {
            flex-grow: 1;
        }
        .nav-pills .nav-link {
            text-align: left;
            margin-bottom: 0.5rem;
            border: 1px solid #dee2e6;
            color: #495057;
        }
        .nav-pills .nav-link.active {
            background-color: var(--emerald-primary);
            color: #fff;
            border-color: var(--emerald-primary);
        }
        .nav-pills .nav-link:hover {
            background-color: #e9ecef;
        }
        .nav-pills .nav-link.active:hover {
            background-color: var(--emerald-dark);
        }
    </style>
</head>
<body>

    <header class="bg-white shadow-sm py-3 mb-4 sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0 fw-bold" style="color: var(--emerald-primary);">
                <i class="bi bi-envelope-paper-fill me-2"></i>Gestión de Formularios
            </h1>
            <button class="btn btn-emerald" data-bs-toggle="modal" data-bs-target="#createContactModal">
                <i class="bi bi-plus-circle me-2"></i>Añadir Contacto
            </button>
        </div>
    </header>

    <main class="container">
        
        <?= $mensaje ?? '' ?>

        <div class="row">
            <aside class="col-lg-4">
                <div class="accordion mb-3" id="accordionFilters">
                    <div class="accordion-item card shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters">
                                <i class="bi bi-funnel-fill me-2"></i>Filtros
                            </button>
                        </h2>
                        <div id="collapseFilters" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <form method="GET">
                                    <div class="mb-3"><label>Vía</label><select name="via" class="form-select"><option value="">(todas)</option><option value="formulario" <?= (($_GET['via'] ?? '')==='formulario')?'selected':'' ?>>Formulario</option><option value="whatsapp" <?= (($_GET['via'] ?? '')==='whatsapp')?'selected':'' ?>>WhatsApp</option></select></div>
                                    <div class="mb-3"><label>Estado</label><select name="estado" class="form-select"><option value="">(todos)</option><option value="pendiente" <?= (($_GET['estado'] ?? '')==='pendiente')?'selected':'' ?>>Pendiente</option><option value="atendido" <?= (($_GET['estado'] ?? '')==='atendido')?'selected':'' ?>>Atendido</option><option value="archivado" <?= (($_GET['estado'] ?? '')==='archivado')?'selected':'' ?>>Archivado</option></select></div>
                                    <div class="d-flex gap-2"><button type="submit" class="btn btn-sm btn-primary w-100">Aplicar</button><a href="./" class="btn btn-sm btn-outline-secondary">Limpiar</a></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <?php if (is_array($contactos) && !empty($contactos)): ?>
                        <?php foreach ($contactos as $index => $c): 
                            $id = htmlspecialchars((string)($c["id"] ?? ''));
                            $estadoClase = '';
                            switch ($c["estado"] ?? '') {
                                case 'atendido': $estadoClase = 'success'; break;
                                case 'archivado': $estadoClase = 'secondary'; break;
                                default: $estadoClase = 'warning';
                            }
                        ?>
                            <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="v-pills-contact-<?= $id ?>-tab" data-bs-toggle="pill" data-bs-target="#v-pills-contact-<?= $id ?>" type="button" role="tab">
                                <div class="d-flex w-100 justify-content-between">
                                    <strong class="mb-1"><?= htmlspecialchars($c["nombre"] ?? '') ?></strong>
                                    <small><?= htmlspecialchars($c["fechaEnvio"] ?? '') ?></small>
                                </div>
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <p class="mb-1 small text-muted text-truncate"><?= htmlspecialchars($c["mensaje"] ?? '') ?></p>
                                    <span class="badge text-bg-<?= $estadoClase ?> ms-2"><?= ucfirst($c["estado"] ?? '') ?></span>
                                </div>
                            </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </aside>

            <div class="col-lg-8">
                <div class="tab-content" id="v-pills-tabContent">
                    <?php if (is_array($contactos)): ?>
                        <?php if (empty($contactos)): ?>
                            <div class="card card-body text-center"><p class="mb-0">No hay contactos para los filtros seleccionados.</p></div>
                        <?php else: ?>
                            <?php foreach ($contactos as $index => $c): 
                                $id = htmlspecialchars((string)($c["id"] ?? ''));
                            ?>
                                <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="v-pills-contact-<?= $id ?>" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-0"><?= htmlspecialchars($c["nombre"] ?? '') ?></h5>
                                                <small class="text-muted">
                                                    <i class="bi bi-envelope"></i> <?= htmlspecialchars($c["correo"] ?? 'N/A') ?> 
                                                    <i class="bi bi-phone ms-2"></i> <?= htmlspecialchars($c["telefono"] ?? 'N/A') ?>
                                                </small>
                                            </div>
                                            <span class="badge text-bg-info"><?= ucfirst($c["via"] ?? '') ?></span>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-2 text-muted">Mensaje:</h6>
                                            <p class="border-start border-4 ps-3 mb-4"><?= nl2br(htmlspecialchars($c["mensaje"] ?? '')) ?></p>
                                            
                                            <?php if (!empty($c["notas"])): ?>
                                                <h6 class="card-subtitle mb-2 text-muted">Notas de seguimiento:</h6>
                                                <p class="border-start border-4 border-warning-subtle bg-warning-light ps-3 p-2 rounded">
                                                    <?= nl2br(htmlspecialchars($c["notas"])) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-light">
                                            <form method="POST" class="row g-2 align-items-end">
                                                <input type="hidden" name="accion" value="actualizar"><input type="hidden" name="id" value="<?= $id ?>">
                                                <div class="col-md-4"><label class="form-label form-label-sm">Cambiar Estado</label><select name="estado" class="form-select form-select-sm" required><option value="pendiente" <?= (($c["estado"] ?? '')==='pendiente')?'selected':'' ?>>Pendiente</option><option value="atendido" <?= (($c["estado"] ?? '')==='atendido')?'selected':'' ?>>Atendido</option><option value="archivado" <?= (($c["estado"] ?? '')==='archivado')?'selected':'' ?>>Archivado</option></select></div>
                                                <div class="col-md-8"><label class="form-label form-label-sm">Añadir/Editar Notas</label><textarea name="notas" class="form-control form-control-sm" rows="1" maxlength="500"><?= htmlspecialchars($c["notas"] ?? '') ?></textarea></div>
                                                <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                                    <form method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este contacto?');"><input type="hidden" name="accion" value="eliminar"><input type="hidden" name="id" value="<?= $id ?>"><button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button></form>
                                                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-save me-1"></i> Guardar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-danger"><p style="color:red;">No se pudo obtener la lista desde la API.</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="createContactModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST">
                    <input type="hidden" name="accion" value="crear">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Nuevo Contacto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12"><label class="form-label">Nombre *</label><input type="text" name="nombre" class="form-control" required maxlength="150"></div>
                            <div class="col-md-6"><label class="form-label">Correo</label><input type="email" name="correo" class="form-control" maxlength="100" placeholder="(Opcional)"></div>
                            <div class="col-md-6"><label class="form-label">Teléfono</label><input type="text" name="telefono" class="form-control" maxlength="30" placeholder="(Opcional)"></div>
                            <div class="col-12"><label class="form-label">Mensaje *</label><textarea name="mensaje" class="form-control" required rows="4"></textarea></div>
                            <div class="col-md-6"><label class="form-label">Vía</label><select name="via" class="form-select"><option value="formulario">Formulario</option><option value="whatsapp">WhatsApp</option></select></div>
                            <div class="col-12 form-check mb-3 ms-2"><input type="checkbox" name="terminos" value="1" class="form-check-input" required id="terminosCheck"><label class="form-check-label" for="terminosCheck">Acepto los términos</label></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-emerald">Crear Contacto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>