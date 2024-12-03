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

// Khởi tạo session
checkSession();
