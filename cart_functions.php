<?php
require_once 'includes/session.php';

// Khởi tạo giỏ hàng nếu chưa có
function initCart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}

// Thêm sản phẩm vào giỏ hàng
function addToCart($product_id, $quantity = 1) {
    try {
        if (!is_numeric($product_id) || $product_id <= 0) {
            throw new Exception("ID sản phẩm không hợp lệ");
        }
        
        if (!is_numeric($quantity) || $quantity <= 0) {
            throw new Exception("Số lượng không hợp lệ");
        }
        
        initCart();
        
        // Nếu sản phẩm đã có trong giỏ hàng thì tăng số lượng
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        
        return ['success' => true, 'message' => 'Thêm vào giỏ hàng thành công'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Cập nhật số lượng sản phẩm
function updateCartQuantity($product_id, $quantity) {
    try {
        if (!is_numeric($product_id) || $product_id <= 0) {
            throw new Exception("ID sản phẩm không hợp lệ");
        }
        
        if (!is_numeric($quantity) || $quantity < 0) {
            throw new Exception("Số lượng không hợp lệ");
        }
        
        if ($quantity == 0) {
            removeFromCart($product_id);
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
        
        return ['success' => true, 'message' => 'Cập nhật số lượng thành công'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Xóa sản phẩm khỏi giỏ hàng
function removeFromCart($product_id) {
    try {
        if (!is_numeric($product_id) || $product_id <= 0) {
            throw new Exception("ID sản phẩm không hợp lệ");
        }
        
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        
        return ['success' => true, 'message' => 'Xóa sản phẩm thành công'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Lấy tổng số sản phẩm trong giỏ hàng
function getCartCount() {
    return array_sum($_SESSION['cart']);
}

// Lấy danh sách sản phẩm trong giỏ hàng
function getCartItems($conn) {
    initCart();
    $items = [];
    
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
        try {
            $stmt = $conn->prepare("SELECT id, name, price, image_url FROM products WHERE id = :product_id");
            $stmt->execute(['product_id' => $product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                $product['quantity'] = $quantity;
                $product['total'] = $quantity * $product['price'];
                $items[] = $product;
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    return ['success' => true, 'items' => $items];
}

// Lấy tổng giá trị giỏ hàng
function getCartTotal($conn) {
    try {
        $items = getCartItems($conn);
        if ($items['success']) {
            $total = 0;
            
            foreach ($items['items'] as $item) {
                $total += $item['total'];
            }
            
            return ['success' => true, 'total' => $total];
        } else {
            return $items;
        }
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

// Xóa toàn bộ giỏ hàng
function clearCart() {
    try {
        $_SESSION['cart'] = [];
        return ['success' => true, 'message' => 'Xóa toàn bộ giỏ hàng thành công'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}
