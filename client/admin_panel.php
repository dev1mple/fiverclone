<?php
require_once 'classloader.php';

// Check if user is logged in and is a Fiverr administrator
if (!$userObj->isLoggedIn() || !$userObj->isFiverrAdministrator()) {
    header("Location: login.php");
    exit;
}

$categories = $categoryObj->getCategories();
$subcategories = $categoryObj->getAllSubcategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Category Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .category-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: box-shadow 0.3s ease;
        }
        .category-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .subcategory-item {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            margin: 0.25rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">Category Management</h1>
                    <p class="mb-0 mt-2">Manage categories and subcategories for the platform</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="admin_dashboard.php" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Add Category Form -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Category</h5>
                    </div>
                    <div class="card-body">
                        <form action="core/handleAdminForms.php" method="POST">
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="category_description" class="form-label">Description</label>
                                <textarea class="form-control" id="category_description" name="category_description" rows="3"></textarea>
                            </div>
                            <button type="submit" name="addCategoryBtn" class="btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Add New Subcategory</h5>
                    </div>
                    <div class="card-body">
                        <form action="core/handleAdminForms.php" method="POST">
                            <div class="mb-3">
                                <label for="parent_category" class="form-label">Parent Category</label>
                                <select class="form-control" id="parent_category" name="parent_category" required>
                                    <option value="">Select a category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['category_id']; ?>">
                                            <?php echo htmlspecialchars($category['category_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="subcategory_name" class="form-label">Subcategory Name</label>
                                <input type="text" class="form-control" id="subcategory_name" name="subcategory_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="subcategory_description" class="form-label">Description</label>
                                <textarea class="form-control" id="subcategory_description" name="subcategory_description" rows="3"></textarea>
                            </div>
                            <button type="submit" name="addSubcategoryBtn" class="btn btn-success">Add Subcategory</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories List -->
        <div class="row">
            <div class="col-12">
                <h3>Categories and Subcategories</h3>
                <?php if (empty($categories)): ?>
                    <div class="alert alert-info">No categories found. Add your first category above.</div>
                <?php else: ?>
                    <?php foreach ($categories as $category): ?>
                        <div class="category-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4><?php echo htmlspecialchars($category['category_name']); ?></h4>
                                <div>
                                    <button class="btn btn-sm btn-warning" onclick="editCategory(<?php echo $category['category_id']; ?>, '<?php echo htmlspecialchars($category['category_name']); ?>', '<?php echo htmlspecialchars($category['description']); ?>')">Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCategory(<?php echo $category['category_id']; ?>)">Delete</button>
                                </div>
                            </div>
                            <p class="text-muted"><?php echo htmlspecialchars($category['description']); ?></p>
                            
                            <h6>Subcategories:</h6>
                            <?php 
                            $categorySubcategories = array_filter($subcategories, function($sub) use ($category) {
                                return $sub['category_id'] == $category['category_id'];
                            });
                            ?>
                            <?php if (empty($categorySubcategories)): ?>
                                <p class="text-muted">No subcategories</p>
                            <?php else: ?>
                                <?php foreach ($categorySubcategories as $subcategory): ?>
                                    <div class="subcategory-item">
                                        <div>
                                            <strong><?php echo htmlspecialchars($subcategory['subcategory_name']); ?></strong>
                                            <br>
                                            <small class="text-muted"><?php echo htmlspecialchars($subcategory['description']); ?></small>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editSubcategory(<?php echo $subcategory['subcategory_id']; ?>, '<?php echo htmlspecialchars($subcategory['subcategory_name']); ?>', '<?php echo htmlspecialchars($subcategory['description']); ?>', <?php echo $subcategory['category_id']; ?>)">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteSubcategory(<?php echo $subcategory['subcategory_id']; ?>)">Delete</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="core/handleAdminForms.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="edit_category_id" name="edit_category_id">
                        <div class="mb-3">
                            <label for="edit_category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="edit_category_name" name="edit_category_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_category_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_category_description" name="edit_category_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="editCategoryBtn" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Subcategory Modal -->
    <div class="modal fade" id="editSubcategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="core/handleAdminForms.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="edit_subcategory_id" name="edit_subcategory_id">
                        <div class="mb-3">
                            <label for="edit_parent_category" class="form-label">Parent Category</label>
                            <select class="form-control" id="edit_parent_category" name="edit_parent_category" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['category_id']; ?>">
                                        <?php echo htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_subcategory_name" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" id="edit_subcategory_name" name="edit_subcategory_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_subcategory_description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_subcategory_description" name="edit_subcategory_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="editSubcategoryBtn" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editCategory(id, name, description) {
            document.getElementById('edit_category_id').value = id;
            document.getElementById('edit_category_name').value = name;
            document.getElementById('edit_category_description').value = description;
            new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
        }

        function editSubcategory(id, name, description, categoryId) {
            document.getElementById('edit_subcategory_id').value = id;
            document.getElementById('edit_subcategory_name').value = name;
            document.getElementById('edit_subcategory_description').value = description;
            document.getElementById('edit_parent_category').value = categoryId;
            new bootstrap.Modal(document.getElementById('editSubcategoryModal')).show();
        }

        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category? This will also delete all its subcategories.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'core/handleAdminForms.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_category_id';
                input.value = id;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function deleteSubcategory(id) {
            if (confirm('Are you sure you want to delete this subcategory?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'core/handleAdminForms.php';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_subcategory_id';
                input.value = id;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>
