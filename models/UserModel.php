    <?php

    require_once '../config/database.php';

    class UserModel {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function registerUser($username, $password, $email, $address) {
            try {
                if ($this->userExists($username)) {
                    return false; // El usuario ya está registrado
                }

                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ["cost" => 4]);

                $query = "INSERT INTO users (username, password, email, address) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$username, $hashedPassword, $email, $address]);

                return true; // Registro exitoso
            } catch (PDOException $e) {
                throw new Exception("Error al registrar usuario: " . $e->getMessage());
            } finally {
                $stmt = null; // Cerrar la conexión
            }
        }

        public function loginUser($username, $password) {
            try {
                $username = trim($username);
                $userInfo = $this->getUserByUsername($username);

                return $userInfo !== null && password_verify($password, $userInfo['password']);
            } catch (PDOException $e) {
                throw new Exception("Error al iniciar sesión (PDOException): " . $e->getMessage());
            } catch (Exception $e) {
                throw new Exception("Error general al iniciar sesión: " . $e->getMessage());
            }
        }

        private function userExists($username) {
            try {
                $query = "SELECT COUNT(*) FROM users WHERE username = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$username]);

                return $stmt->fetchColumn() > 0;
            } catch (PDOException $e) {
                throw new Exception("Error al verificar si el usuario existe: " . $e->getMessage());
            } finally {
                $stmt = null; // Cerrar la conexión
            }
        }

        public function getUserByUsername($username) {
            try {
                $query = "SELECT * FROM users WHERE username = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$username]);

                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception("Error al obtener información del usuario: " . $e->getMessage());
            } finally {
                $stmt = null; // Cerrar la conexión
            }
        }
        public function changePassword($username, $hashedPassword) {
            try {
                $query = "UPDATE users SET password = ? WHERE username = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$hashedPassword, $username]);
            } catch (PDOException $e) {
                throw new Exception("Error al cambiar la contraseña: " . $e->getMessage());
            } finally {
                $stmt = null;
            }
        }
        
        public function deleteUser($username) {
            try {
                $query = "DELETE FROM users WHERE username = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$username]);
            } catch (PDOException $e) {
                throw new Exception("Error al eliminar la cuenta: " . $e->getMessage());
            } finally {
                $stmt = null;
            }
        }
    }
