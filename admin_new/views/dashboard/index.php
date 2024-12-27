<?php 
require_once BASE_PATH . "/views/layouts/header.php";
?>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Danh mục -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Danh mục</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="index.php?controller=category&action=add" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm danh mục
                        </a>
                        <a href="index.php?controller=category&action=list" class="btn btn-info">
                            <i class="fas fa-list"></i> Danh sách danh mục
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loại sản phẩm -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Loại sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="index.php?controller=producttype&action=add" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm loại sản phẩm
                        </a>
                        <a href="index.php?controller=producttype&action=list" class="btn btn-info">
                            <i class="fas fa-list"></i> Danh sách loại sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sản phẩm -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Sản phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="index.php?controller=product&action=add" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Thêm sản phẩm
                        </a>
                        <a href="index.php?controller=product&action=list" class="btn btn-info">
                            <i class="fas fa-list"></i> Danh sách sản phẩm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="text-muted mb-0">Tổng Danh Mục</h5>
                            <h2 class="my-2">12</h2>
                        </div>
                        <div class="text-primary">
                            <i class="fas fa-folder fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="text-muted mb-0">Tổng Loại Sản Phẩm</h5>
                            <h2 class="my-2">24</h2>
                        </div>
                        <div class="text-success">
                            <i class="fas fa-tags fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="text-muted mb-0">Tổng Sản Phẩm</h5>
                            <h2 class="my-2">150</h2>
                        </div>
                        <div class="text-info">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . "/views/layouts/footer.php"; ?>
