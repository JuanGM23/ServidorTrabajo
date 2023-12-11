<?php
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['userId'])) {
    echo "Error: Usuario no autenticado";
    exit;
}

// add_to_cart.php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Obtener el ID del producto desde la solicitud
        $productId = isset($_POST['productId']) ? $_POST['productId'] : null;

        // Verifica si el ID del producto es válido
        if ($productId === null) {
            throw new Exception("Error: ID de producto no válido.");
        }

        // Carga las configuraciones y archivos necesarios
        require_once __DIR__ . '/../config/database.php';
        require_once __DIR__ . '/../models/CartModel.php';

        // Obtiene la conexión a la base de datos
        $db = Connection::getConnection();

        // Crea una instancia del modelo del carrito
        $cartModel = new CartModel($db);

        // ID de usuario desde la sesión (asumiendo que está autenticado)
        $userId = $_SESSION['userId'];

        // Agrega el producto al carrito
        $quantity = 1; // Puedes cambiar la cantidad según tus necesidades
        $cartUpdateResult = $cartModel->addToCartAndUpdateMiniCart($productId, $quantity, $userId);

        // Verifica si hubo algún error al agregar al carrito
        if (isset($cartUpdateResult['error'])) {
            throw new Exception($cartUpdateResult['error']);
        }

        // Ejemplo de respuesta exitosa
        echo "Producto con ID $productId agregado al carrito.";
    } catch (Exception $e) {
        // Manejar la excepción de manera adecuada
        echo "Error: " . $e->getMessage();
    }
} else {
    // Manejar la solicitud incorrecta de alguna manera
    echo "Solicitud no válida.";
}
?>
