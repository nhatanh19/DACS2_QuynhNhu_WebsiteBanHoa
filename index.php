<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng hoa tươi</title>
    <!-- Custom CSS -->
    <style>
        /* Slider styles */

        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }

        /* Featured sections */

        .featured-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }

        .category-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-card img {
            height: 330px;
            object-fit: cover;
        }

        /* Newsletter section */

        .newsletter {
            background-color: #fff5f8;
            padding: 40px 0;
        }
    </style>
</head>

<body>
    <?php
    include './layout/header.php';
    ?>
    <!-- Carousel -->
    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" style="margin-top: 76px;">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider1.png" class="d-block w-100" alt="Slider 1">
            </div>
            <div class="carousel-item">
                <img src="img/slider2.png" class="d-block w-100" alt="Slider 2">
            </div>
            <div class="carousel-item">
                <img src="img/slider3.png" class="d-block w-100" alt="Slider 3">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Featured Categories -->
    <section class="featured-section">
        <div class="container">
            <h2 class="text-center mb-5">Danh mục nổi bật</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card category-card">
                        <img src="img/hoa1.jpg" class="card-img-top img-fluid" alt="Hoa sinh nhật">
                        <div class="card-body text-center">
                            <h5 class="card-title">Hoa sinh nhật</h5>
                            <a href="#" class="btn btn-outline-primary">Xem thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card category-card">
                        <img src="img/hoa2.jpg" class="card-img-top" alt="Hoa cưới">
                        <div class="card-body text-center">
                            <h5 class="card-title">Hoa cưới</h5>
                            <a href="#" class="btn btn-outline-primary">Xem thêm</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card category-card">
                        <img src="img/hoa3.jpg" class="card-img-top" alt="Hoa kỷ niệm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Hoa kỷ niệm</h5>
                            <a href="#" class="btn btn-outline-primary">Xem thêm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h3>Đăng ký nhận thông tin</h3>
                    <p>Nhận thông tin về các ưu đãi và bộ sưu tập mới</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Nhập email của bạn">
                        <button class="btn btn-primary" type="button">Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include './layout/footer.php';  ?>
</body>

</html>