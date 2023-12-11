<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>

<style>
    /* Agrega estilos según sea necesario */
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

    main {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
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

    .remove-item {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        color: red;
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
        margin-right: 10px;
    }

    footer button:hover {
        background-color: #ddd;
    }
</style>

<body>

    <header>
        <!-- Puedes incluir información del usuario si está logueado -->
        <h1>CompetchStore</h1>
        <h1>Shopping Cart</h1>
    </header>

    <main>
        <?php
        // Inicia la sesión si no está iniciada
        session_start();
       
        // Verifica si el usuario está logueado
        if (isset($_SESSION['username'])) {
            // Incluye la clase Connection y CartModel
            require_once __DIR__ . '/../config/database.php';
            require_once __DIR__ . '/../models/CartModel.php';
           # require_once __DIR__ . '/../controllers/CartController.php';
            require_once '../models/ProductModel.php';
            require_once __DIR__ . '/../controllers/Cart.php';

            // Obtiene la conexión a la base de datos
            $db = Connection::getConnection();

            // Crea una instancia del modelo y del controlador del carrito
            $cartModel = new CartModel($db);
          #  $cartController = new CartController($cartModel);

            // Obtén los productos del carrito para el usuario actual
            $userId = $_SESSION['userId'];
 
            #$cartProducts = $cartModel->getCartProducts($userId);
            #$cart = new Cart(new ProductModel(Connection::getConnection()));
            #$cartProducts = $cart->getCartProducts();
            #$cartProducts = getCartProducts();
            #$cartProducts = getCartProducts();
           

            // Mostrar solo los tres primeros productos del carrito
            $counter = 0;
            foreach ($Cart as $cartProduct) {
                if ($counter < 3) {
                    
        ?>
                    <div class="cart-item">
                        <span class="remove-item" onclick="removeCartItem(<?php echo $cartProduct['product_id']; ?>)">X</span>
                        <img src="<?= "../" /*$cartProduct['image_url']*/; ?>" alt="<?php echo $cartProduct['name']; ?>">
                        <h3><?php echo $cartProduct['name']; ?></h3>
                        <p>Price: $<?php echo $cartProduct['price']; ?></p>
                        <p>Quantity: <?php echo $cartProduct['quantity']; ?></p>
                    </div>
        <?php
                    $counter++;
                } else {
                    break; // Sal del bucle después de mostrar los tres primeros productos
                }
            }

            if ($counter === 0) {
                // Si no hay productos en el carrito, mostrar los tres primeros productos desde la tabla products
                $productModel = new ProductModel($db); // Asegúrate de tener un modelo de productos
                #$products = $productModel->getThreeProducts(); // Método para obtener los tres primeros productos
                $products = $Cart->getCartProducts();
                $_SESSION["carrito"] = $products;
                foreach ($products as $product) {
        ?>
                    <div class="cart-item" id="<?php echo $product['id']; ?>">
                        <span class="remove-item" onclick="removeCartItem(<?php echo $product['id']; ?>)">X</span>
                        <img src="../<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p>Price: $<?php echo $product['price']; ?></p>
                        <!-- Agrega lógica para agregar al carrito desde la tabla products -->
                        <button onclick="removeCartItem(<?php echo $product['id']; ?>)">Delete</button>
                    </div>
        <?php
                }
            }

            // Enlace a la página de productos en caso de que el carrito esté vacío
            
        } else {
            echo "<p>No hay productos en el carrito.</p>";
        }
        ?>
    </main>

    <footer>
        <!-- Botón para ir al checkout -->
        <button onclick="goToCheckout()">Checkout</button>
        <!-- Botón para volver al catálogo de productos -->
        <button onclick="goToProducts()">Continue Shopping</button>
    </footer>

    <script>
    function removeCartItem(productId) {
        // Aquí puedes enviar una solicitud AJAX para eliminar el producto del carrito
        // Por ahora, simplemente ocultaremos el elemento del DOM

        // Encuentra el elemento del carrito con el ID correspondiente y ocúltalo
        var cartItem = document.getElementById(productId);
        if (cartItem) {
            cartItem.style.display = 'none';
        } else {
            alert('El producto con ID ' + productId + ' no fue encontrado en el carrito.');
        }

        // Aquí deberías enviar una solicitud AJAX al servidor para eliminar el producto del carrito
        // Puedes usar la función addToCart(productId) como ejemplo para implementar la lógica de AJAX
    }

    function goToCheckout() {
        window.location.href = 'profile.php';
    }

    function goToProducts() {
        window.location.href = '../index.php';
    }

    function addToCart(productId) {
        // Envia una solicitud AJAX al servidor
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add_to_cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        // Configura la función de devolución de llamada cuando la solicitud AJAX se complete
        xhr.onload = function () {
            if (xhr.status === 200) {
                // La solicitud fue exitosa, recarga la página para reflejar los cambios en tiempo real
                window.location.reload();
            } else {
                // Maneja los errores según sea necesario
                alert('Error al agregar el producto al carrito');
            }
        };

        // Construye los datos a enviar en la solicitud AJAX
        var params = "productId=" + productId;

        // Envía la solicitud AJAX con los datos
        xhr.send(params);
    }
</script>


</body>

</html>
