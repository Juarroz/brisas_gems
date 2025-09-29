<?php
/** @var array $valores */
/** @var array $opciones */
/** @var int|null $opcId */
/** @var string|null $mensaje */

if (!function_exists('e')) {
  function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}
?>
<?php include __DIR__ . '/../../includes/header.php'; ?>

<main class="container my-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h4 mb-0">Catálogo · Valores</h1>
    <form class="d-flex gap-2" method="get" action="<?= BASE_URL ?>/admin/valores">
      <select name="opc_id" class="form-select form-select-sm" style="min-width: 220px;">
        <option value="">— Filtrar por opción —</option>
        <?php foreach ($opciones as $o): 
          $id   = (int)($o['opc_id'] ?? $o['id']);
          $name = (string)($o['opc_nombre'] ?? $o['nombre'] ?? '');
          $sel  = ($opcId && $id === (int)$opcId) ? 'selected' : '';
        ?>
          <option value="<?= e($id) ?>" <?= $sel ?>><?= e($name) ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn btn-primary btn-sm">Filtrar</button>
      <?php if ($opcId): ?>
        <a class="btn btn-outline-secondary btn-sm" href="<?= BASE_URL ?>/admin/valores">Limpiar</a>
      <?php endif; ?>
    </form>
  </div>

  <?php if (!empty($mensaje)): ?>
    <div class="mb-3"><?= $mensaje ?></div>
  <?php endif; ?>

  <?php if (empty($valores)): ?>
    <div class="alert alert-warning">No hay valores para mostrar.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead class="table-light">
          <tr>
            <th class="text-nowrap">ID</th>
            <th>Valor</th>
            <th class="text-nowrap">Opción</th>
            <th>Imagen</th>
            <th class="text-end">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($valores as $v): 
            $idVal   = $v['val_id'] ?? $v['id'] ?? '';
            $nombre  = $v['val_nombre'] ?? $v['nombre'] ?? '';
            $img     = $v['val_imagen'] ?? $v['imagen'] ?? '';
            $opcionId= $v['opc_id'] ?? null;
          ?>
            <tr>
              <td class="text-nowrap"><?= e($idVal) ?></td>
              <td><?= e($nombre) ?></td>
              <td class="text-nowrap"><?= e($opcionId) ?></td>
              <td>
                <?php if ($img): ?>
                  <img src="<?= e($img) ?>" alt="<?= e($nombre) ?>" style="max-width:80px; max-height:50px; object-fit:contain;">
                <?php else: ?>
                  <span class="text-muted">—</span>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <!-- Próximo paso: rutas CRUD -->
                <!-- <a href="<?= BASE_URL ?>/admin/valores/editar?id=<?= e($idVal) ?>" class="btn btn-outline-secondary btn-sm">Editar</a>
                <form action="<?= BASE_URL ?>/admin/valores/eliminar" method="post" class="d-inline">
                  <input type="hidden" name="id" value="<?= e($idVal) ?>">
                  <button class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Eliminar este valor?')">Eliminar</button>
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
