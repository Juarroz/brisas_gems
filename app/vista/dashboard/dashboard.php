<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Brisas Gems</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard">Brisas Gems - Admin</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/usuarios">Usuarios</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/pedidos">Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/personalizar">Personalizaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/admin/contactos">Contacto</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="btn btn-outline-light" href="<?= BASE_URL ?>/logout">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <h1 class="h2 mb-4">Panel de Administración</h1>
        
        <h5 class="mb-3 text-muted">Estado de la Producción</h5>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
            <div class="col">
                <a href="<?= BASE_URL ?>/pedidos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-palette2 text-primary"></i>
                            <p class="card-text mt-2">En Diseño</p>
                            <h2 class="display-4 text-primary"><?= $data['pedidosEnDiseño'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/pedidos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-gem text-info"></i>
                            <p class="card-text mt-2">En Tallado</p>
                            <h2 class="display-4 text-info"><?= $data['pedidosEnTallado'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/pedidos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-gear text-secondary"></i>
                            <p class="card-text mt-2">En Engaste</p>
                            <h2 class="display-4 text-secondary"><?= $data['pedidosEnEngaste'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/pedidos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-brightness-high text-warning"></i>
                            <p class="card-text mt-2">En Pulido</p>
                            <h2 class="display-4 text-warning"><?= $data['pedidosEnPulido'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/pedidos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-x-circle text-danger"></i>
                            <p class="card-text mt-2">Cancelados</p>
                            <h2 class="display-4 text-danger"><?= $data['pedidosCancelados'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr class="my-5">

        <h5 class="mb-3 text-muted">Gestión General</h5>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/admin/contactos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-envelope-exclamation text-danger"></i>
                            <p class="card-text mt-2">Mensajes Pendientes</p>
                            <h2 class="display-4 text-danger"><?= $data['totalContactosPendientes'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/usuarios" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-people text-success"></i>
                            <p class="card-text mt-2">Usuarios Activos</p>
                            <h2 class="display-4 text-success"><?= $data['totalUsuariosActivos'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <a href="<?= BASE_URL ?>/usuarios/inactivos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-person-slash text-secondary"></i>
                            <p class="card-text mt-2">Usuarios Inactivos</p>
                            <h2 class="display-4 text-secondary"><?= $data['totalUsuariosInactivos'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>