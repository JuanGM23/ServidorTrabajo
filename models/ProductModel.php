<?php
class ProductModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        try {
            $query = "SELECT * FROM products";
            $result = $this->db->query($query);

            $products = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $products[] = $row;
            }

            return $products;
        } catch (PDOException $e) {
            // Manejar el error según tus necesidades
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getCartProducts() {
        try {
            $query = "SELECT * FROM products limit 3";
            
            $result = $this->db->query($query);

            $products = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $products[] = $row;
            }

            return $products;
        } catch (PDOException $e) {
            // Manejar el error según tus necesidades
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function getProductsByCategory($category) {
        try {
            $query = "SELECT * FROM products WHERE category = :category";
    
            if ($category === 'All') {
                $query = "SELECT * FROM products";
            }
    
            $stmt = $this->db->prepare($query);
    
            if ($category !== 'All') {
                $stmt->bindParam(':category', $category);
            }
    
            $stmt->execute();
    
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $products;
        } catch (PDOException $e) {
            // Manejar el error según tus necesidades
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    
    
}
?>
