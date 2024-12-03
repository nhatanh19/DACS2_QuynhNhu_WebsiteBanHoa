<?php
require_once 'models/UserModel.php';

class LoginController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function login() {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validation
            if (empty($phone)) {
                $errors[] = "Số điện thoại là bắt buộc";
            }
            if (empty($password)) {
                $errors[] = "Cần nhập mật khẩu";
            }

            // If no errors, proceed with login
            if (empty($errors)) {
                $userId = $this->userModel->login($phone, $password);
                if ($userId) {
                    // Store user ID in session
                    $_SESSION['user_id'] = $userId;
                    header('Location: index.php');
                    exit();
                } else {
                    $errors[] = "Số điện thoại hoặc mật khẩu không hợp lệ.";
                }
            }
        }

        // Load the view
        require_once 'views/login.php';
    }
}
