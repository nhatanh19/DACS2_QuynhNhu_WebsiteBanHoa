<?php
require_once 'includes/session.php';
require_once 'database.php';
require_once 'cart_functions.php';

$conn = require 'database.php';

// Lấy thông tin người dùng từ session nếu đã đăng nhập
$userInfo = isLoggedIn() ? getCurrentUser($conn) : null;

// Xử lý mua hàng trực tiếp từ trang sản phẩm
if (isset($_GET['id']) && isset($_GET['quantity'])) {
    $product_id = (int)$_GET['id'];
    $quantity = (int)$_GET['quantity'];
    
    // Lấy thông tin sản phẩm
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        // Tạo đơn hàng tạm thời
        $cartItems = [[
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image_url' => $product['image_url']
        ]];
        $cartTotal = $product['price'] * $quantity;
    } else {
        header('Location: index.php');
        exit;
    }
} else {
    // Lấy thông tin giỏ hàng thông thường
    $cartResult = getCartItems($conn);
    $cartItems = $cartResult['success'] ? $cartResult['items'] : [];
    $totalResult = getCartTotal($conn);
    $cartTotal = $totalResult['success'] ? $totalResult['total'] : 0;
}

// Nếu không có sản phẩm nào, chuyển về trang chủ
if (empty($cartItems)) {
    header('Location: index.php');
    exit;
}

// Kiểm tra đăng nhập và lấy thông tin người dùng
// if (isLoggedIn()) {
//     $userInfo = getCurrentUser($conn);
// }

