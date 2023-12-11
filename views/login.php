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

    // Llama a la función del controlador para iniciar sesión
    if ($userController->loginUser($username, $password)) {
        // Obtén la información del perfil directamente
        $profileModel = new ProfileModel(Connection::getConnection());
        $userData = $profileModel->getUserByUsername($username);

        // Mostrar la información del perfil con estilos modernos
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>User Profile</title>
                
            </head>
            <body>
                <header>
                    <h1>Tienda de Informática</h1>
                    <nav>
                        <ul>
                            <!-- Otros elementos de navegación -->
                            <li><a href="../index.php">Inicio</a></li>
                            <li><a href="../index.php">Productos</a></li>
                            <li><a href="services_view.php">Servicios</a></li>';
        
        if (isset($_SESSION['userId'])) {
            // Si el usuario ha iniciado sesión, muestra el enlace al perfil
            echo '<li><a href="profile_view.php">View Profile</a></li>';
        }
        
        echo '</ul>
                </nav>
            </header>
            <main>
                <div class="profile-container">
                    <h1>User Profile</h1>
                    <p><strong>Name:</strong> ' . $userData['username'] . '</p>
                    <p><strong>Email:</strong> ' . $userData['email'] . '</p>
                    <p><strong>Address:</strong> ' . $userData['address'] . '</p>
                    <a href="logout.php">Logout</a>
                </div>
            </main>
        </body>
        </html>';
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Agrega tus enlaces CSS y scripts aquí si es necesario -->
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
        <h1>Tienda de Informática</h1>
        <nav>
            <ul>
                <!-- Otros elementos de navegación -->
                <li><a href="../index.php">Home</a></li>
                <li><a href="../index.php">Products</a></li>
                <li><a href="services_view.php">Services</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="login-container">
            <h1>Login</h1>
            <form action="login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" required>

                <label for="password">Password:</label>
                <input type="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </main>
</body>
</html>
