<!-- products_view.php -->
<?php

// Incluye los archivos necesarios


// Verifica si se ha enviado el formulario de filtrado
/*   // Verifica si la acción es de filtrado
    if (isset($_GET['category'])) {
        // Obtiene la categoría y redirige a la misma página con el parámetro de categoría
        $category = $_GET['category'];
        header("Location: index.php?category=$category");
        exit();
    }
}*/

// Crea una instancia del controlador de productos
$productController = new ProductController(new ProductModel(Connection::getConnection()));

// Obtén la lista de productos según la categoría seleccionada (si está presente)
$category = isset($_GET['category']) ? $_GET['category'] : 'All';
$products = $productController->getProductsByCategory($category);

// Verifica si se ha enviado la acción de agregar al carrito
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "addToCart") {
    // Verifica si el usuario está autenticado
    if (isset($_SESSION['userId'])) {
        // Obtiene los datos del formulario
        $productId = $_POST['productId'];
        $quantity = 1; // Puedes cambiar la cantidad según tus necesidades
        $userId = $_SESSION['userId'];

        // Agrega el producto al carrito
        $db = Connection::getConnection();
        $cartModel = new CartModel($db);
        $cartModel->addToCart($productId, $quantity, $userId);

        // Responde con un mensaje JSON (puedes personalizar según tus necesidades)
        echo json_encode(["success" => true, "message" => "Product added to cart successfully"]);
        exit();
    } else {
        // Si el usuario no está autenticado, responde con un mensaje JSON de error
        echo json_encode(["success" => false, "message" => "User not authenticated"]);
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
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

        /* Estilos adicionales para el mini carrito */
#mini-cart {
    max-width: 250px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

#mini-cart-items {
    list-style: none;
    padding: 0;
}

#mini-cart-items li {
    border-bottom: 1px solid #ddd;
    padding: 5px;
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
    <h1>CompetchStore</h1>
    <h1>Products</h1>

    <nav>
        <ul>
            <!-- Otros elementos de navegación -->
            <li><a href="../index.php">Home</a></li>
            <li><a href="views/about_us_view.php">About Us</a></li>
            <li><a href="views/services_view.php">Services</a></li>
            <li><a href="views/contact_form_view.php">Contact</a></li>
            <li><a href="views/profile.php">View Profile</a></li>
            <li><a href="views/cart_view.php">View Cart</a></li>
        </ul>
    </nav>

    <form method="get" action="index.php">
        <label for="category">Select Category:</label>
        <select id="category" name="category">
            <option value="All">All</option>
            <option value="Hardware">Hardware</option>
            <option value="Peripheral">Peripheral</option>
            <option value="Keys">Keys</option>
        </select>
        <button type="submit" getProductsByCategory>Filter</button>
    </form>
</header>

<main>
    <?php
    // Mostrar productos
    if (!empty($products)) {
        foreach ($products as $product) :
    ?>
            <div class="card">
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['description']; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <button onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
            </div>
    <?php
        endforeach;
    } else {
        echo "<p>No products found.</p>";
    }
    ?>
</main>

<script>
    function profile_view() {
        // Lógica para redirigir a la página de perfil
        window.location.href = 'views/profile.php';
    }

    function addToCart(productId) {
        // Envia una solicitud AJAX al servidor
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_to_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Configura la función de devolución de llamada cuando la solicitud AJAX se complete
        xhr.onload = function () {
            
                // La solicitud fue exitosa, puedes mostrar algún mensaje si es necesario
                alert('Producto agregado al carrito con éxito');
           

        // Construye los datos a enviar en la solicitud AJAX
        var params = "productId=" + productId;

        // Envía la solicitud AJAX con los datos
        xhr.send(params);
    }
</script>

<footer>
    <!-- Agrega aquí el pie de página si es necesario -->
</footer>
</body>

    </html>
