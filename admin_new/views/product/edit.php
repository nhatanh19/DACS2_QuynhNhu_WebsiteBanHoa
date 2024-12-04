<?php require_once BASE_PATH . "/views/layouts/header.php"; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Chỉnh sửa sản phẩm</h6>
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

                    <form action="index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id" class="form-control-label">Danh mục</label>
                                    <select class="form-control" id="category_id" name="category_id" required>
                                        <option value="">Chọn danh mục</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>" 
                                                <?php echo ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Tên sản phẩm</label>
                                    <input class="form-control" type="text" id="name" name="name" 
                                           value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-control-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" 
                                      rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-control-label">Giá</label>
                                    <input class="form-control" type="number" id="price" name="price" 
                                           value="<?php echo $product['price']; ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image" class="form-control-label">Hình ảnh</label>
                                    <?php if (!empty($product['image'])): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo $product['image']; ?>" alt="Current Image" style="max-width: 100px;">
                                        </div>
                                    <?php endif; ?>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                    <small class="form-text text-muted">Để trống nếu không muốn thay đổi hình ảnh</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-control-label">Trạng thái</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" <?php echo ($product['status'] == 1) ? 'selected' : ''; ?>>Hiển thị</option>
                                <option value="0" <?php echo ($product['status'] == 0) ? 'selected' : ''; ?>>Ẩn</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="index.php?controller=product&action=list" class="btn btn-light">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once BASE_PATH . "/views/layouts/footer.php"; ?>
