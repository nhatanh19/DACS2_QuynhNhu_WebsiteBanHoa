<?php
require_once 'includes/session.php';
require_once 'database.php';

$conn = require 'database.php';

// Lấy ID đơn hàng mới nhất của người dùng
$stmt = $conn->prepare("SELECT id FROM orders ORDER BY created_at DESC LIMIT 1");
$stmt->execute();
$lastOrder = $stmt->fetch(PDO::FETCH_ASSOC);
$orderId = $lastOrder ? $lastOrder['id'] : null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Flower Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include './layout/header.php'; ?>

    <main class="container py-5">
        <div class="text-center">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
            <h1 class="mt-4 mb-3">Đặt hàng thành công!</h1>
            <p class="lead">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
            <?php if ($orderId): ?>
                <p class="mb-0">Mã đơn hàng của bạn là: #<?php echo $orderId; ?></p>
                <div class="mt-3">
                    <a href="view-order.php?order_id=<?php echo $orderId; ?>" class="btn btn-primary">Xem hóa đơn</a>
                </div>
            <?php endif; ?>
            <div class="mt-4">
                <a href="index.php" class="btn btn-primary me-2">Về trang chủ</a>
                <a href="profile.php" class="btn btn-outline-primary">Xem đơn hàng</a>
            </div>
        </div>
    </main>

    <?php include './layout/footer.php'; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
