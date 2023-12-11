<?php
// services_model.php

require_once '../config/database.php'; 

class ServicesModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    public function getAllServices() {
        $query = "SELECT * FROM services";
        $stmt = $this->db->query($query);

        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
?>
