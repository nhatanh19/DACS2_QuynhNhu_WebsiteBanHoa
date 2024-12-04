<?php
class DashboardController {
    private $db;
    private $stats;

    public function __construct() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        // Kết nối database
        require_once BASE_PATH . "/config/database.php";
        $database = new Database();
        $this->db = $database->getConnection();

        // Khởi tạo thống kê
        $this->initializeStats();
    }

    private function initializeStats() {
        try {
            // Đếm số đơn hàng hôm nay
            $today = date('Y-m-d');
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = :today");
            $stmt->execute([':today' => $today]);
            $orders_today = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            // Đếm tổng số sản phẩm
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM products WHERE deleted_at IS NULL");
            $stmt->execute();
            $total_products = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            // Tính doanh thu
            $stmt = $this->db->prepare("SELECT SUM(total_amount) as revenue FROM orders WHERE status = 'completed'");
            $stmt->execute();
            $revenue = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'] ?? 0;

            // Đếm số khách hàng
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM customers WHERE deleted_at IS NULL");
            $stmt->execute();
            $customers = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

            $this->stats = [
                'orders_today' => $orders_today,
                'total_products' => $total_products,
                'revenue' => $revenue,
                'customers' => $customers
            ];
        } catch (PDOException $e) {
            // Nếu có lỗi, sử dụng giá trị mặc định
            $this->stats = [
                'orders_today' => 0,
                'total_products' => 0,
                'revenue' => 0,
                'customers' => 0
            ];
            error_log("Dashboard Stats Error: " . $e->getMessage());
        }
    }

    public function index() {
        $stats = $this->stats;
        require_once BASE_PATH . "/views/dashboard/index.php";
    }
}
?>
