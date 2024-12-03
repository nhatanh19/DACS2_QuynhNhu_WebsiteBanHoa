<?php require_once 'layout/header.php'; ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Đăng ký tài khoản</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Tên người dùng</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Địa chỉ -->
                                <div class="mb-3">
                                    <label for="province" class="form-label">Tỉnh/Thành phố</label>
                                    <select class="form-select" id="province" name="province" required>
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="district" class="form-label">Quận/Huyện</label>
                                    <select class="form-select" id="district" name="district" required disabled>
                                        <option value="">Chọn Quận/Huyện</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="ward" class="form-label">Xã/Phường/Thị trấn</label>
                                    <select class="form-select" id="ward" name="ward" required disabled>
                                        <option value="">Chọn Xã/Phường/Thị trấn</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="specific_address" class="form-label">Địa chỉ cụ thể</label>
                                    <input type="text" class="form-control" id="specific_address" name="specific_address" 
                                           placeholder="Số nhà, tên đường..." 
                                           value="<?php echo htmlspecialchars($_POST['specific_address'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p>Đã có tài khoản? <a href="./login_mvc.php">Đăng nhập</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sử dụng file JavaScript để xử lý địa giới hành chính -->
<script src="js/address.js"></script>

<?php require_once 'layout/footer.php'; ?>
