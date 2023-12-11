<?php
// Importa la clase Connection
require_once __DIR__ . '/../config/database.php';

// Asegúrate de tener la referencia al modelo
require_once __DIR__ . '/../models/ProductModel.php';

class Cart {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function getAllProducts($category = null) {
        // Obtén todos los productos o filtra por categoría si se proporciona
        $products = ($category === null) ? $this->model->getAllProducts() : $this->model->getProductsByCategory($category);

        // Aquí podrías llamar a una vista para mostrar los productos, o devolver los datos como JSON, según tus necesidades.
        // Por ejemplo, si estás trabajando con una vista en HTML, podrías hacer algo como:
        include '../views/products_view.php';
    }

    public function getProductsByCategory($category) {
        // Implementa la lógica para obtener productos por categoría
        // Puedes utilizar el modelo para interactuar con la base de datos
        $products = $this->model->getProductsByCategory($category);

        // Retorna los productos o realiza las acciones necesarias
        return $products;
    }
    public function getCartProducts() {
        // Implementa la lógica para obtener productos por categoría
        // Puedes utilizar el modelo para interactuar con la base de datos
        $products = $this->model->getCartProducts();

        // Retorna los productos o realiza las acciones necesarias
        return $products;
    }
}

// Crea una instancia del modelo y del controlador
$model = new ProductModel(Connection::getConnection());
$Cart = new Cart($model);

// Obtén la categoría seleccionada (si se proporciona)
$category = isset($_GET['category']) ? $_GET['category'] : null;

// Llama al método para obtener todos los productos o filtrar por categoría
$Cart->getCartProducts();



?>