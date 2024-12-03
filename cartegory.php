<?php
// Kết nối database
$conn = require_once 'database.php';

// Lấy category_id từ URL nếu có
$category_id = isset($_GET['category']) ? $_GET['category'] : null;

// Query để lấy danh sách categories
$stmt_categories = $conn->prepare("SELECT * FROM categories");
$stmt_categories->execute();
$categories = $stmt_categories->fetchAll();

// Pagination setup
$limit = 10; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query để lấy danh sách sản phẩm
if ($category_id) {
    $stmt = $conn->prepare("SELECT id, category_id, name, description, price, image_url, stock, created_at 
                           FROM products 
                           WHERE category_id = :category_id 
                           LIMIT :limit OFFSET :offset");
    $stmt->bindParam(':category_id', $category_id);
} else {
    $stmt = $conn->prepare("SELECT id, category_id, name, description, price, image_url, stock, created_at 
                           FROM products 
                           LIMIT :limit OFFSET :offset");
}
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();

// Get total number of products for pagination
$total_stmt = $conn->prepare("SELECT COUNT(*) as total FROM products" . ($category_id ? " WHERE category_id = :category_id" : ""));
if ($category_id) {
    $total_stmt->bindParam(':category_id', $category_id);
}
$total_stmt->execute();
$total_products = $total_stmt->fetch()['total'];
$total_pages = ceil($total_products / $limit);

// Lấy tên category hiện tại
$current_category_name = '';
if ($category_id) {
    $stmt_current_cat = $conn->prepare("SELECT name FROM categories WHERE id = :category_id");
    $stmt_current_cat->bindParam(':category_id', $category_id);
    $stmt_current_cat->execute();
    $current_category = $stmt_current_cat->fetch();
    $current_category_name = $current_category ? $current_category['name'] : '';
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category_id ? htmlspecialchars($current_category_name) : 'Tất cả sản phẩm'; ?> - Flower Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        a {
            text-decoration: none !important;
        }

        .category-filter {
            background-color: #f8f9fa;
            padding: 30px 0;
            margin-bottom: 30px;
        }

        .category-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }

        .category-btn {
            padding: 8px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .category-btn:hover {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
            color: white;
        }

        .category-btn.active {
            background-color: #ff4d4d;
            border-color: #ff4d4d;
            color: white;
        }

        .product-card {
            transition: transform 0.3s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            height: 250px;
            object-fit: cover;
        }

        .product-title {
            font-size: 1.1rem;
            margin: 10px 0;
            height: 2.4em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-description {
            font-size: 0.9rem;
            color: #666;
            height: 4.5em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .price {
            color: #ff4d4d;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .stock {
            font-size: 0.9rem;
            color: #28a745;
        }

        .sorting-section {
            margin: 20px 0;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .product-link {
            color: inherit;
            text-decoration: none;
        }

        .product-link:hover {
            color: inherit;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .category-buttons {
                flex-direction: column;
                align-items: center;
            }

            .category-btn {
                width: 80%;
                margin: 5px 0;
            }

            .sorting-section {
                text-align: center;
            }

            .sorting-section .col-md-6 {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <?php include './layout/header.php'; ?>

    <main>
        <!-- Category Filter Section -->
        <section class="category-filter">
            <div class="container">
                <h2 class="text-center mb-4">
                    <?php echo $category_id ? htmlspecialchars($current_category_name) : 'Tất cả sản phẩm'; ?>
                </h2>
                <div class="text-center category-buttons">
                    <a href="cartegory.php" class="btn btn-outline-primary category-btn <?php echo !$category_id ? 'active' : ''; ?>">
                        Tất cả
                    </a>
                    <?php foreach ($categories as $category): ?>
                        <a href="cartegory.php?category=<?php echo $category['id']; ?>"
                            class="btn btn-outline-primary category-btn <?php echo $category_id == $category['id'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="container mb-5">
            <!-- Sorting and Filters -->
            <div class="row sorting-section">
                <div class="col-md-6">
                    <p class="mb-0">Hiển thị <?php echo count($products); ?> sản phẩm</p>
                </div>
                <div class="col-md-6 text-end">
                    <select class="form-select d-inline-block w-auto" id="sortSelect">
                        <option value="default">Sắp xếp mặc định</option>
                        <option value="price_asc">Giá tăng dần</option>
                        <option value="price_desc">Giá giảm dần</option>
                        <option value="name_asc">Tên A-Z</option>
                        <option value="name_desc">Tên Z-A</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4" id="productsContainer">
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card product-card">
                            <a href="./product.php?id=<?php echo $product['id'] ?>" class="product-link">
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>"
                                    class="card-img-top product-img"
                                    alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="product-title">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </h5>
                                    <p class="product-description">
                                        <?php
                                        echo htmlspecialchars(($product['description'] ?? '') ? substr($product['description'], 0, 100) . '...' : '');
                                        ?>
                                    </p>
                                </div>
                            </a>
                            <div class="card-body d-flex flex-column mt-auto">
                                <p class="price mb-2">
                                    <?php echo number_format($product['price'], 0, ',', '.'); ?>đ
                                </p>
                                <p class="stock mb-2">
                                    Còn lại: <?php echo $product['stock']; ?> sản phẩm
                                </p>
                                <button class="btn btn-primary w-100 add-to-cart"
                                    data-product-id="<?php echo $product['id']; ?>">
                                    <i class="fas fa-shopping-cart me-2"></i>Thêm vào giỏ
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php
            function renderPagination($total_pages, $current_page) {
                echo '<nav aria-label="Page navigation">';
                echo '<ul class="pagination justify-content-center">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = $i == $current_page ? 'active' : '';
                    echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
                }
                echo '</ul>';
                echo '</nav>';
            }
            renderPagination($total_pages, $page);
            ?>
        </section>
    </main>

    <?php include './layout/footer.php'; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Xử lý sắp xếp sản phẩm
        document.getElementById('sortSelect').addEventListener('change', function() {
            const products = Array.from(document.querySelectorAll('.product-card')).map(card => card.parentElement);
            const container = document.getElementById('productsContainer');

            products.sort((a, b) => {
                const priceA = parseInt(a.querySelector('.price').textContent.replace(/[^\d]/g, ''));
                const priceB = parseInt(b.querySelector('.price').textContent.replace(/[^\d]/g, ''));
                const nameA = a.querySelector('.product-title').textContent.trim();
                const nameB = b.querySelector('.product-title').textContent.trim();

                switch (this.value) {
                    case 'price_asc':
                        return priceA - priceB;
                    case 'price_desc':
                        return priceB - priceA;
                    case 'name_asc':
                        return nameA.localeCompare(nameB);
                    case 'name_desc':
                        return nameB.localeCompare(nameA);
                    default:
                        return 0;
                }
            });

            container.innerHTML = '';
            products.forEach(product => container.appendChild(product));
        });

        // Xử lý thêm vào giỏ hàng
        // document.querySelectorAll('.add-to-cart').forEach(button => {
        //     button.addEventListener('click', function() {
        //         const productId = this.dataset.productId;
        //         // Thêm code xử lý thêm vào giỏ hàng ở đây
        //         alert('Đã thêm sản phẩm vào giỏ hàng!');
        //     });
        // });
    </script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom JS -->
    <script src="assets/js/cart.js"></script>
</body>

</html>