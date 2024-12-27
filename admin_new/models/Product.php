<?php
class Product {
    private $conn;
    private $table = "products";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($data) {
        $sql = "INSERT INTO {$this->table} (category_id, name, slug, description, price, image, status) 
                VALUES (:category_id, :name, :slug, :description, :price, :image, :status)";
        
        // Tạo slug từ tên sản phẩm
        $slug = $this->createSlug($data['name']);
        
        $params = [
            ':category_id' => $data['category_id'],
            ':name' => $data['name'],
            ':slug' => $slug,
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':image' => $data['image'],
            ':status' => $data['status'] ?? 1
        ];

        return $this->conn->execute($sql, $params);
    }

    public function getAll() {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.deleted_at IS NULL 
                ORDER BY p.id DESC";
        return $this->conn->query($sql);
    }

    public function getById($id) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id AND p.deleted_at IS NULL";
        $params = [':id' => $id];
        return $this->conn->querySingle($sql, $params);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} 
                SET category_id = :category_id,
                    name = :name, 
                    slug = :slug,
                    description = :description,
                    price = :price,
                    status = :status";
        
        // Nếu có cập nhật hình ảnh
        if (!empty($data['image'])) {
            $sql .= ", image = :image";
        }
        
        $sql .= " WHERE id = :id";
        
        // Tạo slug từ tên sản phẩm
        $slug = $this->createSlug($data['name']);
        
        $params = [
            ':id' => $id,
            ':category_id' => $data['category_id'],
            ':name' => $data['name'],
            ':slug' => $slug,
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':status' => $data['status'] ?? 1
        ];

        // Thêm image parameter nếu có cập nhật hình ảnh
        if (!empty($data['image'])) {
            $params[':image'] = $data['image'];
        }

        return $this->conn->execute($sql, $params);
    }

    public function delete($id) {
        $sql = "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = :id";
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
