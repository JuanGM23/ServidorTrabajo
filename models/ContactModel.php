<?php
// contact_model.php

require_once '../config/database.php';

class ContactModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function saveMessage($name, $email, $message) {
        try {
            $query = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$name, $email, $message]);

            return true;
        } catch (PDOException $e) {
            // Manejar el error según tus necesidades
            throw new Exception("Error al guardar el mensaje de contacto: " . $e->getMessage());
        }
    }
}
?>
