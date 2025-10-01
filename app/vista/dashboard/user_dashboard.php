<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel - Brisas Gems</title>
    <link href="<?= BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --bs-primary: #009688; }
        body { background-color: #f8f9fa; }
        .navbar { background-color: var(--bs-primary); }
        .stat-card { text-decoration: none; display: block; }
        .stat-card .card { transition: transform 0.2s, box-shadow 0.2s; }
        .stat-card:hover .card { transform: translateY(-5px); box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .stat-card .display-4 { font-weight: 700; }
        .stat-card .bi { font-size: 3rem; }
        .welcome-section { background: linear-gradient(135deg, #009688, #4db6ac); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard">
                <i class="bi bi-gem me-2"></i>Brisas Gems
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/personalizar">Personalizar Joya</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/mis-pedidos">Mis Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/inspiracion">Galería</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/contacto">Contacto</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= $_SESSION['user_name'] ?? 'Usuario' ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/perfil">Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/mis-personalizaciones">Mis Personalizaciones</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/logout">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <!-- Sección de Bienvenida -->
        <div class="welcome-section text-white rounded-3 p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-1">¡Bienvenido, <?= $_SESSION['user_name'] ?? 'Usuario' ?>! 👋</h2>
                    <p class="mb-0 opacity-75">Gestiona tus pedidos y personaliza tus joyas soñadas</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= BASE_URL ?>/personalizar" class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Crear Nueva Joya
                    </a>
                </div>
            </div>
        </div>

        <h5 class="mb-3 text-muted">Mis Actividades</h5>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <a href="<?= BASE_URL ?>/mis-pedidos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-clock-history text-primary"></i>
                            <p class="card-text mt-2">Pedidos Activos</p>
                            <h2 class="display-4 text-primary"><?= $data['misPedidosActivos'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/mis-personalizaciones" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-palette2 text-info"></i>
                            <p class="card-text mt-2">Mis Personalizaciones</p>
                            <h2 class="display-4 text-info"><?= $data['misPersonalizaciones'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/historial" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-check-circle text-success"></i>
                            <p class="card-text mt-2">Pedidos Completados</p>
                            <h2 class="display-4 text-success"><?= $data['pedidosCompletados'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr class="my-5">

        <div class="row g-4">
            <!-- Acciones Rápidas -->
            <div class="col-lg-6">
                <h5 class="mb-3 text-muted">Acciones Rápidas</h5>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="<?= BASE_URL ?>/personalizar" class="btn btn-outline-primary w-100 h-100 py-3">
                                    <i class="bi bi-plus-circle d-block mb-2" style="font-size: 2rem;"></i>
                                    <span>Personalizar Joya</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= BASE_URL ?>/inspiracion" class="btn btn-outline-info w-100 h-100 py-3">
                                    <i class="bi bi-images d-block mb-2" style="font-size: 2rem;"></i>
                                    <span>Ver Inspiración</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= BASE_URL ?>/mis-pedidos" class="btn btn-outline-warning w-100 h-100 py-3">
                                    <i class="bi bi-list-check d-block mb-2" style="font-size: 2rem;"></i>
                                    <span>Mis Pedidos</span>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?= BASE_URL ?>/contacto" class="btn btn-outline-success w-100 h-100 py-3">
                                    <i class="bi bi-headset d-block mb-2" style="font-size: 2rem;"></i>
                                    <span>Soporte</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del Usuario -->
            <div class="col-lg-6">
                <h5 class="mb-3 text-muted">Mi Información</h5>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1"><?= $_SESSION['user_name'] ?? 'Usuario' ?></h6>
                                <p class="text-muted small mb-0"><?= $_SESSION['user_email'] ?? 'usuario@ejemplo.com' ?></p>
                                <span class="badge bg-primary">Cliente</span>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border-end">
                                    <div class="h5 mb-1"><?= $data['misPedidosActivos'] ?? 0 ?></div>
                                    <small class="text-muted">Activos</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border-end">
                                    <div class="h5 mb-1"><?= $data['misPersonalizaciones'] ?? 0 ?></div>
                                    <small class="text-muted">Diseños</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="h5 mb-1"><?= $data['pedidosCompletados'] ?? 0 ?></div>
                                <small class="text-muted">Completados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>