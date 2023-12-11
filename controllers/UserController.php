<?php

require_once '../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function registerUser($username, $password, $email, $address) {
        try {
            $registered = $this->userModel->registerUser($username, $password, $email, $address);

            if ($registered) {
                // Puedes redirigir a una página de éxito o realizar otras acciones
                header('Location: ../views/register_success.php');
                exit();
            } else {
                // Puedes redirigir a una página de error o mostrar un mensaje
                header('Location: ../views/register.php?error=user_exists');
                exit();
            }
        } catch (Exception $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
        }
    }

    public function loginUser($username, $password) {
        try {
            $loggedIn = $this->userModel->loginUser($username, $password);

            if ($loggedIn) {
                // Iniciar sesión
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $userInfo['id'];


                // Puedes redirigir a una página de éxito o realizar otras acciones
                header('Location: ../views/login_success.php');
                exit();
            } else { 
                // Puedes redirigir a una página de error o mostrar un mensaje
                header('Location: ../views/login.php?error=invalid_credentials');
                exit();
            }
        } catch (Exception $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
        }
    }

    public function logoutUser() {
        // Cerrar sesión
        session_start();
        session_destroy();

        // Puedes redirigir a una página de éxito o realizar otras acciones
        header('Location: ../views/logout_success.php');
        exit();
    }
}
?>
