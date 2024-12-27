<?php
require_once dirname(__DIR__) . "/models/User.php";
require_once dirname(__DIR__) . "/config/database.php";

class AuthController {
    private $user;
    private $db;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->user = new User($db);
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            if ($this->user->login($email, $password)) {
                $_SESSION['user_id'] = $this->user->admin_id;
                $_SESSION['user_name'] = $this->user->admin_name;
                $_SESSION['user_email'] = $this->user->admin_email;
                $_SESSION['user_role'] = $this->user->admin_role;
                
                header("Location: index.php?controller=dashboard");
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password";
            }
        }
        require_once dirname(__DIR__) . "/views/auth/login.php";
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            $errors = [];
            
            if (empty($name)) $errors[] = "Name is required";
            if (empty($email)) $errors[] = "Email is required";
            if (empty($password)) $errors[] = "Password is required";
            if ($password !== $confirm_password) $errors[] = "Passwords do not match";
            if ($this->user->emailExists($email)) $errors[] = "Email already exists";

            if (empty($errors)) {
                if ($this->user->register($name, $email, $password)) {
                    $_SESSION['success'] = "Registration successful. Please login.";
                    header("Location: index.php?controller=auth&action=login");
                    exit();
                } else {
                    $errors[] = "Registration failed";
                }
            }
            $_SESSION['errors'] = $errors;
        }
        require_once dirname(__DIR__) . "/views/auth/register.php";
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            
            if ($this->user->updateProfile($_SESSION['user_id'], $name, $email)) {
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['success'] = "Profile updated successfully";
            } else {
                $_SESSION['error'] = "Failed to update profile";
            }
        }
        require_once dirname(__DIR__) . "/views/auth/profile.php";
    }

    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            $errors = [];
            
            if (empty($current_password)) $errors[] = "Current password is required";
            if (empty($new_password)) $errors[] = "New password is required";
            if ($new_password !== $confirm_password) $errors[] = "Passwords do not match";

            if (empty($errors)) {
                if ($this->user->updatePassword($_SESSION['user_id'], $new_password)) {
                    $_SESSION['success'] = "Password changed successfully";
                } else {
                    $errors[] = "Failed to change password";
                }
            }
            $_SESSION['errors'] = $errors;
        }
        require_once dirname(__DIR__) . "/views/auth/change_password.php";
    }
}
?>
