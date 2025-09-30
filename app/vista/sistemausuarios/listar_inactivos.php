<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Inactivos</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
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
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0">Usuarios Inactivos</h1>
                <a href="/usuarios" class="btn btn-primary btn-sm">Ver Activos</a>
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
                                    <form action="/usuarios/cambiar-estado" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                        <input type="hidden" name="estado" value="1">
                                        <button type="submit" class="btn btn-success btn-sm">Activar</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="5" class="text-center">No hay usuarios inactivos para mostrar.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>