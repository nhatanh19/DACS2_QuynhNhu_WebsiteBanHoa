<?php
require_once './includes/session.php';
require_once './database.php';
require_once './controllers/OrderController.php';

if (!isset($_GET['id'])) {
    header('Location: profile.php');
    exit();
}

$orderId = (int)$_GET['id'];
$orderController = new OrderController($conn);
$orderDetails = $orderController->getOrderDetails($orderId);

if (!$orderDetails || $orderDetails['user_id'] != $_SESSION['user_id']) {
    header('Location: profile.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn #<?php echo $orderId; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }
            .print-only {
                display: block;
            }
        }
        .invoice-header {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
        }
        .company-info {
            margin-bottom: 2rem;
        }
        .customer-info {
            margin-bottom: 2rem;
        }
        .table th {
            background-color: #f8f9fa;
        }
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="invoice-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h4 class="mb-0">FLOWER SHOP</h4>
                            <p class="mb-0">Website: flowershop.com</p>
                            <p class="mb-0">Email: contact@flowershop.com</p>
                            <p class="mb-0">Điện thoại: (123) 456-7890</p>
                        </div>
                        <div class="col-6 text-end">
                            <h1 class="mb-0">HÓA ĐƠN</h1>
                            <p class="mb-0">Số: #<?php echo $orderId; ?></p>
                            <p class="mb-0">Ngày: <?php echo date('d/m/Y H:i', strtotime($orderDetails['created_at'])); ?></p>
                        </div>
                    </div>
                </div>

                <div class="customer-info">
                    <h5>Thông tin khách hàng:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($orderDetails['customer_name']); ?></p>
                            <p><strong>Điện thoại:</strong> <?php echo htmlspecialchars($orderDetails['phone']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($orderDetails['email']); ?></p>
                            <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($orderDetails['address']); ?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Trạng thái:</strong> 
                                <span class="badge bg-<?php echo $orderDetails['status'] == 'completed' ? 'success' : 'warning'; ?>">
                                    <?php echo $orderDetails['status'] == 'completed' ? 'Hoàn thành' : 'Đang xử lý'; ?>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th class="text-end">Đơn giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt = 1; foreach ($orderDetails['items'] as $item): ?>
                                <tr>
                                    <td><?php echo $stt++; ?></td>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td class="text-end"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                    <td class="text-center"><?php echo $item['quantity']; ?></td>
                                    <td class="text-end"><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                                <td class="text-end"><strong><?php echo number_format($orderDetails['total_amount'], 0, ',', '.'); ?>đ</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-8">
                        <h6>Ghi chú:</h6>
                        <p><?php echo !empty($orderDetails['note']) ? htmlspecialchars($orderDetails['note']) : 'Không có'; ?></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <p><strong>Người bán hàng</strong></p>
                        <p class="mt-4">FLOWER SHOP</p>
                    </div>
                </div>

                <div class="mt-4 text-center no-print">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> In hóa đơn
                    </button>
                    <a href="profile.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html>
