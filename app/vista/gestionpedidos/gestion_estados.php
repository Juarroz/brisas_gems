<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Gestión de Estados de Pedidos | Emerald</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --emerald-primary: #009b77;
            --emerald-dark: #007a5f;
            --emerald-light-bg: #f4f7f6;
        }

        body {
            background-color: var(--emerald-light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            border-radius: 0.75rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
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
                <i class="bi bi-tags-fill me-2"></i>Gestión de Estados de Pedidos
            </h1>
        </div>
    </header>

    <main class="container">
        <div class="row g-4">
            
            <!-- Formulario para crear estado -->
            <div class="col-lg-4">
                <section class="card">
                    <header class="card-header card-header-custom">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-plus-circle-fill me-2"></i>Crear Nuevo Estado
                        </h2>
                    </header>
                    <div class="card-body p-4">
                        <?= $mensaje ?>
                        <form method="POST">
                            <input type="hidden" name="accion" value="crear_estado">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Estado *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required 
                                       placeholder="Ej: En proceso, Completado, etc.">
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" 
                                          rows="3" placeholder="Descripción opcional del estado"></textarea>
                            </div>
                            <button type="submit" class="btn btn-emerald w-100">
                                <i class="bi bi-check-circle me-2"></i>Crear Estado
                            </button>
                        </form>
                    </div>
                </section>
            </div>

            <!-- Lista de estados existentes -->
            <div class="col-lg-8">
                <section class="card">
                    <header class="card-header card-header-custom">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-list-ul me-2"></i>Estados Existentes
                        </h2>
                    </header>
                    <div class="card-body p-4">
                        <?php if (is_array($estados) && !empty($estados) && !isset($estados['error'])): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($estados as $estado): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($estado['est_id'] ?? '') ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($estado['estNombre'] ?? '') ?></strong>
                                                </td>
                                                <td><?= htmlspecialchars($estado['estDescripcion'] ?? 'Sin descripción') ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary" 
                                                                onclick="editarEstado(<?= $estado['est_id'] ?>, '<?= htmlspecialchars($estado['estNombre'] ?? '') ?>', '<?= htmlspecialchars($estado['estDescripcion'] ?? '') ?>')">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger" 
                                                                onclick="eliminarEstado(<?= $estado['est_id'] ?>, '<?= htmlspecialchars($estado['estNombre'] ?? '') ?>')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">
                                    <?php 
                                    if (isset($estados['error'])) {
                                        echo "Error al cargar estados: " . htmlspecialchars($estados['error']);
                                    } else {
                                        echo "No hay estados registrados.";
                                    }
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Modal para editar estado -->
    <div class="modal fade" id="modalEditarEstado" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarEstado">
                        <input type="hidden" id="edit_estado_id" name="id">
                        <div class="mb-3">
                            <label for="edit_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit_descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-emerald" onclick="guardarCambiosEstado()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function editarEstado(id, nombre, descripcion) {
            document.getElementById('edit_estado_id').value = id;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_descripcion').value = descripcion || '';
            
            const modal = new bootstrap.Modal(document.getElementById('modalEditarEstado'));
            modal.show();
        }

        function eliminarEstado(id, nombre) {
            if (confirm(`¿Estás seguro de que deseas eliminar el estado "${nombre}"?`)) {
                alert('Funcionalidad de eliminación pendiente de implementar');
            }
        }

        function guardarCambiosEstado() {
            alert('Funcionalidad de guardar cambios pendiente de implementar');
        }
    </script>
</body>
</html>