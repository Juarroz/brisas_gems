<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Usuarios</title>

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
            overflow: hidden;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--emerald-primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 155, 119, 0.25);
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--emerald-light-bg);
            color: var(--emerald-primary);
            box-shadow: none;
        }

        .alert-custom {
            background-color: #fff;
            border-left: 5px solid var(--emerald-primary);
            box-shadow: var(--card-shadow);
        }
    </style>
</head>
<body>

    <header class="bg-white shadow-sm py-3">
        <div class="container">
            <h1 class="h3 mb-0 fw-bold" style="color: var(--emerald-primary);">
                <i class="bi bi-people-fill me-2"></i>Gestión de Usuarios
            </h1>
        </div>
    </header>

    <main class="container py-4">

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-custom alert-dismissible fade show" role="alert">
                <?= $mensaje ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <section class="accordion mb-4" id="accordionFilters">
            <div class="accordion-item card">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                        <i class="bi bi-funnel-fill me-2"></i>Filtros de Búsqueda
                    </button>
                </h2>
                <div id="collapseFilters" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionFilters">
                    <div class="accordion-body">
                        <form method="GET">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="filterRol" class="form-label">Rol</label>
                                    <select id="filterRol" name="rolId" class="form-select">
                                        <option value="">(Todos)</option>
                                        <option value="1" <?= (($_GET['rolId'] ?? '') === '1') ? 'selected' : '' ?>>Usuario</option>
                                        <option value="2" <?= (($_GET['rolId'] ?? '') === '2') ? 'selected' : '' ?>>Administrador</option>
                                        <option value="3" <?= (($_GET['rolId'] ?? '') === '3') ? 'selected' : '' ?>>Diseñador</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="filterActivo" class="form-label">Estado</label>
                                    <select id="filterActivo" name="activo" class="form-select">
                                        <option value="">(Todos)</option>
                                        <option value="true" <?= (($_GET['activo'] ?? '') === 'true') ? 'selected' : '' ?>>Activo</option>
                                        <option value="false" <?= (($_GET['activo'] ?? '') === 'false') ? 'selected' : '' ?>>Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button type="submit" class="btn btn-emerald w-100"><i class="bi bi-search me-2"></i>Aplicar</button>
                                    <a href="./" class="btn btn-outline-secondary"><i class="bi bi-eraser"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5" aria-labelledby="listado-heading">
            <h2 id="listado-heading" class="h4 fw-bold mb-3">Listado de Usuarios</h2>
            <?php if (is_array($usuarios) && isset($usuarios["content"])): ?>
                <?php if (empty($usuarios["content"])): ?>
                    <div class="card card-body text-center">
                        <p class="mb-0 text-muted">No se encontraron usuarios con los filtros seleccionados.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($usuarios["content"] as $u): ?>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row g-3 align-items-center">
                                    <div class="col-lg-6">
                                        <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($u["nombre"] ?? '') ?></h5>
                                        <p class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($u["correo"] ?? '') ?></p>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge text-bg-primary"><?= htmlspecialchars($u["rolNombre"] ?? '') ?></span>
                                            <span class="badge <?= ($u["activo"] ? "text-bg-success" : "text-bg-secondary") ?>"><?= ($u["activo"] ? "Activo" : "Inactivo") ?></span>
                                            <span class="badge text-bg-info"><?= htmlspecialchars($u["origen"] ?? '') ?></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                                            <form method="POST" class="d-flex gap-2 align-items-center">
                                                <input type="hidden" name="accion" value="actualizar">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($u["id"] ?? '')) ?>">
                                                <select name="rolId" class="form-select form-select-sm" required style="min-width: 120px;">
                                                    <option value="1" <?= (($u["rolId"] ?? '') == 1) ? 'selected' : '' ?>>Usuario</option>
                                                    <option value="2" <?= (($u["rolId"] ?? '') == 2) ? 'selected' : '' ?>>Admin</option>
                                                    <option value="3" <?= (($u["rolId"] ?? '') == 3) ? 'selected' : '' ?>>Diseñador</option>
                                                </select>
                                                <select name="activo" class="form-select form-select-sm">
                                                    <option value="true" <?= ($u["activo"] ? 'selected' : '') ?>>Activo</option>
                                                    <option value="false" <?= (!$u["activo"] ? 'selected' : '') ?>>Inactivo</option>
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-save"></i></button>
                                            </form>
                                            <form method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                                <input type="hidden" name="accion" value="eliminar">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($u["id"] ?? '')) ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>No se pudo obtener la lista de usuarios desde la API.
                </div>
            <?php endif; ?>
        </section>

        <section aria-labelledby="crear-heading">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h2 id="crear-heading" class="h4 fw-bold mb-0">
                        <i class="bi bi-person-plus-fill me-2" style="color: var(--emerald-primary);"></i>Crear Nuevo Usuario
                    </h2>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <input type="hidden" name="accion" value="crear">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-4">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required maxlength="150">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="correo" class="form-label">Correo *</label>
                                <input type="email" id="correo" name="correo" class="form-control" required maxlength="100">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="password" class="form-label">Contraseña *</label>
                                <input type="password" id="password" name="password" class="form-control" required minlength="8">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" maxlength="20" placeholder="(Opcional)">
                            </div>
                             <div class="col-md-6 col-lg-4">
                                <label for="tipdocId" class="form-label">Tipo Documento</label>
                                <select id="tipdocId" name="tipdocId" class="form-select">
                                    <option value="">(Ninguno)</option>
                                    <option value="1">Cédula de ciudadanía</option>
                                    <option value="2">Cédula de extranjería</option>
                                    <option value="3">Pasaporte</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="docnum" class="form-label">Número Documento</label>
                                <input type="text" id="docnum" name="docnum" class="form-control" maxlength="20" placeholder="(Opcional)">
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="rolId" class="form-label">Rol *</label>
                                <select id="rolId" name="rolId" class="form-select" required>
                                    <option value="1">Usuario</option>
                                    <option value="2">Administrador</option>
                                    <option value="3">Diseñador</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="activo" class="form-label">Estado</label>
                                <select id="activo" name="activo" class="form-select">
                                    <option value="true">Activo</option>
                                    <option value="false" selected>Inactivo</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="origen" class="form-label">Origen</label>
                                <select id="origen" name="origen" class="form-select">
                                    <option value="registro">Registro</option>
                                    <option value="formulario" selected>Formulario</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-emerald px-4"><i class="bi bi-check-circle me-2"></i>Crear Usuario</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>