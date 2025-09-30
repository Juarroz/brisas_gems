<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>:root { --bs-primary: #009688; } body { background-color: #f8f9fa; } .navbar { background-color: var(--bs-primary); }</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">Mi Aplicación</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="/usuarios">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="/pedidos">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/personalizaciones">Personalizaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="/contactos">Contacto</a></li>
                </ul>
                <ul class="navbar-nav ms-auto"><li class="nav-item"><a class="btn btn-outline-light" href="/logout">Cerrar Sesión</a></li></ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['flash_message']['text']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['flash_message']); endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Usuarios Activos</h1>
                <a href="/usuarios/inactivos" class="btn btn-secondary btn-sm">Ver Inactivos</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark"><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr></thead>
                        <tbody>
                            <?php if (isset($usuarios) && !empty($usuarios)): foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['rolNombre']); ?></td>
                                <td>
                                    <a href="/usuarios/editar?id=<?php echo $usuario['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                    <form action="/usuarios/cambiar-estado" method="POST" style="display:inline-block; margin-left: 5px;">
                                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                        <input type="hidden" name="estado" value="0">
                                        <button type="submit" class="btn btn-warning btn-sm">Desactivar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-center">No hay usuarios activos para mostrar.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>