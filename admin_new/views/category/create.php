<?php require_once "../views/layouts/header.php"; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add New Category</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?controller=category&action=create" method="POST">
                        <div class="mb-3">
                            <label for="cartegory_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="cartegory_name" 
                                   name="cartegory_name" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php?controller=category" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once "../views/layouts/footer.php"; ?>
