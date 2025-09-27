<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Emerald</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* --- Definición de variables globales para un diseño consistente --- */
        :root {
            --emerald-primary: #009b77;
            --emerald-dark: #007a5f;
            --emerald-light-bg: #f0f8f6;
            --text-dark: #212529;
            --text-light: #6c757d;
            --border-color: #dee2e6;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            --border-radius: 0.75rem;
            --font-family-sans-serif: 'Poppins', sans-serif;
        }

        body {
            font-family: var(--font-family-sans-serif);
            background-color: var(--emerald-light-bg);
            color: var(--text-dark);
        }

        /* --- Estilos de componentes reutilizables --- */
        .btn-emerald {
            background-color: var(--emerald-primary);
            border-color: var(--emerald-primary);
            color: #fff;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .btn-emerald:hover, .btn-emerald:focus {
            background-color: var(--emerald-dark);
            border-color: var(--emerald-dark);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--emerald-primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 155, 119, 0.25);
        }
        
        .card-header-custom {
            background-color: var(--emerald-primary);
            color: #fff;
            font-weight: 600;
            border-bottom: none;
        }

        /* --- Estilos para la vista de Autenticación (Login/Registro) --- */
        .auth-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 1rem;
        }
        
        .auth-card {
            width: 100%;
            max-width: 480px;
        }

        .nav-tabs .nav-link {
            color: var(--text-light);
            font-weight: 600;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--emerald-primary);
            border-color: var(--border-color) var(--border-color) #fff;
        }

        /* --- Estilos para la vista de Dashboard --- */
        .main-header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            color: var(--emerald-primary) !important;
            font-weight: 600;
        }

        .table-custom thead {
            background-color: var(--emerald-primary);
            color: #fff;
            vertical-align: middle;
        }

    </style>
</head>
<body>

    <?php if (isset($_SESSION['jwt_token']) && !empty($usuarios)): ?>
        
        <header class="main-header sticky-top">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">
                        <i class="bi bi-shield-check-fill me-2"></i>Sistema de Gestión
                    </a>
                    <a href="index.php?page=usuarios&accion=logout" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                    </a>
                </div>
            </nav>
        </header>

        <main class="container py-5">
            <div class="row g-4 g-lg-5">

                <aside class="col-lg-4">
                    <section class="card" aria-labelledby="form-heading">
                        <header class="card-header card-header-custom">
                            <h2 class="h5 mb-0" id="form-heading"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Usuario</h2>
                        </header>
                        <div class="card-body p-4">
                            <?php echo $mensajeRegistro ?? ''; ?>
                            <form action="index.php?page=usuarios" method="POST" novalidate>
                                <input type="hidden" name="accion" value="registrar">
                                <div class="mb-3">
                                    <label for="reg-nombre" class="form-label">Nombre</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" id="reg-nombre" name="nombre" class="form-control" placeholder="Ej: Ana López" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg-email" class="form-label">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" id="reg-email" name="correo" class="form-control" placeholder="ejemplo@correo.com" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg-password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" id="reg-password" name="password" class="form-control" placeholder="••••••••" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-emerald w-100 mt-2">
                                    <i class="bi bi-check-circle me-2"></i>Registrar Usuario
                                </button>
                            </form>
                        </div>
                    </section>
                </aside>

                <div class="col-lg-8">
                    <section class="card" aria-labelledby="table-heading">
                        <header class="card-header card-header-custom">
                            <h2 class="h5 mb-0" id="table-heading"><i class="bi bi-people-fill me-2"></i>Lista de Usuarios</h2>
                        </header>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-custom">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Correo</th>
                                            <th scope="col" class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuarios as $usuario): ?>
                                            <tr>
                                                <td><span class="badge bg-secondary bg-opacity-25 text-dark"><?php echo htmlspecialchars($usuario['id']); ?></span></td>
                                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                                <td class="text-center">
                                                    <?php if ($usuario['activo']): ?>
                                                        <span class="badge rounded-pill text-bg-success">Activo</span>
                                                    <?php else: ?>
                                                        <span class="badge rounded-pill text-bg-secondary">Inactivo</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>

    <?php else: ?>

        <main class="auth-container">
            <div class="card auth-card">
                <div class="card-body p-4 p-md-5">

                    <figure class="text-center mb-4">
                        <i class="bi bi-shield-lock-fill" style="font-size: 3rem; color: var(--emerald-primary);"></i>
                        <h1 class="h3 fw-bold mt-2">Acceso al Sistema</h1>
                        <figcaption class="text-light">Por favor, inicia sesión o regístrate.</figcaption>
                    </figure>

                    <nav>
                        <div class="nav nav-tabs nav-fill mb-4" id="authTab" role="tablist">
                            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-panel" type="button" role="tab" aria-controls="login-panel" aria-selected="true">Iniciar Sesión</button>
                            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-panel" type="button" role="tab" aria-controls="register-panel" aria-selected="false">Crear Cuenta</button>
                        </div>
                    </nav>

                    <div class="tab-content" id="authTabContent">
                        
                        <section class="tab-pane fade show active" id="login-panel" role="tabpanel" aria-labelledby="login-tab">
                            <?php echo $mensajeLogin ?? ''; ?>
                            <form action="index.php?page=usuarios" method="POST">
                                <input type="hidden" name="accion" value="login">
                                <div class="mb-3">
                                    <label for="login-email" class="form-label">Correo Electrónico</label>
                                     <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" id="login-email" name="email" class="form-control" required placeholder="tu@correo.com">
                                     </div>
                                </div>
                                <div class="mb-3">
                                    <label for="login-password" class="form-label">Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" id="login-password" name="password" class="form-control" required placeholder="••••••••">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-emerald w-100 mt-3">Ingresar</button>
                            </form>
                        </section>
                        
                        <section class="tab-pane fade" id="register-panel" role="tabpanel" aria-labelledby="register-tab">
                            <?php echo $mensajeRegistro ?? ''; ?>
                            <form action="index.php?page=usuarios" method="POST">
                                <input type="hidden" name="accion" value="registrar">
                                <div class="mb-3">
                                    <label for="reg-nombre-auth" class="form-label">Nombre Completo</label>
                                     <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" id="reg-nombre-auth" name="nombre" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg-email-auth" class="form-label">Correo Electrónico</label>
                                     <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" id="reg-email-auth" name="correo" class="form-control" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reg-password-auth" class="form-label">Contraseña</label>
                                     <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" id="reg-password-auth" name="password" class="form-control" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-emerald w-100 mt-3">Crear mi Cuenta</button>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </main>
        
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>