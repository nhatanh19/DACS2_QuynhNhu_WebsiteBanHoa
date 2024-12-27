<?php
class CategoryController {
    private $categoryModel;

    public function __construct() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
        
        require_once BASE_PATH . "/config/database.php";
        require_once BASE_PATH . "/models/Category.php";
        
        $database = new Database();
        $db = $database->getConnection();
        $this->categoryModel = new Category($db);
    }

    public function list() {
        $categories = $this->categoryModel->getAll();
        require_once BASE_PATH . "/views/category/list.php";
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ];

            if ($this->categoryModel->add($data)) {
                $_SESSION['success'] = "Thêm danh mục thành công!";
                header("Location: index.php?controller=category&action=list");
                exit();
            } else {
                $_SESSION['error'] = "Thêm danh mục thất bại!";
            }
        }
        require_once BASE_PATH . "/views/category/add.php";
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $category = $this->categoryModel->getById($id);

        if (!$category) {
            $_SESSION['error'] = "Danh mục không tồn tại!";
            header("Location: index.php?controller=category&action=list");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ];

            if ($this->categoryModel->update($id, $data)) {
                $_SESSION['success'] = "Cập nhật danh mục thành công!";
                header("Location: index.php?controller=category&action=list");
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật danh mục thất bại!";
            }
        }
        require_once BASE_PATH . "/views/category/edit.php";
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->categoryModel->delete($id)) {
            $_SESSION['success'] = "Xóa danh mục thành công!";
        } else {
            $_SESSION['error'] = "Xóa danh mục thất bại!";
        }
        
        header("Location: index.php?controller=category&action=list");
        exit();
    }
}
?>
