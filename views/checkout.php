<!-- checkout.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
    }

    form {
        margin-top: 20px;
        text-align: center;
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
        <!-- Puedes incluir información del usuario si está logueado -->
        <h1>CompetchStore</h1>
        <h1>Checkout</h1>
    </header>

    <main>
        <?php
        // ... Código para mostrar productos del carrito ...

        // Verifica si el carrito no está vacío antes de mostrar el formulario
        if (!empty($cartProducts)) {
        ?>
            <form action="process_order.php" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name" required><br>

                <label for="email">Email:</label>
                <input type="email" name="email" required><br>

                <!-- Agrega más campos según sea necesario para la información del cliente -->

                <input type="submit" value="Place Order">
            </form>
        <?php
        }
        ?>
    </main>

    <footer>
        <!-- Botón para volver al carrito -->
        <button onclick="goToCart()">Back to Cart</button>
    </footer>

    <!-- Agrega tus scripts y otros recursos al final del archivo -->

</body>

</html>
