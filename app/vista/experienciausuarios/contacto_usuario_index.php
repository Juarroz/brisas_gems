<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Contacto | Emerald</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --emerald-primary: #009b77;
            --emerald-dark: #007a5f;
            --emerald-light-bg: #f4f7f6;
            --text-dark: #212529;
            --text-light: #6c757d;
            --card-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
            --border-radius: 0.75rem;
            --font-family-sans-serif: 'Poppins', sans-serif;
        }

        body {
            font-family: var(--font-family-sans-serif);
            background-color: var(--emerald-light-bg);
        }

        .btn-emerald {
            background-color: var(--emerald-primary);
            border-color: var(--emerald-primary);
            color: #fff;
            font-weight: 600;
        }
        .btn-emerald:hover {
            background-color: var(--emerald-dark);
            border-color: var(--emerald-dark);
            color: #fff;
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .form-control:focus {
            border-color: var(--emerald-primary);
            box-shadow: 0 0 0 0.25rem rgba(0, 155, 119, 0.25);
        }

        .card-header-custom {
            background-color: var(--emerald-primary);
            color: #fff;
            font-weight: 600;
            border-bottom: none;
        }
    </style>
</head>
<body>

    <header class="bg-white shadow-sm py-3 mb-4">
        <div class="container">
            <h1 class="h3 mb-0 fw-bold" style="color: var(--emerald-primary);">
                <i class="bi bi-envelope-fill me-2"></i>Formulario de Contacto
            </h1>
        </div>
    </header>

    <main class="container">
        <div class="row justify-content-center">
            <section class="col-lg-6">
                <div class="card">
                    <header class="card-header card-header-custom">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-person-lines-fill me-2"></i>Envíanos un Mensaje
                        </h2>
                    </header>
                    <div class="card-body p-4">
                        <?= !empty($mensaje) ? $mensaje : '' ?>
                        <form method="POST">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                        <input id="nombre" class="form-control" type="text" name="nombre" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="correo" class="form-label">Correo electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input id="correo" class="form-control" type="email" name="correo" placeholder="opcional">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="opcional">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="mensaje" class="form-label">Mensaje *</label>
                                    <textarea id="mensaje" class="form-control" name="mensaje" rows="4" required></textarea>
                                </div>

                                <div class="col-12 form-check">
                                    <input class="form-check-input" type="checkbox" id="terminos" name="terminos" value="1" required>
                                    <label class="form-check-label" for="terminos">
                                        Acepto los términos y condiciones
                                    </label>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-emerald w-100" type="submit">
                                        <i class="bi bi-send-fill me-2"></i>Enviar Mensaje
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
