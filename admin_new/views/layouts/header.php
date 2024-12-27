<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Cửa Hàng Hoa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        <?php include BASE_PATH . "/assets/css/style.css"; ?>
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Shop Hoa</h3>
                <img src="<?php echo BASE_PATH; ?>/assets/images/logo.png" alt="Logo" class="logo">
            </div>

            <ul class="list-unstyled components">
                <li class="<?php echo ($_GET['controller'] ?? '') == 'dashboard' ? 'active' : ''; ?>">
                    <a href="index.php?controller=dashboard">
                        <i class="fas fa-home"></i>
                        <span>Trang Chủ</span>
                    </a>
                </li>
                <!-- Danh mục -->
                <li>
                    <a href="#categorySubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-folder"></i>
                        <span>Danh Mục</span>
                    </a>
                    <ul class="collapse list-unstyled" id="categorySubmenu">
                        <li>
                            <a href="index.php?controller=category&action=add">
                                <i class="fas fa-plus"></i> Thêm Danh Mục
                            </a>
                        </li>
                        <li>
                            <a href="index.php?controller=category&action=list">
                                <i class="fas fa-list"></i> Danh Sách Danh Mục
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Loại sản phẩm -->
                <li>
                    <a href="#producttypeSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-tags"></i>
                        <span>Loại Sản Phẩm</span>
                    </a>
                    <ul class="collapse list-unstyled" id="producttypeSubmenu">
                        <li>
                            <a href="index.php?controller=producttype&action=add">
                                <i class="fas fa-plus"></i> Thêm Loại Sản Phẩm
                            </a>
                        </li>
                        <li>
                            <a href="index.php?controller=producttype&action=list">
                                <i class="fas fa-list"></i> Danh Sách Loại SP
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Sản phẩm -->
                <li>
                    <a href="#productSubmenu" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-box"></i>
                        <span>Sản Phẩm</span>
                    </a>
                    <ul class="collapse list-unstyled" id="productSubmenu">
                        <li>
                            <a href="index.php?controller=product&action=add">
                                <i class="fas fa-plus"></i> Thêm Sản Phẩm
                            </a>
                        </li>
                        <li>
                            <a href="index.php?controller=product&action=list">
                                <i class="fas fa-list"></i> Danh Sách Sản Phẩm
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="ms-auto">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                                <?php echo $_SESSION['user_name'] ?? 'Admin'; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="index.php?controller=auth&action=profile">
                                    <i class="fas fa-user-circle"></i> Hồ Sơ
                                </a></li>
                                <li><a class="dropdown-item" href="index.php?controller=auth&action=changePassword">
                                    <i class="fas fa-key"></i> Đổi Mật Khẩu
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="index.php?controller=auth&action=logout">
                                    <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                                </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content Container -->
            <div class="main-content">
                <!-- Content will be injected here -->
