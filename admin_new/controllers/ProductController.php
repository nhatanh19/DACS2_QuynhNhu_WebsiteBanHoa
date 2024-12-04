<?php
class ProductController {
    private $productModel;
    private $categoryModel;
    private $db;

    public function __construct() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }

        require_once BASE_PATH . "/config/database.php";
        require_once BASE_PATH . "/models/Product.php";
        require_once BASE_PATH . "/models/Category.php";

        $database = new Database();
        $this->db = $database->getConnection();
        $this->productModel = new Product($this->db);
        $this->categoryModel = new Category($this->db);
    }

    public function list() {
        $products = $this->productModel->getAll();
        require_once BASE_PATH . "/views/product/list.php";
    }

    public function add() {
        $categories = $this->categoryModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Xử lý upload hình ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = BASE_PATH . "/uploads/products/";
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $image = time() . '_' . $_FILES['image']['name'];
                $upload_file = $upload_dir . $image;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                    $image = 'uploads/products/' . $image;
                } else {
                    $_SESSION['error'] = "Upload hình ảnh thất bại!";
                    header("Location: index.php?controller=product&action=add");
                    exit();
                }
            }

            $data = [
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'image' => $image,
                'status' => $_POST['status'] ?? 1
            ];

            if ($this->productModel->add($data)) {
                $_SESSION['success'] = "Thêm sản phẩm thành công!";
                header("Location: index.php?controller=product&action=list");
                exit();
            } else {
                $_SESSION['error'] = "Thêm sản phẩm thất bại!";
            }
        }

        require_once BASE_PATH . "/views/product/add.php";
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getById($id);
        $categories = $this->categoryModel->getAll();

        if (!$product) {
            $_SESSION['error'] = "Sản phẩm không tồn tại!";
            header("Location: index.php?controller=product&action=list");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'category_id' => $_POST['category_id'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'status' => $_POST['status'] ?? 1
            ];

            // Xử lý upload hình ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = BASE_PATH . "/uploads/products/";
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                $image = time() . '_' . $_FILES['image']['name'];
                $upload_file = $upload_dir . $image;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
                    $data['image'] = 'uploads/products/' . $image;

                    // Xóa ảnh cũ nếu có
                    if (!empty($product['image']) && file_exists(BASE_PATH . "/" . $product['image'])) {
                        unlink(BASE_PATH . "/" . $product['image']);
                    }
                }
            }

            if ($this->productModel->update($id, $data)) {
                $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
                header("Location: index.php?controller=product&action=list");
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật sản phẩm thất bại!";
            }
        }

        require_once BASE_PATH . "/views/product/edit.php";
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = "Xóa sản phẩm thành công!";
        } else {
            $_SESSION['error'] = "Xóa sản phẩm thất bại!";
        }
        
        header("Location: index.php?controller=product&action=list");
        exit();
    }
}
?>
