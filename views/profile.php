<?php
// profile.php

require_once '../config/database.php';
require_once '../models/UserModel.php';

$db = Connection::getConnection();

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];
$userModel = new UserModel($db);
$userInfo = $userModel->getUserByUsername($username);

// Cambiar contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['changePassword'])) {
    $newPassword = $_POST['newPassword'];

    // Validar y actualizar la contraseña en la base de datos
    try {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ["cost" => 4]);
        $userModel->changePassword($username, $hashedPassword);

        // Redirigir a la página de perfil con un mensaje de éxito
        header('Location: profile.php?success=password_changed');
        exit();
    } catch (Exception $e) {
        // Manejar errores
        echo "Error: " . $e->getMessage();
    }
}
?>

    <?php 
// Eliminar cuenta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteAccount'])) {
    // Eliminar la cuenta y cerrar sesión
    try {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Agrega tus enlaces CSS y otros metadatos aquí -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeInDown 1s;
        }

        h2, h3 {
            color: #343a40;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            margin-top: 20px;
        }

        .cart-container {
        margin-top: 20px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        animation: fadeInDown 1s;
    }

    .cart-title {
        font-size: 24px;
        font-weight: bold;
        color: #343a40;
    }

    .cart-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 10px;
        padding: 10px;
        width: 200px;
        text-align: center;
        position: relative;
    }

    .cart-item img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .cart-item h3, .cart-item p {
        margin: 5px 0;
    }

    .remove-item {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        color: red;
    }

    </style>
</head>

<body>

<div class="container">
    <h2>User Profile</h2>
    <p>Welcome, <?php echo htmlspecialchars($userInfo['username']); ?>!</p>

    <!-- Cambiar contraseña -->
    <h3>Change Password</h3>
    <form method="post" action="" class="animate__animated animate__fadeIn">
        <label for="newPassword">New Password:</label>
        <input type="password" name="newPassword" required>
        <button type="submit" name="changePassword">Change Password</button>
    </form>

    <!-- Eliminar cuenta -->
    <h3>Delete Account</h3>
    <p>Are you sure you want to delete your account?</p>
    <form method="post" action="" class="animate__animated animate__fadeIn">
        <button type="submit" name="deleteAccount">Delete Account</button>
    </form>

    <!-- Mostrar mensajes de éxito -->
    <?php if (isset($_GET['success']) && $_GET['success'] === 'password_changed'): ?>
        <div class="alert alert-success" role="alert">
            Password changed successfully.
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'account_deleted'): ?>
        <div class="alert alert-success" role="alert">
            Account deleted successfully.
        </div>
    <?php endif; ?>
    <div class="cart-container">
        <h2>CARRITO 1</h2>
        <?php foreach ($_SESSION["carrito"] as $product) : ?>
            <div class="cart-item" id="<?php echo $product['id']; ?>">
                <img src="../<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p>Price: $<?php echo $product['price']; ?></p>
                <!-- Agrega lógica para agregar al carrito desde la tabla products -->
            </div>
        <?php endforeach; ?>
        
    </div>
    <!-- Agrega otros elementos del perfil aquí -->

</div>

<!-- Agrega tus scripts y enlaces a bibliotecas JS aquí -->

</body>
</html>
