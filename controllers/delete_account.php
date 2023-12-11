<?php
// delete_account.php

require_once '../config/database.php';
require_once '../models/UserModel.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eliminar la cuenta y cerrar sesión
    try {
        $userModel = new UserModel($db);
        $username = $_SESSION['username'];
        $userModel->deleteUser($username);

        // Cerrar sesión
        session_destroy();

        // Redirigir a la página de inicio con un mensaje de éxito
        header('Location: ../index.php?success=account_deleted');
        exit();
    } catch (Exception $e) {
        // Manejar errores
        echo "Error: " . $e->getMessage();
    }
}

?>
