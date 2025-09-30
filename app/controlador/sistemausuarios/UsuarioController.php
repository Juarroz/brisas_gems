<?php
require_once __DIR__ . '/../../modelo/sistemausuarios/UsuarioService.php';
require_once __DIR__ . '/../../modelo/sistemausuarios/RolService.php';
require_once __DIR__ . '/../../core/AuthGuard.php';

class UsuarioController {
    private $usuarioService;
    private $rolService;

    public function __construct() {
        $this->usuarioService = new UsuarioService();
        $this->rolService = new RolService();
    }

    public function listUsers() {
        requireLogin();
        $token = $_SESSION['jwt_token'];
        $usuarios = $this->usuarioService->listarUsuarios($token, true);
        require_once __DIR__ . '/../../vista/sistemausuarios/listar_usuarios.php';
    }

    public function listInactiveUsers() {
        requireLogin();
        $token = $_SESSION['jwt_token'];
        $usuarios = $this->usuarioService->listarUsuarios($token, false);
        require_once __DIR__ . '/../../vista/sistemausuarios/listar_inactivos.php';
    }

    public function showEditForm() {
        requireLogin();
        $userId = $_GET['id'] ?? null;
        if (!$userId) { die("Error: No se ha especificado un ID de usuario."); }
        $token = $_SESSION['jwt_token'];
        
        $usuario = $this->usuarioService->obtenerUsuarioPorId((int)$userId, $token);
        $roles = $this->rolService->listarRoles($token);

        if (!$usuario) { $error_message = "No se pudo encontrar al usuario con ID " . htmlspecialchars($userId); }
        
        require_once __DIR__ . '/../../vista/sistemausuarios/editar_usuario.php';
    }

    public function handleUpdate() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_SESSION['jwt_token'];
            $userId = (int)$_POST['id'];
            $userData = [
                'nombre' => $_POST['nombre'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'telefono' => $_POST['telefono'] ?? null,
                'rolId' => (int)($_POST['rolId'] ?? null)
            ];
            $response = $this->usuarioService->actualizarUsuario($userId, $userData, $token);
            if ($response['code'] === 200) {
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Usuario actualizado correctamente.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'danger', 'text' => 'Error al actualizar el usuario.'];
            }
        }
        header('Location: /usuarios');
        exit();
    }

    public function handleChangeStatus() {
        requireLogin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_SESSION['jwt_token'];
            $userId = (int)$_POST['id'];
            $nuevoEstado = (bool)$_POST['estado'];
            $response = $this->usuarioService->cambiarEstadoUsuario($userId, $nuevoEstado, $token);
            if ($response['code'] === 200) {
                $accion = $nuevoEstado ? 'activado' : 'desactivado';
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => 'Usuario ' . $accion . ' correctamente.'];
            } else {
                $_SESSION['flash_message'] = ['type' => 'danger', 'text' => 'Error al cambiar el estado del usuario.'];
            }
        }
        $redirectUrl = $_POST['estado'] ? '/usuarios/inactivos' : '/usuarios';
        header('Location: ' . $redirectUrl);
        exit();
    }

    public function showRegistrationForm() {
        require_once __DIR__ . '/../../vista/sistemausuarios/registro.php';
    }

    public function handleRegistration() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'nombre'   => $_POST['nombre'] ?? '',
                'correo'   => $_POST['correo'] ?? '',
                'password' => $_POST['password'] ?? '',
                'telefono' => $_POST['telefono'] ?? null,
                'rolId'    => 1,
                'origen'   => 'registro',
                'activo'   => true
            ];
            $response = $this->usuarioService->crearUsuario($userData);
            if ($response['code'] === 201) {
                if (session_status() == PHP_SESSION_NONE) { session_start(); }
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => '¡Registro exitoso! Ya puedes iniciar sesión.'];
                header('Location: /login');
                exit();
            } else {
                $error_message = "Error al registrar el usuario.";
                if (isset($response['body']['message'])) {
                    $error_message .= " Detalle: " . $response['body']['message'];
                }
                require_once __DIR__ . '/../../vista/sistemausuarios/registro.php';
            }
        } else {
            $this->showRegistrationForm();
        }
    }
}