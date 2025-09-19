<?php  
require_once '../client/classloader.php';

// Check if user is logged in and is a Fiverr administrator
if (!$userObj->isLoggedIn() || !$userObj->isFiverrAdministrator()) {
    header("Location: login.php");
    exit;
}

// Add Category
if (isset($_POST['addCategoryBtn'])) {
    $category_name = htmlspecialchars(trim($_POST['category_name']));
    $description = htmlspecialchars(trim($_POST['category_description']));

    if (!empty($category_name)) {
        if (!$categoryObj->categoryNameExists($category_name)) {
            if ($categoryObj->createCategory($category_name, $description)) {
                $_SESSION['status'] = '200';
                $_SESSION['message'] = "Category added successfully!";
            } else {
                $_SESSION['status'] = '400';
                $_SESSION['message'] = "Error adding category!";
            }
        } else {
            $_SESSION['status'] = '400';
            $_SESSION['message'] = "Category name already exists!";
        }
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please enter a category name!";
    }
    header("Location: categories.php");
    exit;
}

// Add Subcategory
if (isset($_POST['addSubcategoryBtn'])) {
    $category_id = (int)$_POST['parent_category'];
    $subcategory_name = htmlspecialchars(trim($_POST['subcategory_name']));
    $description = htmlspecialchars(trim($_POST['subcategory_description']));

    if (!empty($subcategory_name) && $category_id > 0) {
        if (!$categoryObj->subcategoryNameExists($subcategory_name, $category_id)) {
            if ($categoryObj->createSubcategory($category_id, $subcategory_name, $description)) {
                $_SESSION['status'] = '200';
                $_SESSION['message'] = "Subcategory added successfully!";
            } else {
                $_SESSION['status'] = '400';
                $_SESSION['message'] = "Error adding subcategory!";
            }
        } else {
            $_SESSION['status'] = '400';
            $_SESSION['message'] = "Subcategory name already exists in this category!";
        }
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please fill all required fields!";
    }
    header("Location: categories.php");
    exit;
}

// Edit Category
if (isset($_POST['editCategoryBtn'])) {
    $category_id = (int)$_POST['edit_category_id'];
    $category_name = htmlspecialchars(trim($_POST['edit_category_name']));
    $description = htmlspecialchars(trim($_POST['edit_category_description']));

    if (!empty($category_name) && $category_id > 0) {
        if (!$categoryObj->categoryNameExists($category_name, $category_id)) {
            if ($categoryObj->updateCategory($category_id, $category_name, $description)) {
                $_SESSION['status'] = '200';
                $_SESSION['message'] = "Category updated successfully!";
            } else {
                $_SESSION['status'] = '400';
                $_SESSION['message'] = "Error updating category!";
            }
        } else {
            $_SESSION['status'] = '400';
            $_SESSION['message'] = "Category name already exists!";
        }
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please fill all required fields!";
    }
    header("Location: categories.php");
    exit;
}

// Edit Subcategory
if (isset($_POST['editSubcategoryBtn'])) {
    $subcategory_id = (int)$_POST['edit_subcategory_id'];
    $category_id = (int)$_POST['edit_parent_category'];
    $subcategory_name = htmlspecialchars(trim($_POST['edit_subcategory_name']));
    $description = htmlspecialchars(trim($_POST['edit_subcategory_description']));

    if (!empty($subcategory_name) && $subcategory_id > 0 && $category_id > 0) {
        if (!$categoryObj->subcategoryNameExists($subcategory_name, $category_id, $subcategory_id)) {
            if ($categoryObj->updateSubcategory($subcategory_id, $category_id, $subcategory_name, $description)) {
                $_SESSION['status'] = '200';
                $_SESSION['message'] = "Subcategory updated successfully!";
            } else {
                $_SESSION['status'] = '400';
                $_SESSION['message'] = "Error updating subcategory!";
            }
        } else {
            $_SESSION['status'] = '400';
            $_SESSION['message'] = "Subcategory name already exists in this category!";
        }
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please fill all required fields!";
    }
    header("Location: categories.php");
    exit;
}

// Delete Category
if (isset($_POST['delete_category_id'])) {
    $category_id = (int)$_POST['delete_category_id'];
    
    if ($category_id > 0) {
        if ($categoryObj->deleteCategory($category_id)) {
            $_SESSION['status'] = '200';
            $_SESSION['message'] = "Category deleted successfully!";
        } else {
            $_SESSION['status'] = '400';
            $_SESSION['message'] = "Error deleting category!";
        }
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Invalid category ID!";
    }
    header("Location: categories.php");
    exit;
}

// Delete Subcategory
if (isset($_POST['delete_subcategory_id'])) {
    $subcategory_id = (int)$_POST['delete_subcategory_id'];
    
    if ($subcategory_id > 0) {
        if ($categoryObj->deleteSubcategory($subcategory_id)) {
            $_SESSION['status'] = '200';
            $_SESSION['message'] = "Subcategory deleted successfully!";
        } else {
            $_SESSION['status'] = '400';
            $_SESSION['message'] = "Error deleting subcategory!";
        }
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Invalid subcategory ID!";
    }
    header("Location: categories.php");
    exit;
}
?>
