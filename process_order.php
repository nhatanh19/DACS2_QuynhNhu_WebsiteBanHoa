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
        $sql = "INSERT INTO orders (user_id, product_id, quantity, total_amount, customer_name, phone, email, address, note, status) 
                VALUES (:user_id, :product_id, :quantity, :total_amount, :customer_name, :phone, :email, :address, :note, :status)";
        
        $stmt = $conn->prepare($sql);
        $total_amount = $product['price'] * $quantity;
        $status = 'pending';
        
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':total_amount', $total_amount, PDO::PARAM_STR);
        $stmt->bindParam(':customer_name', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':note', $note, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        
        $stmt->execute();

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
