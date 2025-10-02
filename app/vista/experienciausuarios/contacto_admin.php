<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contactos</title>
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
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/usuarios">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pedidos">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/personalizar">Personalizaciones</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= BASE_URL ?>/admin/contactos">Contactos</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="btn btn-outline-light" href="<?= BASE_URL ?>/logout">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Gestión de Contactos</h1>
            </div>
            <div class="card-body">
                <?php if (!empty($mensaje)): ?>
                    <?= $mensaje ?>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Mensaje</th>
                                <th>Estado</th>
                                <th>Notas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($contactos)): foreach ($contactos as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['id']) ?></td>
                                    <td><?= htmlspecialchars($c['nombre']) ?></td>
                                    <td><?= htmlspecialchars($c['correo']) ?></td>
                                    <td><?= htmlspecialchars($c['telefono']) ?></td>
                                    <td><?= htmlspecialchars($c['mensaje']) ?></td>
                                    <td><?= htmlspecialchars($c['estado']) ?></td>
                                    <td><?= htmlspecialchars($c['notas'] ?? '') ?></td>
                                    <td class="d-flex gap-1">
                                        <!-- Actualizar -->
                                        <form action="<?= BASE_URL ?>/admin/contactos/update" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                            <select name="estado" class="form-select">
                                                <option value="pendiente" <?= ($c['estado'] === 'pendiente') ? 'selected' : '' ?>>Pendiente</option>
                                                <option value="atendido"  <?= ($c['estado'] === 'atendido')  ? 'selected' : '' ?>>Atendido</option>
                                                <option value="archivado" <?= ($c['estado'] === 'archivado') ? 'selected' : '' ?>>Archivado</option>
                                            </select>
                                            <input type="text" name="notas" class="form-control form-control-sm" placeholder="Notas" value="<?= htmlspecialchars($c['notas'] ?? '') ?>">
                                            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                                        </form>

                                        <!-- Eliminar -->
                                        <form action="<?= BASE_URL ?>/admin/contactos/delete" method="POST" onsubmit="return confirm('¿Eliminar este contacto?');">
                                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay contactos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
