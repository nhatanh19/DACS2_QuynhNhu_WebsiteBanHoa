<?php
class User {
    private $conn;
    private $table_name = "tbl_admin";

    public $admin_id;
    public $admin_name;
    public $admin_email;
    public $admin_password;
    public $admin_role;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($email, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE admin_email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($password, $row['admin_password'])) {
                $this->admin_id = $row['admin_id'];
                $this->admin_name = $row['admin_name'];
                $this->admin_email = $row['admin_email'];
                $this->admin_role = $row['admin_role'];
                return true;
            }
        }
        return false;
    }

    public function register($name, $email, $password, $role = 'editor') {
        $query = "INSERT INTO " . $this->table_name . " 
                SET admin_name = :name, 
                    admin_email = :email, 
                    admin_password = :password,
                    admin_role = :role,
                    created_at = NOW()";

        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);

        return $stmt->execute();
    }

    public function emailExists($email) {
        $query = "SELECT admin_id FROM " . $this->table_name . " WHERE admin_email = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function updateProfile($id, $name, $email) {
        $query = "UPDATE " . $this->table_name . "
                SET admin_name = :name,
                    admin_email = :email
                WHERE admin_id = :id";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function updatePassword($id, $new_password) {
        $query = "UPDATE " . $this->table_name . "
                SET admin_password = :password
                WHERE admin_id = :id";

        $stmt = $this->conn->prepare($query);
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
?>
