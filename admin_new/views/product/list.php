<?php require_once BASE_PATH . "/views/layouts/header.php"; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="float-start">Danh sách sản phẩm</h6>
                    <a href="index.php?controller=product&action=add" class="btn btn-primary float-end">
                        <i class="fas fa-plus"></i> Thêm sản phẩm
                    </a>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success mx-4">
                            <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger mx-4">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sản phẩm</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Danh mục</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giá</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold"><?php echo $product['id']; ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <?php if (!empty($product['image'])): ?>
                                                    <img src="<?php echo $product['image']; ?>" class="avatar avatar-sm me-3" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                                <?php else: ?>
                                                    <img src="assets/img/no-image.jpg" class="avatar avatar-sm me-3" alt="No Image">
                                                <?php endif; ?>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($product['name']); ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($product['category_name']); ?></p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            <?php echo number_format($product['price']); ?>đ
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <?php if ($product['status'] == 1): ?>
                                            <span class="badge badge-sm bg-gradient-success">Hiển thị</span>
                                        <?php else: ?>
                                            <span class="badge badge-sm bg-gradient-secondary">Ẩn</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" 
                                           class="btn btn-info btn-sm" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?controller=product&action=delete&id=<?php echo $product['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" 
                                           title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . "/views/layouts/footer.php"; ?>
