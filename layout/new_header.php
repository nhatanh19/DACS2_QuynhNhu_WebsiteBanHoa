<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flower Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <style>
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 50px;
        }

        .nav-link {
            color: #333;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #ff4081;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item:hover {
            background-color: #fff3f6;
            color: #ff4081;
        }

        .btn-outline-dark {
            border-color: #333;
            color: #333;
        }

        .btn-outline-dark:hover {
            background: none;
            color: #ff4081;
            border-color: #ff4081;
        }

        .search-box {
            border: 1px solid #ddd;
            border-radius: 20px;
            background: none;
            padding: 8px 12px;
        }

        @media (min-width: 992px) {
            .dropdown:hover .dropdown-menu {
                display: block;
            }
        }
    </style>
</head>

<body>
    <?php session_start(); ?>
    <header style="height: 70px;">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
            <div class="container">
                <a class="navbar-brand" href="./">
                    <img src="img/logo-home.jpg" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Bộ sưu tập
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="./cartegory.php?category=1">Hoa sinh nhật</a></li>
                                <li><a class="dropdown-item" href="./cartegory.php?category=2">Hoa cưới</a></li>
                                <li><a class="dropdown-item" href="./cartegory.php?category=3">Hoa kỷ niệm</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Loại hoa
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Hoa hồng</a></li>
                                <li><a class="dropdown-item" href="#">Hoa hướng dương</a></li>
                                <li><a class="dropdown-item" href="#">Hoa cẩm chướng</a></li>
                                <li><a class="dropdown-item" href="#">Hoa tulip</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="./cartegory.php">Flash Sale</a>
                        </li>
                    </ul>
                    <form class="d-flex me-3" action="search.php" method="GET">
                        <input class="form-control search-box" type="search" name="keyword" placeholder="Tìm kiếm..." aria-label="Search">
                    </form>
                    <div class="d-flex align-items-center">
                        <a href="cart.php" class="btn btn-outline-dark me-2">
                            <i class="bi bi-cart"></i>
                            <span class="ms-1">Giỏ hàng</span>
                            <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="badge bg-danger"><?php echo count($_SESSION['cart']); ?></span>
                            <?php endif; ?>
                        </a>
                        <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                                <!-- <span class="ms-1"><?php //echo $_SESSION['user_name']; ?></span> -->
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">Tài khoản của tôi</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                            </ul>
                        </div>
                        <?php else: ?>
                        <a href="./login_mvc.php" class="btn btn-outline-dark">
                            <i class="bi bi-person"></i>
                            <span class="ms-1">Đăng nhập</span>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </header>
</body>

</html>
