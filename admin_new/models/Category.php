<?php
class Category {
    private $conn;
    private $table = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($data) {
        $sql = "INSERT INTO {$this->table} (name, slug, description) 
                VALUES (:name, :slug, :description)";
        
        // Tạo slug từ tên danh mục
        $slug = $this->createSlug($data['name']);
        
        $params = [
            ':name' => $data['name'],
            ':slug' => $slug,
            ':description' => $data['description']
        ];

        return $this->conn->execute($sql, $params);
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->conn->query($sql);
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = [':id' => $id];
        return $this->conn->querySingle($sql, $params);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET name = :name, 
                    slug = :slug, 
                    description = :description 
                WHERE id = :id";
        
        // Tạo slug từ tên danh mục
        $slug = $this->createSlug($data['name']);
        
        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':slug' => $slug,
            ':description' => $data['description']
        ];

        return $this->conn->execute($sql, $params);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $params = [':id' => $id];
        return $this->conn->execute($sql, $params);
    }

    private function createSlug($string) {
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9\-]/', '-', $string);
        $string = preg_replace('/-+/', "-", $string);
        $string = trim($string, '-');
        return $string;
    }
}
?>
