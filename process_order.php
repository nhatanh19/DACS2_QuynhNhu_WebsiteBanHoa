<?php
require_once 'database.php';
$conn = require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->beginTransaction();

        // Lấy thông tin từ form
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $note = $_POST['note'];

        // Kiểm tra số lượng tồn kho
        $stmt = $conn->prepare("SELECT price, stock FROM products WHERE id = ? FOR UPDATE");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product || $product['stock'] < $quantity) {
            throw new Exception("Sản phẩm không đủ số lượng trong kho");
        }

        // Tạo đơn hàng
        $stmt = $conn->prepare("INSERT INTO orders (product_id, quantity, total_amount, customer_name, phone, email, address, note, status) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
        $total_amount = $product['price'] * $quantity;
        $stmt->execute([$product_id, $quantity, $total_amount, $fullname, $phone, $email, $address, $note]);

        // Cập nhật số lượng tồn kho
        $stmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$quantity, $product_id]);

        $conn->commit();
        
        // Chuyển hướng về trang cảm ơn
        header("Location: thank_you.php");
        exit;

    } catch (Exception $e) {
        $conn->rollBack();
        die("Lỗi: " . $e->getMessage());
    }
} else {
    header("Location: index.php");
    exit;
}
