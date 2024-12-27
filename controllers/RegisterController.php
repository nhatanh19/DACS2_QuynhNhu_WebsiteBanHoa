<?php
require_once 'models/UserModel.php';

class RegisterController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function register() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $phone = trim($_POST['phone'] ?? '');
            $province = trim($_POST['province'] ?? '');
            $district = trim($_POST['district'] ?? '');
            $ward = trim($_POST['ward'] ?? '');
            $specific_address = trim($_POST['specific_address'] ?? '');
            
            // Validation
            if (empty($username)) {
                $errors[] = "Tên người dùng là bắt buộc";
            }
            if (empty($email)) {
                $errors[] = "Email là bắt buộc";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ";
            } elseif ($this->userModel->isEmailExists($email)) {
                $errors[] = "Email đã được sử dụng";
            }
            if (empty($password)) {
                $errors[] = "Mật khẩu là bắt buộc";
            } elseif (strlen($password) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Mật khẩu không khớp";
            }
            if (empty($phone)) {
                $errors[] = "Số điện thoại là bắt buộc";
            }
            if (empty($province)) {
                $errors[] = "Tiêu đề là bắt buộc";
            }
            if (empty($district)) {
                $errors[] = "Quận/huyện là bắt buộc";
            }
            if (empty($ward)) {
                $errors[] = "Phường/xã là bắt buộc";
            }
            if ($this->userModel->isPhoneExists($phone)) {
                $errors[] = "Số điện thoại đã được sử dụng";
            }
            if (empty($specific_address)) {
                $errors[] = "Địa chỉ chi tiết là bắt buộc";
            }

            // If no errors, proceed with registration
            if (empty($errors)) {
                if ($this->userModel->register($username, $email, $password, $phone, $province, $district, $ward, $specific_address)) {
                    header('Location: login_mvc.php?registration=success');
                    exit();
                } else {
                    $errors[] = "Đăng ký thất bại. Vui lòng thực hiện lại.";
                }
            }
        }

        // Load the view
        require_once 'views/register.php';
    }
}
