<?php
// Inicia o reanuda la sesión de PHP para manejar el token
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../modelo/sistemausuarios/UsuarioService.php';

class UsuarioController {
    private $usuarioService;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
    }

    public function manejarPeticion() {
        // Variables que usará la vista
        $mensajeLogin    = '';
        $mensajeRegistro = '';
        $usuarios        = [];

        // ---------- LOGOUT ----------
        if (isset($_GET['accion']) && $_GET['accion'] === 'logout') {
            session_destroy();
            header("Location: index.php?page=usuarios");
            exit();
        }

        // ---------- POST: login / registrar ----------
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $accion = $_POST['accion'] ?? '';

            // Login
            if ($accion === 'login') {
                $resultado = $this->usuarioService->login($_POST['email'] ?? '', $_POST['password'] ?? '');
                if ($resultado['success']) {
                    $_SESSION['jwt_token'] = $resultado['token'];
                } else {
                    $mensajeLogin = "<p style='color:red;'>" . htmlspecialchars($resultado['error']) . "</p>";
                }
            }
            // Registro
            elseif ($accion === 'registrar') {
                $userData = [
                    "nombre"   => $_POST['nombre'] ?? '',
                    "correo"   => $_POST['correo'] ?? '',
                    "password" => $_POST['password'] ?? '',
                    "rolId"    => 2,   // Rol por defecto
                    "activo"   => true
                ];
                $resultado = $this->usuarioService->registrarUsuario($userData);
                if ($resultado['success']) {
                    $mensajeRegistro = "<p style='color:green;'>Usuario registrado correctamente.</p>";
                } else {
                    $mensajeRegistro = "<p style='color:red;'>" . htmlspecialchars($resultado['error']) . "</p>";
                }
            }
        }

        // ---------- LISTAR USUARIOS (si hay sesión activa) ----------
        if (isset($_SESSION['jwt_token'])) {
            $listaUsuarios = $this->usuarioService->obtenerUsuarios($_SESSION['jwt_token']);
            if ($listaUsuarios !== false) {
                $usuarios = $listaUsuarios;
            } else {
                unset($_SESSION['jwt_token']);
                $mensajeLogin = "<p style='color:red;'>Tu sesión ha expirado. Inicia sesión de nuevo.</p>";
            }
        }

        // ---------- Cargar vista ----------
        require __DIR__ . '/../../vista/sistemausuarios/usuario_index.php';
    }
}
