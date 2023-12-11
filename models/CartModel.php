<?php

class CartModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Resto de los métodos...

    public function addToCartAndUpdateMiniCart($productId, $quantity, $userId)
    {
        try {
            // Verificar si el producto existe en la tabla products
            $productInfo = $this->getProductInfo($productId);

            if (!$productInfo) {
                return [
                    "error" => "El producto no existe en la tabla products.",
                ];
            }

            // Verificar si el producto ya está en el carrito
            $existingCartItem = $this->getCartItem($productId, $userId);

            if ($existingCartItem) {
                // Si el producto ya está en el carrito, actualizar la cantidad
                $newQuantity = $existingCartItem['quantity'] + $quantity;
                $this->updateCartItemQuantity($productId, $newQuantity, $userId);
            } else {
                // Si el producto no está en el carrito, agregarlo
                $this->addNewCartItem($productId, $quantity, $userId);
            }

            // Obtener el precio total del carrito
            $totalPrice = $this->getTotalCartPrice($userId);

            // Retornar información adicional si es necesario
            return [
                "success" => true,
                "total_price" => $totalPrice,
            ];

        } catch (PDOException $e) {
            // Loguear el error o notificar al desarrollador
            error_log("Error adding product to cart: " . $e->getMessage());
            return [
                "error" => "Error adding product to cart",
            ];
        }
    }

    // Resto de los métodos...

    private function getCartItem($productId, $userId)
    {
        try {
            $query = "SELECT * FROM products WHERE id = :productId AND user_id = :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':productId', $productId);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Loguear el error o notificar al desarrollador
            error_log("Error getting cart item: " . $e->getMessage());
            return null;
        }
    }

    private function addNewCartItem($productId, $quantity, $userId)
    {
        $query = "INSERT INTO products_cart (product_id, quantity, user_id) VALUES (:productId, :quantity, :userId)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
    }
    public function getTotalCartPrice($userId)
    {
        try {
            $query = "SELECT SUM(products.price * cart.quantity) AS total_price
                      FROM cart
                      JOIN products ON cart.product_id = products.id
                      WHERE cart.user_id = :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_price'] ?: 0;
        } catch (PDOException $e) {
            // Loguear el error o notificar al desarrollador
            error_log("Error getting total cart price: " . $e->getMessage());
            return 0;
        }
    }
    public function getThreeProductsFromDatabase()
    {
        try {
            $sql = "SELECT id, name, description, price, category, image_url FROM products LIMIT 3";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $products;
        } catch (PDOException $e) {
            // Loguear el error o lanzar una excepción personalizada
            throw new Exception("Error fetching products from the database: " . $e->getMessage());
        }
    }

    public function saveCartState($userId, $cartData)
    {
        try {
            // Guardar el estado actualizado del carrito en la base de datos
            // (Esto podría incluir la cantidad actualizada de cada producto, etc.)
            // Ejemplo: $cartData = [ ['product_id' => 1, 'quantity' => 3], ... ]
            foreach ($cartData as $cartItem) {
                $productId = $cartItem['product_id'];
                $quantity = $cartItem['quantity'];
                $this->updateCartItemQuantity($productId, $quantity, $userId);
            }

            // Obtener el precio total del carrito después de la actualización
            $totalPrice = $this->getTotalCartPrice($userId);

            // Retornar información adicional si es necesario
            return [
                "success" => true,
                "total_price" => $totalPrice,
            ];

        } catch (PDOException $e) {
            // Loguear el error o notificar al desarrollador
            error_log("Error saving cart state: " . $e->getMessage());
            return [
                "error" => "Error saving cart state",
            ];
        }
    }
    private function getProductInfo($productId)
    {
        try {
            $query = "SELECT * FROM products WHERE id = :productId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':productId', $productId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Loguear el error o notificar al desarrollador
            error_log("Error getting product info: " . $e->getMessage());
            return null;
        }
    }
}

?>
