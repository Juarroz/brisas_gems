<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Nuevo Usuario</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet"> 
    <style>
        :root { --bs-primary: #009688; }
        body { background-color: #f0f2f5; }
        .card { border: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-4">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Crear una Cuenta</h2>
                        
                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($success_message)): // Aunque ahora redirigimos, lo dejamos por si acaso ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo htmlspecialchars($success_message); ?>
                            </div>
                        <?php endif; ?>

                        <form action="/usuarios/registrar" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono (Opcional)</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>