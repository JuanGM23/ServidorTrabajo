<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../models/CartModel.php';

// Verificar si se ha enviado una acción
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Manejar la acción según sea necesario
    switch ($action) {
        case 'addToCart':
            addToCart();
            break;
        // Agrega más casos según sea necesario

        default:
            // Manejar una acción desconocida o no válida
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
}

// Función para agregar al carrito
function addToCart() {
    if (isset($_POST['serviceId']) && isset($_POST['serviceName']) && isset($_POST['servicePrice'])) {
        $serviceId = $_POST['serviceId'];
        $serviceName = $_POST['serviceName'];
        $servicePrice = $_POST['servicePrice'];

        // Aquí debes realizar la lógica para agregar al carrito
        // Por ejemplo, podrías insertar en la tabla 'cart'
        $cartModel = new CartModel();
        $result = $cartModel->addToCart($serviceId, $serviceName, $servicePrice);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Servicio agregado al carrito']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar al carrito']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Parámetros incompletos']);
    }
}
?>
