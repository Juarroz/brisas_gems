<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Contacto para asesoría personalizada en Brisas Gems. Solicita información, personaliza tu joya o resuelve dudas. Atención por formulario o WhatsApp.">
  <meta name="author" content="Brisas Gems">
  <link rel="icon" href="../brisas_gems/img/icono.png">
  <title>Contacto | Brisas Gems</title>
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/assets/css-global/main.css">
  <link rel="stylesheet" href="./css/contacto.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main class="container my-5">
  <div class="row">
    <!-- Formulario de contacto -->
    <div class="col-md-6 mb-4">
      <section>
        <h2 class="mb-4"><i class="fas fa-envelope me-2"></i>Formulario de Contacto</h2>

        <form id="formulario-contacto" class="needs-validation" novalidate>
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre completo*</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" required aria-label="Nombre completo">
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico*</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Ej: juan@gmail.com" required aria-label="Correo electrónico">
          </div>

          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono (WhatsApp)</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej: 3001234567" aria-label="Teléfono">
            <small class="form-text text-muted">Opcional, solo si deseas atención más rápida.</small>
          </div>

          <div class="mb-3">
            <label for="asunto" class="form-label">Asunto*</label>
            <select class="form-select" id="asunto" name="asunto" required aria-label="Selecciona el asunto">
              <option value="">Seleccione un asunto...</option>
              <option value="personalizacion">Personalización de joya</option>
              <option value="seguimiento">Seguimiento de pedido</option>
              <option value="pago">Consulta sobre pago</option>
              <option value="otro">Otro</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje*</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="5" required aria-label="Mensaje"></textarea>
          </div>

          <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="terminos" name="terminos" required>
            <label class="form-check-label" for="terminos">
              He leído y acepto los <a href="#" id="ver-terminos">Términos y Condiciones</a>
            </label>
          </div>

          <input type="hidden" name="via" value="formulario">

          <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-paper-plane me-2"></i>Enviar formulario
          </button>
        </form>
      </section>
    </div>

    <!-- Segunda columna: Resumen + WhatsApp -->
    <div class="col-md-6">
      <section>
        <h2 class="mb-3"><i class="fas fa-gem me-2"></i>Resumen de tu personalización</h2>
        <ul class="list-group mb-4" id="resumen-personalizacion">
          <li class="list-group-item d-flex justify-content-between"><strong>Piedra:</strong> <span id="res-gema">No seleccionado</span></li>
          <li class="list-group-item d-flex justify-content-between"><strong>Forma:</strong> <span id="res-forma">No seleccionada</span></li>
          <li class="list-group-item d-flex justify-content-between"><strong>Tamaño (mm):</strong> <span id="res-tamano">No definido</span></li>
          <li class="list-group-item d-flex justify-content-between"><strong>Material:</strong> <span id="res-material">No seleccionado</span></li>
          <li class="list-group-item d-flex justify-content-between"><strong>Talla del anillo:</strong> <span id="res-talla">No definida</span></li>
        </ul>

        <h2 class="mb-3"><i class="fab fa-whatsapp me-2"></i>Contacto por WhatsApp</h2>
        <p>Para una atención más inmediata, contáctanos directamente por WhatsApp:</p>
        <a href="https://wa.me/573001234567?text=Hola%20Brisas%20Gems,%20tengo%20una%20consulta" class="btn btn-success w-100" id="boton-whatsapp" disabled>
          <i class="fab fa-whatsapp me-2"></i>Chatear con soporte
        </a>
        <small class="text-muted d-block mt-2">*Disponible después de enviar el formulario de contacto</small>
      </section>
    </div>    
</main>

<!-- Modal de Términos -->
<div class="modal-terminos" id="modalTerminos">
  <div class="contenido-modal">
    <span class="cerrar-modal">&times;</span>
    <h3>Términos y Condiciones</h3>
    <div class="contenido-terminos">
      <p>1. Al enviar este formulario, acepta que Brisas Gems almacene y procese su información para atender su consulta.</p>
      <p>2. Nos comprometemos a responder en un plazo máximo de 48 horas hábiles.</p>
      <p>3. La información proporcionada será tratada con confidencialidad según nuestra política de privacidad.</p>
      <p>4. El servicio de WhatsApp está disponible de lunes a viernes de 9:00 am a 6:00 pm.</p>
      <p>5. Brisas Gems se reserva el derecho de no responder consultas que no cumplan con las normas de respeto y educación.</p>
    </div>
    <button class="btn btn-primary w-100 mt-3 boton-aceptar-terminos">Aceptar términos</button>
  </div>
</div>

<script src="../js/comunicacion-soporte.js"></script>

<!-- Menú de usuario -->
<script>
const iconoUsuario = document.getElementById('icono-usuario');
const menuUsuario = document.getElementById('menu-usuario');

iconoUsuario?.addEventListener('click', () => {
  menuUsuario?.classList.toggle('activo');
});

document.addEventListener('click', (e) => {
  if (!iconoUsuario?.contains(e.target) && !menuUsuario?.contains(e.target)) {
    menuUsuario?.classList.remove('activo');
  }
});
</script>

<script>
  document.getElementById('res-gema').textContent = localStorage.getItem('gema') || 'No seleccionado';
  document.getElementById('res-forma').textContent = localStorage.getItem('forma') || 'No seleccionado';
  document.getElementById('res-tamano').textContent = localStorage.getItem('tamano') || 'No seleccionado';
  document.getElementById('res-material').textContent = localStorage.getItem('material') || 'No seleccionado';
  document.getElementById('res-talla').textContent = localStorage.getItem('talla') || 'No seleccionada';
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>