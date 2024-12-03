<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hàm kiểm tra session
function checkSession() {
    if (!isset($_SESSION['initialized'])) {
        $_SESSION['initialized'] = true;
        $_SESSION['cart'] = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }
}

// Hàm kiểm tra đăng nhập
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Hàm lấy thông tin người dùng đang đăng nhập
function getCurrentUser($conn) {
    if (isLoggedIn()) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $_SESSION['user_id']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return null;
}

// Khởi tạo session
checkSession();
