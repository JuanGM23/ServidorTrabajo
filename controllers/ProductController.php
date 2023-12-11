<?php
// Importa la clase Connection
require_once __DIR__ . '/../config/database.php';

// Asegúrate de tener la referencia al modelo
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getAllProducts($category = null) {
        // Obtén todos los productos o filtra por categoría si se proporciona
        $products = ($category === null) ? $this->model->getAllProducts() : $this->model->getProductsByCategory($category);

        // Aquí podrías llamar a una vista para mostrar los productos, o devolver los datos como JSON, según tus necesidades.
        // Por ejemplo, si estás trabajando con una vista en HTML, podrías hacer algo como:
        include 'views/products_view.php';
    }

    public function getProductsByCategory($category) {
        // Verifica si la categoría proporcionada es válida
        if (empty($category)) {
            // Puedes lanzar una excepción, enviar un mensaje de error, o manejarlo según tus necesidades
            throw new Exception("Categoría no válida");
        }
    
        try {
            // Llama al método del modelo para obtener los productos por categoría
            $products = $this->model->getProductsByCategory($category);
    
            // Verifica si se obtuvieron productos
            if (!$products) {
                // Puedes lanzar una excepción, enviar un mensaje de error, o manejarlo según tus necesidades
                throw new Exception("No se encontraron productos para la categoría: $category");
            }
    
            // Retorna los productos
            return $products;
        } catch (Exception $e) {
            // Puedes manejar la excepción según tus necesidades, por ejemplo, registrándola o mostrando un mensaje de error al usuario
            error_log("Error al obtener productos por categoría: " . $e->getMessage());
            // Puedes lanzar la excepción nuevamente si deseas que otros controladores o funciones la manejen
            throw $e;
        }
    }
    

}
// Crea una instancia del modelo y del controlador
$model = new ProductModel(Connection::getConnection());
$productController = new ProductController($model);

// Obtén la categoría seleccionada (si se proporciona)
$category = isset($_GET['category']) ? $_GET['category'] : null;

// Llama al método para obtener todos los productos o filtrar por categoría
$productController->getAllProducts($category);


?>
