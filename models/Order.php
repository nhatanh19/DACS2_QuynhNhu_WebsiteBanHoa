<?php
class Order {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getOrdersByUserId($userId) {
        $sql = "SELECT o.*, COUNT(od.id) as total_items
                FROM orders o 
                LEFT JOIN order_details od ON o.id = od.order_id
                WHERE o.user_id = :userId 
                GROUP BY o.id
                ORDER BY o.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($orderId) {
        // Lấy thông tin đơn hàng
        $sql = "SELECT o.* FROM orders o WHERE o.id = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) {
            return null;
        }
        
        // Lấy chi tiết các sản phẩm trong đơn hàng
        $sql = "SELECT od.*, p.name as product_name, p.image_url 
                FROM order_details od 
                JOIN products p ON od.product_id = p.id 
                WHERE od.order_id = :orderId";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $order;
    }
}
