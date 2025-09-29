<?php
// Rutas actualizadas para la nueva estructura
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

    // --- MÉTODOS PARA EL REGISTRO ---

    public function showRegistrationForm() {
        // Apunta a la nueva ubicación de la vista de registro
        require_once __DIR__ . '/../../vista/sistemausuarios/registro.php';
    }

    public function handleRegistration() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'nombre'   => $_POST['nombre'] ?? '',
                'correo'   => $_POST['correo'] ?? '',
                'password' => $_POST['password'] ?? '',
                'telefono' => $_POST['telefono'] ?? null,
                'rolId'    => 1, // Por defecto, el rol de 'usuario' es 1
                'origen'   => 'registro',
                'activo'   => true
            ];

            // La creación de usuario es pública, no necesita token
            $response = $this->usuarioService->crearUsuario($userData);

            if ($response['code'] === 201) {
                // Si el registro es exitoso, redirigimos al login con un mensaje de éxito
                if (session_status() == PHP_SESSION_NONE) { session_start(); }
                $_SESSION['flash_message'] = ['type' => 'success', 'text' => '¡Registro exitoso! Ya puedes iniciar sesión.'];
                header('Location: /login');
                exit();
            } else {
                // Si falla, volvemos a mostrar el formulario con un error
                $errorMessage = "Error al registrar el usuario.";
                if (isset($response['body']['message'])) {
                    $errorMessage .= " Detalle: " . $response['body']['message'];
                }
                $error_message = $errorMessage;
                require_once __DIR__ . '/../../vista/sistemausuarios/registro.php';
            }
        } else {
            $this->showRegistrationForm();
        }
    }
    
    // --- (Aquí irían los otros métodos que migraremos después: listUsers, showEditForm, etc.) ---
}