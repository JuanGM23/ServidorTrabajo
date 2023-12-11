<?php
session_start();

// Incluye los archivos necesarios para el patrón MVC
require_once '../config/database.php';  // Configuración de la base de datos
require_once '../models/UserModel.php';  // Modelo de usuarios
require_once '../controllers/UserController.php';  // Controlador de usuarios

// Inicializa el controlador de usuarios
$userController = new UserController(Connection::getConnection());

// Verificar si se reciben datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Llama a la función del controlador para registrar al usuario
    $userController->registerUser($username, $password, $email, $address);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <style>
       /* styles.css */

body {
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background-color: #333;
    color: #fff;
    padding: 10px;
    text-align: center;
}

nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

nav ul li {
    display: inline;
    margin-right: 20px;
}

nav a {
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

main {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #333;
    text-align: center;
}

h2 {
    color: white;
    text-align: center;
}
form {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 400px;
    margin: auto;
    margin-top: 50px;
}

label {
    display: block;
    margin-bottom: 10px;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    box-sizing: border-box;
}

button {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #555;
}

    </style>
</head>

<body>
    <header>
        <h2>CompetchStore</h2>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="about_us_view.php">About Us</a></li>
                <li><a href="../index.php">Products</a></li>
                <li><a href="contact_form_view.php">Contact</a></li>
                <?php
if (isset($_SESSION['userId'])) {
    // Si el usuario ha iniciado sesión, muestra el enlace al perfil
    echo '<li><a href="profile_view.php">View Profile</a></li>';
}
?>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Register</h1>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="address">Address:</label>
            <input type="text" name="address">

            <button type="submit">Register</button>
        </form>
    </main>

    <footer>
        <!-- No incluir enlaces a registro e inicio de sesión en esta vista -->
    </footer>
</body>
</html>