// Xử lý thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $customerName = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $note = $_POST['note'] ?? '';
    
    // Thêm đơn hàng mới cho mỗi sản phẩm trong giỏ hàng
    $success = true;
    foreach ($cartItems as $item) {
        $sql = "INSERT INTO orders (product_id, quantity, total_amount, customer_name, phone, email, address, note, status) 
                VALUES (:product_id, :quantity, :total_amount, :customer_name, :phone, :email, :address, :note, :status)";
        
        $stmt = $conn->prepare($sql);
        $itemTotal = $item['price'] * $item['quantity'];
        
        $params = [
            ':product_id' => $item['id'],
            ':quantity' => $item['quantity'],
            ':total_amount' => $itemTotal,
            ':customer_name' => $customerName,
            ':phone' => $phone,
            ':email' => $email,
            ':address' => $address,
            ':note' => $note,
            ':status' => 'pending'
        ];
        
        // In ra câu truy vấn SQL đầy đủ với các giá trị
        $debug_query = $sql;
        foreach ($params as $key => $value) {
            $debug_query = str_replace($key, "'$value'", $debug_query);
        }
        echo "<pre>Debug SQL Query: " . $debug_query . "</pre>";
        
        if (!$stmt->execute($params)) {
            $success = false;
            break;
        }
    }
    
    if ($success) {
        // Xóa giỏ hàng sau khi đặt hàng thành công
        clearCart();
        header("Location: order-success.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - Flower Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .payment-methods img {
            margin: 5px;
        }
        .qr-code {
            max-width: 250px;
            margin: auto;
            padding: 15px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .qr-code img {
            width: 100%;
            height: auto;
        }
        .form-check-input:checked ~ .payment-content {
            display: block !important;
        }
        .bank-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .use-existing-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include './layout/header.php'; ?>

    <main class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Thông tin thanh toán</h4>
                        
                        <?php if ($userInfo): ?>
                        <div class="use-existing-info mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="useExistingInfo">
                                <label class="form-check-label" for="useExistingInfo">
                                    Sử dụng thông tin có sẵn
                                </label>
                            </div>
                            <div class="mt-3" id="existingInfoPreview" style="display: none;">
                                <p class="mb-1"><strong>Họ tên:</strong> <?php echo htmlspecialchars($userInfo['username']); ?></p>
                                <p class="mb-1"><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($userInfo['phone']); ?></p>
                                <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($userInfo['email']); ?></p>
                                <p class="mb-0"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($userInfo['address']); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <form id="checkoutForm" method="POST">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
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
                                <label for="note" class="form-label">Ghi chú (không bắt buộc)</label>
                                <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                            </div>
                            
                            <h5 class="mt-4 mb-3">Phương thức thanh toán</h5>
                            <div class="payment-methods">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked>
                                    <label class="form-check-label" for="cod">
                                        Thanh toán khi nhận hàng (COD)
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" id="banking" value="banking">
                                    <label class="form-check-label" for="banking">
                                        Chuyển khoản ngân hàng
                                    </label>
                                    <div class="payment-content mt-3" style="display: none;" id="bankingContent">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="bank-info">
                                                    <h6 class="mb-3">Thông tin chuyển khoản:</h6>
                                                    <p class="mb-2"><strong>Ngân hàng:</strong> MB Bank</p>
                                                    <p class="mb-2"><strong>Số tài khoản:</strong> 0123456789</p>
                                                    <p class="mb-2"><strong>Chủ tài khoản:</strong> SHOP HOA</p>
                                                    <p class="mb-2"><strong>Số tiền:</strong> <?php echo number_format($cartTotal, 0, ',', '.'); ?> VNĐ</p>
                                                    <p class="mb-0"><strong>Nội dung:</strong> Thanh toan don hang Flower Shop</p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="qr-code">
                                                    <img src="https://img.vietqr.io/image/MB-0123456789-compact.png?amount=<?php echo $cartTotal; ?>&addInfo=Thanh toan don hang Flower Shop&accountName=SHOP HOA" 
                                                         alt="QR Code" class="img-fluid">
                                                    <p class="text-center mt-2 mb-0"><small class="text-muted">Quét mã để thanh toán</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" name="checkout" class="btn btn-primary btn-lg w-100 mt-4">
                                Xác nhận đặt hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Đơn hàng của bạn</h5>
                        <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                <small class="text-muted">Số lượng: <?php echo $item['quantity']; ?></small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold"><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> VNĐ</span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-0">Tổng tiền:</h6>
                            <span class="fw-bold fs-5"><?php echo number_format($cartTotal, 0, ',', '.'); ?> VNĐ</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include './layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Xử lý hiển thị/ẩn nội dung thanh toán
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const bankingContent = document.getElementById('bankingContent');
            
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    bankingContent.style.display = this.value === 'banking' ? 'block' : 'none';
                });
            });
            
            // Xử lý sử dụng thông tin có sẵn
            const useExistingInfo = document.getElementById('useExistingInfo');
            const existingInfoPreview = document.getElementById('existingInfoPreview');
            const formFields = {
                customer_name: document.getElementById('customer_name'),
                phone: document.getElementById('phone'),
                email: document.getElementById('email'),
                address: document.getElementById('address')
            };

            if (useExistingInfo) {
                // Lưu trữ thông tin người dùng
                const userInfo = {
                    customer_name: <?php echo $userInfo ? json_encode($userInfo['username']) : '""'; ?>,
                    phone: <?php echo $userInfo ? json_encode($userInfo['phone']) : '""'; ?>,
                    email: <?php echo $userInfo ? json_encode($userInfo['email']) : '""'; ?>,
                    address: <?php echo $userInfo ? json_encode($userInfo['address']) : '""'; ?>
                };

                useExistingInfo.addEventListener('change', function() {
                    // Hiển thị/ẩn preview
                    existingInfoPreview.style.display = this.checked ? 'block' : 'none';
                    
                    // Điền hoặc xóa thông tin trong form
                    Object.keys(formFields).forEach(field => {
                        formFields[field].value = this.checked ? userInfo[field] : '';
                        // Disable/enable các trường khi sử dụng thông tin có sẵn
                        formFields[field].readOnly = this.checked;
                    });
                });
            }
            
            // Xử lý form submit
            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.addEventListener('submit', function(e) {
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
                if (paymentMethod === 'banking') {
                    const confirmed = confirm('Bạn đã hoàn thành chuyển khoản chưa?');
                    if (!confirmed) {
                        e.preventDefault();
                    }
                }
            });
        });
    </script>
</body>
</html>