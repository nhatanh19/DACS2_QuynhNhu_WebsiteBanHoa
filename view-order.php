<?php
require_once 'includes/session.php';
require_once 'database.php';

$conn = require 'database.php';

// Kiểm tra nếu có order_id được truyền vào
if (!isset($_GET['order_id'])) {
    header('Location: index.php');
    exit;
}

$order_id = $_GET['order_id'];

// Lấy thông tin đơn hàng
$stmt = $conn->prepare("SELECT o.*, p.name as product_name, p.price 
                       FROM orders o 
                       JOIN products p ON o.product_id = p.id 
                       WHERE o.id = :order_id");
$stmt->execute(['order_id' => $order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?php echo $order_id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bill {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .bill-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }
        .bill-info {
            margin-bottom: 20px;
        }
        .bill-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="bill">
            <div class="bill-header">
                <h2>HÓA ĐƠN BÁN HÀNG</h2>
                <p>Mã đơn hàng: #<?php echo $order_id; ?></p>
                <p>Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
            </div>

            <div class="bill-info">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Thông tin khách hàng:</h5>
                        <p>Tên: <?php echo htmlspecialchars($order['customer_name']); ?></p>
                        <p>Số điện thoại: <?php echo htmlspecialchars($order['phone']); ?></p>
                        <p>Email: <?php echo htmlspecialchars($order['email']); ?></p>
                        <p>Địa chỉ: <?php echo htmlspecialchars($order['address']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h5>Trạng thái đơn hàng:</h5>
                        <p>Tình trạng: <span class="badge bg-<?php echo $order['status'] == 'pending' ? 'warning' : 'success'; ?>">
                            <?php echo $order['status'] == 'pending' ? 'Đang xử lý' : 'Hoàn thành'; ?>
                        </span></p>
                    </div>
                </div>
            </div>

            <div class="bill-details">
                <h5>Chi tiết đơn hàng:</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo number_format($order['price'], 0, ',', '.'); ?>đ</td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bill-total">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Ghi chú:</strong></p>
                        <p><?php echo htmlspecialchars($order['note'] ?: 'Không có ghi chú'); ?></p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5>Tổng tiền: <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</h5>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 no-print">
                <button class="btn btn-primary me-2" onclick="window.print()">In hóa đơn</button>
                <a href="index.php" class="btn btn-secondary">Quay lại trang chủ</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
