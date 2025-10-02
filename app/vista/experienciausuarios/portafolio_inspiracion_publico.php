<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inspiraciones</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f3;
      margin: 0;
      padding: 20px;
    }

    .main-content {
      max-width: 1200px;
      margin: auto;
    }

    .portafolio h3 {
      color: #065f46;
      margin-bottom: 20px;
      text-align: center;
    }

    #contenedor-inspiraciones {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 40px; /* espacio claro entre cartas */
    }

    .carta {
      perspective: 1000px;
      height: 340px;
      position: relative;
      margin: 10px; /* refuerzo extra de separación */
    }

    .carta-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.6s;
      transform-style: preserve-3d;
      border-radius: 12px;
    }

    .carta:hover .carta-inner {
      transform: rotateY(180deg);
    }

    .card-body {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      backface-visibility: hidden;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.15);
      background: #fff;
      box-sizing: border-box; /* asegura que el padding no altere tamaño */
    }

    .frente {
      transform: rotateY(0deg);
    }

    .atras {
      transform: rotateY(180deg);
      color: #064e3b;
    }

    .card-img-container {
      width: 100%;
      height: 160px;
      overflow: hidden;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .card-img-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .card-title {
      margin: 8px 0;
      font-size: 16px;
      color: #065f46;
    }

    .card-text {
      font-size: 14px;
      color: #374151;
    }

    ul {
      font-size: 13px;
      line-height: 1.5;
      padding-left: 18px;
    }

    ul li {
      margin-bottom: 4px;
    }

    .text-center {
      text-align: center;
      color: #6b7280;
    }
  </style>
</head>
<body>
  <div class="main-content">
    <div class="portafolio">
      <h3><strong>CREACIONES DESTACADAS</strong></h3>
      <div id="contenedor-inspiraciones">
        <?php if (!empty($inspiraciones) && is_array($inspiraciones)): ?>
          <?php foreach ($inspiraciones as $insp): ?>
            <div class="carta">
              <div class="carta-inner">
                <!-- Frente -->
                <div class="card-body frente">
                  <div class="card-img-container">
                    <img src="<?= htmlspecialchars($insp['porImagen']) ?>" alt="Imagen Inspiración">
                  </div>
                  <h5 class="card-title"><strong><?= htmlspecialchars($insp['porTitulo']) ?></strong></h5>
                  <p class="card-text"><?= htmlspecialchars($insp['porDescripcion']) ?></p>
                </div>
                <!-- Atrás -->
                <div class="card-body atras">
                  <h5 class="card-title"><strong>Detalles del Diseño</strong></h5>
                  <ul class="list-unstyled">
                    <li>○ Categoría: <?= htmlspecialchars($insp['porCategoria']) ?></li>
                    <li>○ Fecha: <?= htmlspecialchars($insp['porFecha'] ?? 'N/A') ?></li>
                    <li>○ Usuario: <?= htmlspecialchars($insp['usuId'] ?? 'Anónimo') ?></li>
                    <?php if (!empty($insp['porVideo'])): ?>
                      <li>○ Video: <a href="<?= htmlspecialchars($insp['porVideo']) ?>" target="_blank">Ver</a></li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-center">No hay inspiraciones registradas aún.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>
