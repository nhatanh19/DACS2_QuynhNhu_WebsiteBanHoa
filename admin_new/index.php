<?php
session_start();

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path
define('BASE_PATH', __DIR__);

// Autoload classes
spl_autoload_register(function ($class_name) {
    // Controllers
    $controller_path = BASE_PATH . "/controllers/{$class_name}.php";
    if (file_exists($controller_path)) {
        require_once $controller_path;
        return;
    }
    
    // Models (without 'Controller' suffix)
    $model_name = str_replace('Controller', '', $class_name);
    $model_path = BASE_PATH . "/models/{$model_name}.php";
    if (file_exists($model_path)) {
        require_once $model_path;
        return;
    }
});

// Get controller and action from URL
$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Default route
if (empty($controller)) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?controller=auth&action=login");
    } else {
        header("Location: index.php?controller=dashboard&action=index");
    }
    exit();
}

// Format controller name
$controller_class = ucfirst(strtolower($controller)) . "Controller";
$controller_file = BASE_PATH . "/controllers/{$controller_class}.php";

try {
    // Check if controller file exists
    if (!file_exists($controller_file)) {
        throw new Exception("Controller file not found: {$controller_class}");
    }

    // Check if controller class exists
    if (!class_exists($controller_class)) {
        throw new Exception("Controller class not found: {$controller_class}");
    }

    // Create controller instance
    $controllerInstance = new $controller_class();

    // Check if action exists
    if (!method_exists($controllerInstance, $action)) {
        throw new Exception("Action not found: {$action} in {$controller_class}");
    }

    // Call the action
    $controllerInstance->$action();
    
} catch (Exception $e) {
    // Log error
    error_log($e->getMessage());
    
    // Show user-friendly error
    echo "<div style='text-align: center; margin-top: 50px;'>";
    echo "<h1>Lỗi</h1>";
    echo "<p>Có lỗi xảy ra. Vui lòng thử lại sau.</p>";
    if (isset($_SESSION['user_id'])) {
        echo "<p><a href='index.php?controller=dashboard&action=index'>Quay lại trang chủ</a></p>";
    } else {
        echo "<p><a href='index.php?controller=auth&action=login'>Đăng nhập</a></p>";
    }
    echo "</div>";
}
?>
