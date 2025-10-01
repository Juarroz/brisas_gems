<?php
require_once __DIR__ . '/../../modelo/seguridad/AuthService.php';

class AuthController {
    private $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function showLogin() {
        require_once __DIR__ . '/../../vista/seguridad/login.php';
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $result = $this->authService->login($email, $password);

            if ($result && isset($result['token'])) {
                if (session_status() == PHP_SESSION_NONE) { 
                    session_start(); 
                }
                $_SESSION['jwt_token'] = $result['token'];
                $_SESSION['user_role'] = $result['userRole'] ?? 'ROLE_USUARIO';
                $_SESSION['user_name'] = $result['userName'] ?? 'Usuario';
                $_SESSION['user_email'] = $result['email'] ?? $email;

                // ✅ REDIRECCIÓN INTELIGENTE - Usa dashboardUrl del backend
                $dashboardUrl = $result['dashboardUrl'] ?? '/dashboard';
                header('Location: ' . BASE_URL . $dashboardUrl);
                exit();
            } else {
                $error_message = "Correo o contraseña incorrectos.";
                require_once __DIR__ . '/../../vista/seguridad/login.php';
            }
        } else {
            $this->showLogin();
        }
    }

    public function handleLogout() {
        if (session_status() == PHP_SESSION_NONE) { 
            session_start(); 
        }
        $_SESSION = [];
        session_destroy();

        header('Location: ' . BASE_URL . '/');
        exit();
    }
}