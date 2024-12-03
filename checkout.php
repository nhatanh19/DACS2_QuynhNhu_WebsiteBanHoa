<?php
require_once 'database.php';
$conn = require 'database.php';

// Lấy thông tin sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;

try {
    // Lấy thông tin sản phẩm
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        die("Không tìm thấy sản phẩm");
    }

    // Tính tổng tiền
    $total = $product['price'] * $quantity;
} catch (PDOException $e) {
    die("Lỗi: " . $e->getMessage());
}
?>

<?php include './layout/header.php'; ?>

<main class="container" style="margin-top: 100px;">
    <div class="row">
        <div class="col-md-8">
            <h2 class="mb-4">Thông tin thanh toán</h2>
            <form id="checkout-form" method="POST" action="process_order.php">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                
                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ giao hàng</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Ghi chú</label>
                    <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Xác nhận đặt hàng</button>
            </form>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Đơn hàng của bạn</h3>
                    <div class="product-summary mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo htmlspecialchars($product['name']); ?> x <?php echo $quantity; ?></span>
                            <span><?php echo number_format($product['price'] * $quantity, 0, ',', '.'); ?>đ</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Tổng cộng:</strong>
                            <strong class="text-primary"><?php echo number_format($total, 0, ',', '.'); ?>đ</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include './layout/footer.php'; ?>
