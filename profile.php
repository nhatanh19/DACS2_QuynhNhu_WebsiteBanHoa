<?php
require_once './includes/session.php';
require_once './database.php';
require_once './controllers/OrderController.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$orderController = new OrderController($conn);
$orders = $orderController->getUserOrders($_SESSION['user_id']);

// Lấy thông tin user
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Xử lý thay đổi mật khẩu
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Kiểm tra mật khẩu hiện tại
    if (password_verify($currentPassword, $user['password'])) {
        // Kiểm tra mật khẩu mới và xác nhận
        if ($newPassword === $confirmPassword) {
            if (strlen($newPassword) >= 6) {
                // Cập nhật mật khẩu mới
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                if ($updateStmt->execute([$hashedPassword, $userId])) {
                    $message = 'Mật khẩu đã được cập nhật thành công!';
                    $messageType = 'success';
                } else {
                    $message = 'Có lỗi xảy ra, vui lòng thử lại!';
                    $messageType = 'danger';
                }
            } else {
                $message = 'Mật khẩu mới phải có ít nhất 6 ký tự!';
                $messageType = 'danger';
            }
        } else {
            $message = 'Mật khẩu mới và xác nhận mật khẩu không khớp!';
            $messageType = 'danger';
        }
    } else {
        $message = 'Mật khẩu hiện tại không đúng!';
        $messageType = 'danger';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản - Flower Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-section {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
            border: 5px solid #f8f9fa;
        }
        .nav-pills .nav-link.active {
            background-color: #ff69b4;
        }
        .nav-pills .nav-link {
            color: #333;
        }
        .nav-pills .nav-link:hover {
            background-color: #ffe6f2;
        }
        .btn-primary {
            background-color: #ff69b4;
            border-color: #ff69b4;
        }
        .btn-primary:hover {
            background-color: #ff1493;
            border-color: #ff1493;
        }
    </style>
</head>
<body>
    <?php include './layout/header.php'; ?>

    <main class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <div class="profile-section">
                    <div class="profile-header">
                        <img src="<?php echo !empty($user['avatar']) ? $user['avatar'] : 'assets/images/default-avatar.jpg'; ?>" 
                             alt="Avatar" class="profile-avatar">
                        <h4><?php echo htmlspecialchars($user['username'] ?? 'Người dùng'); ?></h4>
                        <p class="text-muted"><?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
                    </div>
                    <div class="nav flex-column nav-pills" role="tablist">
                        <button class="nav-link active mb-2" data-bs-toggle="pill" data-bs-target="#profile-info">
                            <i class="fas fa-user me-2"></i>Thông tin cá nhân
                        </button>
                        <button class="nav-link mb-2" data-bs-toggle="pill" data-bs-target="#change-password">
                            <i class="fas fa-key me-2"></i>Đổi mật khẩu
                        </button>
                        <button class="nav-link mb-2" data-bs-toggle="pill" data-bs-target="#order-history">
                            <i class="fas fa-history me-2"></i>Lịch sử đơn hàng
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="tab-content">
                    <!-- Thông tin cá nhân -->
                    <div class="tab-pane fade show active" id="profile-info">
                        <div class="profile-section">
                            <h3 class="mb-4">Thông tin cá nhân</h3>
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Địa chỉ</label>
                                    <textarea class="form-control" rows="3" readonly><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Đổi mật khẩu -->
                    <div class="tab-pane fade" id="change-password">
                        <div class="profile-section">
                            <h3 class="mb-4">Đổi mật khẩu</h3>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu hiện tại</label>
                                    <input type="password" class="form-control" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input type="password" class="form-control" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Xác nhận mật khẩu mới</label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                                <button type="submit" name="change_password" class="btn btn-primary">
                                    Đổi mật khẩu
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Lịch sử đơn hàng -->
                    <div class="tab-pane fade" id="order-history">
                        <div class="profile-section">
                            <h3 class="mb-4">Lịch sử đơn hàng</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Ngày đặt</th>
                                            <th>Số sản phẩm</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th>Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($orders)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center">Chưa có đơn hàng nào</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($orders as $order): ?>
                                                <tr>
                                                    <td>#<?php echo $order['id']; ?></td>
                                                    <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                                    <td><?php echo $order['total_items']; ?></td>
                                                    <td><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</td>
                                                    <td>
                                                        <span class="badge bg-<?php echo $order['status'] == 'completed' ? 'success' : 'warning'; ?>">
                                                            <?php echo $order['status'] == 'completed' ? 'Hoàn thành' : 'Đang xử lý'; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#orderModal<?php echo $order['id']; ?>">
                                                            Xem
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php foreach ($orders as $order): 
        $orderDetails = $orderController->getOrderDetails($order['id']);
    ?>
        <div class="modal fade" id="orderModal<?php echo $order['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết đơn hàng #<?php echo $order['id']; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6>Thông tin đơn hàng</h6>
                                <p><strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></p>
                                <p><strong>Trạng thái:</strong> 
                                    <span class="badge bg-<?php echo $order['status'] == 'completed' ? 'success' : 'warning'; ?>">
                                        <?php echo $order['status'] == 'completed' ? 'Hoàn thành' : 'Đang xử lý'; ?>
                                    </span>
                                </p>
                                <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Thông tin giao hàng</h6>
                                <p><strong>Người nhận:</strong> <?php echo htmlspecialchars($order['customer_name']); ?></p>
                                <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order['phone']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                                <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                                <?php if (!empty($order['note'])): ?>
                                    <p><strong>Ghi chú:</strong> <?php echo htmlspecialchars($order['note']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <h6>Chi tiết sản phẩm</h6>
                        <div class="table-responsive">
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
                                    <?php foreach ($orderDetails['items'] as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['image_url']): ?>
                                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                                             alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                             class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                                </div>
                                            </td>
                                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</td>
                                            <td><?php echo $item['quantity']; ?></td>
                                            <td><?php echo number_format($item['subtotal'], 0, ',', '.'); ?>đ</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                                        <td><strong><?php echo number_format($order['total_amount'], 0, ',', '.'); ?>đ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
