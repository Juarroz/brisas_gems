<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --bs-primary: #009688; }
        body { background-color: #f0f2f5; }
        .card { border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>

                        <?php
                        // --- CÓDIGO AÑADIDO ---
                        // Muestra el mensaje flash si existe (ej: después de un registro exitoso)
                        if (session_status() == PHP_SESSION_NONE) { session_start(); }
                        if (isset($_SESSION['flash_message'])):
                        ?>
                            <div class="alert alert-<?php echo $_SESSION['flash_message']['type']; ?> alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['flash_message']['text']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['flash_message']); // Limpiamos el mensaje
                        endif;
                        // --- FIN DEL CÓDIGO AÑADIDO ---

                        // Muestra el mensaje de error si el login falla
                        if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                        <?php endif; ?>

                        <form action="/login" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Ingresar</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="/usuarios/registrar">¿No tienes una cuenta? Regístrate aquí</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>