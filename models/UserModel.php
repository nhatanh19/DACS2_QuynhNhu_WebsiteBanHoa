<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $email, $password, $phone, $province, $district, $ward, $specific_address) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $address = $province . '- ' . $district . '- ' . $ward . '- ' . $specific_address;
        
        
        $sql = "INSERT INTO users (username, email, password, phone, address) 
                VALUES (?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$username, $email, $hashed_password, $phone, $address]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function isEmailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function isPhoneExists($phone) {
        $sql = "SELECT COUNT(*) FROM users WHERE phone = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$phone]);
        return $stmt->fetchColumn() > 0;
    }

    public function login($phone, $password) {
        $sql = "SELECT id, password FROM users WHERE phone = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$phone]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }
        return false;
    }
}
