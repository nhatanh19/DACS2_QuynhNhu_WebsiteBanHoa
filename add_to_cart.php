<?php
require_once 'cart_functions.php';
require_once 'database.php';
$conn = require 'database.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'cartCount' => 0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ request
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Kiểm tra cả POST data và JSON data
    $product_id = isset($input['product_id']) ? intval($input['product_id']) : 
                 (isset($_POST['product_id']) ? intval($_POST['product_id']) : 0);
                 
    $quantity = isset($input['quantity']) ? intval($input['quantity']) : 
               (isset($_POST['quantity']) ? intval($_POST['quantity']) : 1);

    try {
        // Kiểm tra sản phẩm có tồn tại và còn đủ số lượng không
        $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            throw new Exception('Sản phẩm không tồn tại');
        }

        if ($product['stock'] < $quantity) {
            throw new Exception('Số lượng sản phẩm trong kho không đủ');
        }

        // Thêm vào giỏ hàng
        $result = addToCart($product_id, $quantity);
        if ($result['success']) {
            $response['success'] = true;
            $response['cartCount'] = getCartCount();
            $response['message'] = $result['message'];
        } else {
            throw new Exception($result['message']);
        }

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
