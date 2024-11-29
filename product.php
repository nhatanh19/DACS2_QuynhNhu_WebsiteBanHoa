<?php include './layout/header.php'; ?>

<main class="container" style="margin-top: 100px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="./cartegory.php">Danh sách sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
        </ol>
    </nav>

    <?php
    // Database connection
    require_once 'database.php';
    $pdo = require 'database.php';

    // Get product ID from URL
    $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    try {
        // Fetch product details
        $stmt = $pdo->prepare("SELECT `id`, `category_id`, `name`, `description`, `price`, `image_url`, `stock`, `created_at` 
                              FROM `products` WHERE id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    ?>

    <!-- Product Details -->
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="img-fluid" style="width: 65%;" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h1 class="h2 mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
            <div class="price-tag mb-4">
                <span class="h3"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
            </div>

            <!-- Product Options -->
            <form id="purchase-form" class="mb-4">
                <div class="form-group mb-3">
                    <label for="color">Màu sắc:</label>
                    <select class="form-select" id="color" name="color" required>
                        <option value="pink">Hồng</option>
                        <option value="white">Trắng</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="quantity">Số lượng:</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="<?php echo $product['stock']; ?>" value="1" required>
                </div>

                <button type="submit" class="btn btn-primary mb-3 w-100">MUA HÀNG</button>

                <div class="contact-buttons">
                    <button type="button" class="btn btn-outline-secondary mb-2 w-100">TÌM TẠI CỬA HÀNG</button>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary flex-fill mx-1">Hotline</button>
                        <button type="button" class="btn btn-outline-secondary flex-fill mx-1">Chat</button>
                        <button type="button" class="btn btn-outline-secondary flex-fill mx-1">Mail</button>
                    </div>
                </div>
            </form>

            <!-- Product Details Accordion -->
            <div class="accordion" id="productAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetails">
                            Chi tiết
                        </button>
                    </h2>
                    <div id="collapseDetails" class="accordion-collapse collapse show" data-bs-parent="#productAccordion">
                        <div class="accordion-body">
                            <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStorage">
                            Bảo quản
                        </button>
                    </h2>
                    <div id="collapseStorage" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                        <div class="accordion-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">• Cắt gốc hoa: Khi mới mua về, nên cắt chéo gốc của hoa khoảng 1-2 cm để hoa dễ hút nước hơn.</li>
                                <li class="mb-2">• Ngâm nước: Đặt hoa vào bình nước sạch, nên thay nước hàng ngày để tránh nước bẩn gây hỏng hoa.</li>
                                <li class="mb-2">• Tránh ánh nắng trực tiếp: Hoa baby nên được đặt ở nơi thoáng mát, tránh ánh nắng trực tiếp và nhiệt độ cao.</li>
                                <li class="mb-2">• Dùng dưỡng hoa: Có thể cho thêm dưỡng hoa vào nước để hoa tươi lâu hơn.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="related-products mt-5">
        <h3 class="mb-4">SẢN PHẨM LIÊN QUAN</h3>
        <div class="row">
            <?php
            try {
                // Fetch related products
                $stmt = $pdo->prepare("SELECT `id`, `name`, `price`, `image_url` FROM `products` 
                                     WHERE category_id = ? AND id != ? LIMIT 4");
                $stmt->execute([$product['category_id'], $product_id]);

                while ($related = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($related['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($related['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($related['name']); ?></h5>
                                <p class="card-text"><?php echo number_format($related['price'], 0, ',', '.'); ?>đ</p>
                                <a href="product.php?id=<?php echo $related['id']; ?>" class="btn btn-outline-primary">Chi tiết</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>
        </div>
    </div>
</main>

<style>
    .price-tag {
        color: #e41e31;
        font-weight: bold;
    }

    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #212529;
    }

    .contact-buttons .btn-outline-secondary {
        border-color: #dee2e6;
    }

    .contact-buttons .btn-outline-secondary:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    document.getElementById('purchase-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const quantity = document.getElementById('quantity').value;
        const color = document.getElementById('color').value;

        // Add to cart logic here
        alert('Đã thêm vào giỏ hàng: ' + quantity + ' sản phẩm, màu ' + color);
    });

    // Quantity input validation
    document.getElementById('quantity').addEventListener('change', function(e) {
        const max = parseInt(this.getAttribute('max'));
        const min = parseInt(this.getAttribute('min'));
        const value = parseInt(this.value);

        if (value > max) this.value = max;
        if (value < min) this.value = min;
    });
</script>

<?php include './layout/footer.php'; ?>