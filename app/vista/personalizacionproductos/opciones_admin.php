<?php
/** @var array $opciones */
/** @var string|null $mensaje */

if (!function_exists('e')) {
  function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
?>
<?php include __DIR__ . '/../../includes/header.php'; ?>

<main class="container my-4">
  <h1 class="h4 mb-3">Catálogo · Opciones de personalización</h1>

  <?php if (!empty($mensaje)): ?>
    <div class="mb-3"><?= $mensaje ?></div>
  <?php endif; ?>

  <?php if (empty($opciones)): ?>
    <div class="alert alert-warning">No hay opciones para mostrar.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th class="text-nowrap">ID</th>
            <th>Nombre</th>
            <th>Slug</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($opciones as $opc): ?>
            <tr>
              <td class="text-nowrap"><?= e($opc['opc_id'] ?? $opc['id'] ?? '') ?></td>
              <td><?= e($opc['opc_nombre'] ?? $opc['nombre'] ?? '') ?></td>
              <td><?= e($opc['slug'] ?? '') ?></td>
              <td class="text-end">
                <!-- Próximo paso: rutas CRUD -->
                <!-- <a href="<?= BASE_URL ?>/admin/opciones/editar?id=<?= e($opc['opc_id'] ?? $opc['id']) ?>" class="btn btn-outline-secondary btn-sm">Editar</a>
                <form action="<?= BASE_URL ?>/admin/opciones/eliminar" method="post" class="d-inline">
                  <input type="hidden" name="id" value="<?= e($opc['opc_id'] ?? $opc['id']) ?>">
                  <button class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar esta opción?')">Eliminar</button>
                </form> -->
                <span class="text-muted">CRUD próximamente</span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/../../includes/footer.php'; ?>
