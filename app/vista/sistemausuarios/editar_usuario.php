<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="<?= BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="<?= BASE_URL ?>/assets/icons/icono.png" />
    <style>
        :root { --bs-primary: #009688; }
        body { background-color: #f8f9fa; }
        .navbar { background-color: var(--bs-primary); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard">Brisas Gems</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="<?= BASE_URL ?>/usuarios">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pedidos">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/personalizar">Personalizaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/contactos">Contacto</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="btn btn-outline-light" href="<?= BASE_URL ?>/logout">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white"><h1 class="h3 mb-0">Editar Usuario</h1></div>
            <div class="card-body">
                <?php if (isset($usuario) && $usuario): ?>
                    <form action="<?= BASE_URL ?>/usuarios/actualizar" method="POST">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']); ?>">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($usuario['correo']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['telefono'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="rolId" class="form-label">Rol</label>
                            <select name="rolId" id="rolId" class="form-select">
                                <?php if (isset($roles) && !empty($roles)): foreach ($roles as $rol): ?>
                                    <option value="<?= htmlspecialchars($rol['id']); ?>" <?= ($rol['id'] == $usuario['rolId']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($rol['nombre']); ?>
                                    </option>
                                <?php endforeach; else: ?>
                                    <option value="">No se pudieron cargar los roles</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <a href="<?= BASE_URL ?>/usuarios" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert"><?= $error_message ?? "No se pudo cargar la información del usuario."; ?></div>
                    <a href="<?= BASE_URL ?>/usuarios" class="btn btn-primary">Volver a la lista</a>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
