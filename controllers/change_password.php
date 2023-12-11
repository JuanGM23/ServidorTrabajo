<?php
// change_password.php

require_once '../config/database.php';
require_once '../models/UserModel.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['newPassword'];

    // Validar y actualizar la contraseña en la base de datos
    try {
        $userModel = new UserModel($db);
        $username = $_SESSION['username'];
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ["cost" => 4]);
        $userModel->changePassword($username, $hashedPassword);

        // Redirigir a la página de perfil con un mensaje de éxito
        header('Location: ../views/profile.php?success=password_changed');
        exit();
    } catch (Exception $e) {
        // Manejar errores
        echo "Error: " . $e->getMessage();
    }
}

?>
