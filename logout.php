<?php
session_start();

// Xóa tất cả các session
session_destroy();

// Chuyển về trang chủ
header('Location: index.php');
exit;
