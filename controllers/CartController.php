<?php

class CartController
{
    private $cartModel;

    public function __construct($cartModel)
    {
        $this->cartModel = $cartModel;
    }

    public function addToCart($productId, $quantity, $userId)
    {
        try {
            // Intenta agregar el producto al carrito y actualizar el mini carrito
            $cartUpdateResult = $this->cartModel->addToCartAndUpdateMiniCart($productId, $quantity, $userId);

            // Verifica si hubo algún error al agregar al carrito
            if (isset($cartUpdateResult['error'])) {
                // Podrías redirigir a una página de error en lugar de imprimir el mensaje aquí
                echo $cartUpdateResult['error'];
                exit();
            }

            // Redirige a la página de productos después de agregar al carrito
            header("Location: ../views/products_view.php");
            exit();

        } catch (PDOException $e) {
            // Loguear el error o redirigir a una página de error general
            error_log("Error adding product to cart: " . $e->getMessage());
            echo "Error: There was an issue adding the product to the cart.";
        }
    }

    public function updateCartItemQuantity($productId, $quantity, $userId)
    {
        try {
            // Intenta actualizar la cantidad del producto en el carrito y actualizar el mini carrito
            $cartUpdateResult = $this->cartModel->updateCartItemQuantity($productId, $quantity, $userId);

            // Verifica si hubo algún error al actualizar la cantidad
            if (isset($cartUpdateResult['error'])) {
                // Podrías redirigir a una página de error en lugar de imprimir el mensaje aquí
                echo $cartUpdateResult['error'];
                exit();
            }

            // Redirige a la página de carrito después de actualizar la cantidad
            header("Location: ../views/cart_view.php");
            exit();

        } catch (PDOException $e) {
            // Loguear el error o redirigir a una página de error general
            error_log("Error updating cart item quantity: " . $e->getMessage());
            echo "Error: There was an issue updating the quantity of the cart item.";
        }
    }

    public function removeCartItem($productId, $userId)
    {
        try {
            // Intenta eliminar el producto del carrito y actualizar el mini carrito
            $cartUpdateResult = $this->cartModel->removeCartItemAndUpdateMiniCart($productId, $userId);

            // Verifica si hubo algún error al eliminar el producto
            if (isset($cartUpdateResult['error'])) {
                // Podrías redirigir a una página de error en lugar de imprimir el mensaje aquí
                echo $cartUpdateResult['error'];
                exit();
            }

            // Redirige a la página de carrito después de eliminar el producto
            header("Location: ../views/cart_view.php");
            exit();

        } catch (PDOException $e) {
            // Loguear el error o redirigir a una página de error general
            error_log("Error removing cart item: " . $e->getMessage());
            echo "Error: There was an issue removing the product from the cart.";
        }
    }

    // Otros métodos del controlador...

    // Ejemplo de un método para obtener el contenido del carrito y mostrarlo en la vista del carrito
    public function showCart($userId)
    {
        // Lógica para obtener el contenido del carrito del modelo
        $cartItems = $this->cartModel->getCartItems($userId);

        // Lógica para mostrar la vista del carrito con los elementos obtenidos
        include('../views/cart_view.php');
    }
    public function getThreeProducts()
    {
        try {
            // Llamada al método del modelo para obtener los productos
            $products = $this->cartModel->getThreeProductsFromDatabase();

            // Mostrar la vista del carrito con los productos obtenidos
            include('../views/cart_view.php');
        } catch (PDOException $e) {
            // Loguear el error o redirigir a una página de error general
            error_log("Error fetching products for cart view: " . $e->getMessage());
            echo "Error: There was an issue fetching products for the cart view.";
        }
    }
}


?>
