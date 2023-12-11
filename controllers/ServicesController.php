<?php
// services_controller.php

require_once '../models/ServicesModel.php';

class ServicesController {
    private $model;

    public function __construct() {
        $this->model = new ServicesModel();
    }

    public function showServices() {
        $services = $this->model->getAllServices();
        include 'services_view.php';
    }
}
?>
