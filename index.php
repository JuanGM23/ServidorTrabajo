<?php
session_start();
// Incluye los archivos necesarios
require_once(__DIR__ . '/config/database.php');
require_once(__DIR__ . '/models/ProductModel.php');
require_once(__DIR__ . '/controllers/ProductController.php');
require_once(__DIR__ . '/models/CartModel.php');
require_once(__DIR__ . '/controllers/CartController.php');

// Verifica si se ha enviado el formulario de filtrado

// Crea una instancia del controlador de productos
$productController = new ProductController(new ProductModel(Connection::getConnection()));

// Obtén la lista de productos según la categoría seleccionada (si está presente)
$category="";
if(isset($_GET["category"])){
    $category=$_GET["category"];
}else{

    $category =  'All';
}

$products = $productController->getProductsByCategory($category);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CompetchStore</title>
    <!-- Agrega tus enlaces CSS y scripts aquí si es necesario -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<style>
    /* styles.css */

    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
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
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 10px;
        padding: 10px;
        width: 200px;
        text-align: center;
    }

    .card img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    footer {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 10px;
    }

    footer button {
        background-color: #fff;
        color: #333;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    footer button:hover {
        background-color: #ddd;
    }
</style>
<body>
    <header>
        <?php
        // Muestra el saludo si el usuario ha iniciado sesión
        if (isset($_SESSION['username'])) {
            echo "<p>Hi, " . $_SESSION['username'] . "!</p>";
        }
        ?>
    </header>
    
    

    <!-- Agrega jQuery antes de la sección de scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    // Función para manejar la adición al carrito
    function addToCart(productId) {
        // Configurar la solicitud AJAX usando jQuery
        $.post("views/add_to_cart.php", { productId: productId }, function (data) {
            // Procesar la respuesta
            try {
                var response = JSON.parse(data);
                
                    alert("Producto agregado al carrito correctamente");
            }
</script>


    <footer>
    <?php
    if (isset($_SESSION['username'])) {
        // Si el usuario ha iniciado sesión, muestra el botón de cierre de sesión
        echo "<button onclick=\"window.location.href='../views/logout_success.php'\">Cerrar Sesión</button>";
    } else {
        // Si no ha iniciado sesión, muestra los botones de registro e inicio de sesión
        echo "<button onclick=\"window.location.href='views/register.php'\">Registro</button>";
        echo "<button onclick=\"window.location.href='views/login.php'\">Inicio de Sesión</button>";
    }
    ?>
    </footer>
</body>
</html>