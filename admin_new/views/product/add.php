<?php require_once BASE_PATH . "/views/layouts/header.php"; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Thêm sản phẩm mới</h6>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php?controller=product&action=add" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="form-control-label">Danh mục</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">Chọn danh mục</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>">
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Tên sản phẩm</label>
                                    <input class="form-control" type="text" id="name" name="name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-control-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-control-label">Giá</label>
                                    <input class="form-control" type="number" id="price" name="price" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image" class="form-control-label">Hình ảnh</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-control-label">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                            <a href="index.php?controller=product&action=list" class="btn btn-light">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . "/views/layouts/footer.php"; ?>
