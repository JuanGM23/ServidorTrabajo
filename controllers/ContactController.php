<?php
// contact_controller.php

require_once '../models/ContactModel.php';

class ContactController {
    private $model;

    public function __construct() {
        $this->model = new ContactModel();
    }

    public function showContactForm() {
        include '../views/contact_form_view.php';
    }

    public function processContactForm($name, $email, $message) {
        $success = $this->model->saveMessage($name, $email, $message);

        if ($success) {
            // Puedes redirigir a una página de éxito o mostrar un mensaje
            echo "¡Mensaje enviado con éxito!";
        } else {
            // Puedes redirigir a una página de error o mostrar un mensaje
            echo "Error al enviar el mensaje. Por favor, inténtalo de nuevo.";
        }
    }
}
?>
