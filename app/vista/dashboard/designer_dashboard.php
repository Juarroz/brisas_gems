<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Diseñador - Brisas Gems</title>
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
            <a class="navbar-brand" href="<?= BASE_URL ?>/dashboard">
                <i class="bi bi-palette2 me-2"></i>Brisas Gems - Diseñador
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/designer/disenos">Mis Diseños</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/designer/renders">Renders 3D</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/designer/pedidos">Pedidos Asignados</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/designer/comunicacion">Comunicación</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i><?= $_SESSION['user_name'] ?? 'Diseñador' ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/perfil">Mi Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= BASE_URL ?>/logout">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 mb-0">Panel del Diseñador</h1>
            <span class="badge bg-primary fs-6">Diseñador</span>
        </div>
        
        <p class="text-muted mb-4">Bienvenido <?= $_SESSION['user_name'] ?? 'Diseñador' ?>, aquí puedes gestionar tus diseños y renders.</p>
        
        <h5 class="mb-3 text-muted">Mis Actividades</h5>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <div class="col">
                <a href="<?= BASE_URL ?>/designer/disenos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-palette2 text-primary"></i>
                            <p class="card-text mt-2">Diseños Activos</p>
                            <h2 class="display-4 text-primary"><?= $data['disenosActivos'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/designer/renders" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-cube text-info"></i>
                            <p class="card-text mt-2">Renders Pendientes</p>
                            <h2 class="display-4 text-info"><?= $data['rendersPendientes'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/designer/comunicacion" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-chat-dots text-warning"></i>
                            <p class="card-text mt-2">Mensajes Pendientes</p>
                            <h2 class="display-4 text-warning"><?= $data['comunicacionesPendientes'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col">
                <a href="<?= BASE_URL ?>/designer/pedidos" class="stat-card">
                    <div class="card text-center border-0 shadow-sm h-100">
                        <div class="card-body">
                            <i class="bi bi-clipboard-check text-success"></i>
                            <p class="card-text mt-2">Pedidos Asignados</p>
                            <h2 class="display-4 text-success"><?= $data['pedidosAsignados'] ?? 0; ?></h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <hr class="my-5">

        <h5 class="mb-3 text-muted">Acciones Rápidas</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-plus-circle me-2 text-primary"></i>Nuevo Diseño</h6>
                        <p class="card-text text-muted small">Crear un nuevo diseño desde cero</p>
                        <a href="<?= BASE_URL ?>/designer/nuevo-diseno" class="btn btn-primary btn-sm">Comenzar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-clock-history me-2 text-info"></i>Revisar Renders</h6>
                        <p class="card-text text-muted small">Revisar y aprobar renders pendientes</p>
                        <a href="<?= BASE_URL ?>/designer/renders" class="btn btn-info btn-sm">Revisar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>