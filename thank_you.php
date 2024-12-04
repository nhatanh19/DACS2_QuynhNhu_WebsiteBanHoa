<?php
require_once './includes/session.php';

// Kiểm tra xem có order_id trong session không
if (!isset($_SESSION['order_id'])) {
    header('Location: index.php');
    exit();
}

$orderId = $_SESSION['order_id'];
?>

<?php include './layout/header.php'; ?>

<main class="container" style="margin-top: 100px;">
    <div class="text-center">
        <h1 class="display-4 mb-4">Cảm ơn bạn đã đặt hàng!</h1>
        <p class="lead">Đơn hàng #<?php echo $orderId; ?> của bạn đã được xác nhận.</p>
        <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.</p>
        <div class="mt-4">
            <a href="print_invoice.php?id=<?php echo $orderId; ?>" class="btn btn-primary" target="_blank">
                <i class="fas fa-print"></i> In hóa đơn
            </a>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-home"></i> Về trang chủ
            </a>
        </div>
    </div>
</main>

<?php 
include './layout/footer.php';
// Xóa order_id khỏi session sau khi hiển thị
unset($_SESSION['order_id']);
?>
