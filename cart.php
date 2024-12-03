<?php
require_once 'includes/session.php';
require_once 'database.php';
require_once 'cart_functions.php';

$conn = require 'database.php';

// Xử lý các action từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = ['success' => false, 'message' => ''];
    
    // Xử lý AJAX request
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['action'])) {
            switch ($data['action']) {
                case 'update':
                    $result = updateCartQuantity($data['product_id'], $data['quantity']);
                    $response = $result;
                    break;
                case 'remove':
                    $result = removeFromCart($data['product_id']);
                    $response = $result;
                    break;
                case 'clear':
                    $result = clearCart();
                    $response = $result;
                    break;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    } 
    // Xử lý form submit thông thường
    else {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'update':
                    updateCartQuantity($_POST['product_id'], $_POST['quantity']);
                    break;
                case 'remove':
                    removeFromCart($_POST['product_id']);
                    break;
                case 'clear':
                    clearCart();
                    break;
            }
        }
        // Redirect để tránh form resubmission
        header('Location: cart.php');
        exit;
    }
}

// Lấy thông tin giỏ hàng
$cartResult = getCartItems($conn);
$cartItems = $cartResult['success'] ? $cartResult['items'] : [];

// Lấy tổng giá trị giỏ hàng
$totalResult = getCartTotal($conn);
$cartTotal = $totalResult['success'] ? $totalResult['total'] : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - Flower Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .cart-item {
            transition: all 0.3s ease;
        }
        .cart-item:hover {
            background-color: #f8f9fa;
        }
        .cart-item img {
            max-height: 100px;
            object-fit: cover;
        }
        .quantity-input {
            width: 120px;
            display: inline-flex;
        }
        .quantity-input .form-control {
            width: 50px;
            text-align: center;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
            padding: 0.375rem 0.5rem;
        }
        .quantity-input .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            line-height: 1.5;
            border-radius: 0;
        }
        .quantity-input .btn:first-child {
            border-top-left-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
        }
        .quantity-input .btn:last-child {
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
        }
        .remove-item {
            color: #dc3545;
            cursor: pointer;
        }
        .remove-item:hover {
            color: #c82333;
        }
        @media (max-width: 768px) {
            .quantity-input {
                width: 100px;
            }
            .quantity-input .form-control {
                width: 40px;
                padding: 0.25rem;
            }
            .quantity-input .btn {
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include './layout/header.php'; ?>

    <main class="container py-5">
        <h1 class="mb-4">Giỏ hàng của bạn</h1>

        <?php if (empty($cartItems)): ?>
            <div class="alert alert-info">
                Giỏ hàng của bạn đang trống. <a href="cartegory.php" class="alert-link">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="cart-item mb-3 pb-3 border-bottom" data-product-id="<?php echo $item['id']; ?>">
                                    <div class="row align-items-center">
                                        <div class="col-md-2 col-3">
                                            <img src="<?php echo htmlspecialchars($item['image_url']); ?>" 
                                                 class="img-fluid rounded" 
                                                 alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        </div>
                                        <div class="col-md-4 col-9">
                                            <h5 class="mb-1">
                                                <a href="product.php?id=<?php echo $item['id']; ?>" class="text-decoration-none text-dark">
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                </a>
                                            </h5>
                                            <p class="text-muted mb-0"><?php echo number_format($item['price'], 0, ',', '.'); ?>đ</p>
                                        </div>
                                        <div class="col-md-3 col-6 mt-3 mt-md-0">
                                            <div class="quantity-input">
                                                <button type="button" class="btn btn-outline-secondary decrease-quantity" data-product-id="<?php echo $item['id']; ?>">-</button>
                                                <input type="text" 
                                                       class="form-control item-quantity" 
                                                       value="<?php echo $item['quantity']; ?>" 
                                                       min="1" 
                                                       data-product-id="<?php echo $item['id']; ?>"
                                                       readonly>
                                                <button type="button" class="btn btn-outline-secondary increase-quantity" data-product-id="<?php echo $item['id']; ?>">+</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-4 text-end mt-3 mt-md-0">
                                            <strong class="item-total"><?php echo number_format($item['total'], 0, ',', '.'); ?>đ</strong>
                                        </div>
                                        <div class="col-md-1 col-2 text-end mt-3 mt-md-0">
                                            <button type="button" class="btn btn-link text-danger remove-item p-0">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-outline-danger clear-cart">
                                    <i class="fas fa-trash me-2"></i>Xóa giỏ hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Tổng giỏ hàng</h5>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tạm tính:</span>
                                <strong class="cart-subtotal"><?php echo number_format($cartTotal, 0, ',', '.'); ?>đ</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>VAT (10%):</span>
                                <strong class="cart-vat"><?php echo number_format($cartTotal * 0.1, 0, ',', '.'); ?>đ</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Phí vận chuyển:</span>
                                <span>Miễn phí</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span>Tổng cộng:</span>
                                <strong class="cart-total"><?php echo number_format($cartTotal * 1.1, 0, ',', '.'); ?>đ</strong>
                            </div>
                            <a href="checkout.php" class="btn btn-primary w-100">
                                Tiến hành thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include './layout/footer.php'; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý tăng giảm số lượng
        document.querySelectorAll('.decrease-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const input = this.parentElement.querySelector('.item-quantity');
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateQuantity(productId, currentValue - 1);
                }
            });
        });

        document.querySelectorAll('.increase-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.productId;
                const input = this.parentElement.querySelector('.item-quantity');
                const currentValue = parseInt(input.value);
                input.value = currentValue + 1;
                updateQuantity(productId, currentValue + 1);
            });
        });

        // Hàm cập nhật số lượng
        async function updateQuantity(productId, quantity) {
            try {
                // Hiển thị loading
                Swal.fire({
                    title: 'Đang cập nhật...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const response = await fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        action: 'update',
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    // Đóng loading và tải lại trang
                    Swal.close();
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: result.message || 'Không thể cập nhật số lượng'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Đã có lỗi xảy ra, vui lòng thử lại'
                });
            }
        }

        // Xử lý xóa sản phẩm
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.closest('.cart-item').dataset.productId;
                removeItem(productId);
            });
        });

        // Hàm xóa sản phẩm
        async function removeItem(productId) {
            try {
                const response = await fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        action: 'remove',
                        product_id: productId
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    location.reload(); // Tải lại trang sau khi xóa
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: result.message || 'Không thể xóa sản phẩm'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Đã có lỗi xảy ra, vui lòng thử lại'
                });
            }
        }

        // Xử lý xóa toàn bộ giỏ hàng
        document.querySelector('.clear-cart')?.addEventListener('click', function() {
            Swal.fire({
                title: 'Xác nhận xóa',
                text: 'Bạn có chắc muốn xóa toàn bộ giỏ hàng?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    clearCart();
                }
            });
        });

        // Hàm xóa toàn bộ giỏ hàng
        async function clearCart() {
            try {
                const response = await fetch('cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        action: 'clear'
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    location.reload(); // Tải lại trang sau khi xóa
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: result.message || 'Không thể xóa giỏ hàng'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: 'Đã có lỗi xảy ra, vui lòng thử lại'
                });
            }
        }
    });
    </script>
</body>
</html>
