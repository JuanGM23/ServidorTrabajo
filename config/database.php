<?php

class Connection {
    public static function getConnection() {
        $host = 'localhost';
        $dbname = 'servidor_proyecto';
        $username = 'root';
        $password = 'Holajuan23';

        try {
            return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        } catch (PDOException $e) {
            // Puedes personalizar el mensaje de error según tus necesidades
            throw new Exception("Error de conexión a la base de datos. Por favor, inténtalo de nuevo más tarde.");
        }
    }
}

?>
