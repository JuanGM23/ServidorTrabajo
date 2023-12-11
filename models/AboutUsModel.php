<?php

require_once '../config/database.php';

class AboutUsModel {
    public function getRoles() {
        $db = new Connection();
        $conn = $db->getConnection();

        $query = "SELECT * FROM about_us";
        $result = $conn->query($query);

        $roles = $result->fetchAll(PDO::FETCH_ASSOC);

        $conn = null;
        return $roles;
    }
}

?>
