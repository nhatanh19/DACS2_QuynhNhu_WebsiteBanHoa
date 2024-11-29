<?php
header('Content-Type: application/json');

require_once 'config/database.php';

// Nhận dữ liệu JSON
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['product_id']) && isset($data['quantity'])) {
    $product_id = $data['product_id'];
    $quantity = $data['quantity'];

    // Thêm vào giỏ hàng (có thể sử dụng session hoặc database)
    session_start();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
} else {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
}
