<?php  
require_once 'Database.php';

/**
 * Class for handling Category and Subcategory operations.
 * Inherits CRUD methods from the Database class.
 */
class Category extends Database {

    /**
     * Creates a new category.
     * @param string $category_name The category name.
     * @param string $description The category description.
     * @return bool True on success, false on failure.
     */
    public function createCategory($category_name, $description) {
        $sql = "INSERT INTO categories (category_name, description) VALUES (?, ?)";
        return $this->executeNonQuery($sql, [$category_name, $description]);
    }

    /**
     * Creates a new subcategory.
     * @param int $category_id The parent category ID.
     * @param string $subcategory_name The subcategory name.
     * @param string $description The subcategory description.
     * @return bool True on success, false on failure.
     */
    public function createSubcategory($category_id, $subcategory_name, $description) {
        $sql = "INSERT INTO subcategories (category_id, subcategory_name, description) VALUES (?, ?, ?)";
        return $this->executeNonQuery($sql, [$category_id, $subcategory_name, $description]);
    }

    /**
     * Retrieves all categories.
     * @return array All categories.
     */
    public function getCategories() {
        $sql = "SELECT * FROM categories ORDER BY category_name ASC";
        return $this->executeQuery($sql);
    }

    /**
     * Retrieves a specific category by ID.
     * @param int $category_id The category ID.
     * @return array|null The category data or null if not found.
     */
    public function getCategory($category_id) {
        $sql = "SELECT * FROM categories WHERE category_id = ?";
        return $this->executeQuerySingle($sql, [$category_id]);
    }

    /**
     * Retrieves all subcategories for a specific category.
     * @param int $category_id The parent category ID.
     * @return array All subcategories for the category.
     */
    public function getSubcategories($category_id) {
        $sql = "SELECT * FROM subcategories WHERE category_id = ? ORDER BY subcategory_name ASC";
        return $this->executeQuery($sql, [$category_id]);
    }

    /**
     * Retrieves all subcategories.
     * @return array All subcategories.
     */
    public function getAllSubcategories() {
        $sql = "SELECT s.*, c.category_name FROM subcategories s 
                JOIN categories c ON s.category_id = c.category_id 
                ORDER BY c.category_name ASC, s.subcategory_name ASC";
        return $this->executeQuery($sql);
    }

    /**
     * Retrieves a specific subcategory by ID.
     * @param int $subcategory_id The subcategory ID.
     * @return array|null The subcategory data or null if not found.
     */
    public function getSubcategory($subcategory_id) {
        $sql = "SELECT s.*, c.category_name FROM subcategories s 
                JOIN categories c ON s.category_id = c.category_id 
                WHERE s.subcategory_id = ?";
        return $this->executeQuerySingle($sql, [$subcategory_id]);
    }

    /**
     * Updates a category.
     * @param int $category_id The category ID to update.
     * @param string $category_name The new category name.
     * @param string $description The new description.
     * @return bool True on success, false on failure.
     */
    public function updateCategory($category_id, $category_name, $description) {
        $sql = "UPDATE categories SET category_name = ?, description = ? WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$category_name, $description, $category_id]);
    }

    /**
     * Updates a subcategory.
     * @param int $subcategory_id The subcategory ID to update.
     * @param int $category_id The new parent category ID.
     * @param string $subcategory_name The new subcategory name.
     * @param string $description The new description.
     * @return bool True on success, false on failure.
     */
    public function updateSubcategory($subcategory_id, $category_id, $subcategory_name, $description) {
        $sql = "UPDATE subcategories SET category_id = ?, subcategory_name = ?, description = ? WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$category_id, $subcategory_name, $description, $subcategory_id]);
    }

    /**
     * Deletes a category and all its subcategories.
     * @param int $category_id The category ID to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteCategory($category_id) {
        $sql = "DELETE FROM categories WHERE category_id = ?";
        return $this->executeNonQuery($sql, [$category_id]);
    }

    /**
     * Deletes a subcategory.
     * @param int $subcategory_id The subcategory ID to delete.
     * @return bool True on success, false on failure.
     */
    public function deleteSubcategory($subcategory_id) {
        $sql = "DELETE FROM subcategories WHERE subcategory_id = ?";
        return $this->executeNonQuery($sql, [$subcategory_id]);
    }

    /**
     * Checks if a category name already exists.
     * @param string $category_name The category name to check.
     * @param int $exclude_id Optional category ID to exclude from check.
     * @return bool True if exists, false otherwise.
     */
    public function categoryNameExists($category_name, $exclude_id = null) {
        if ($exclude_id) {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE category_name = ? AND category_id != ?";
            $result = $this->executeQuerySingle($sql, [$category_name, $exclude_id]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM categories WHERE category_name = ?";
            $result = $this->executeQuerySingle($sql, [$category_name]);
        }
        return $result['count'] > 0;
    }

    /**
     * Checks if a subcategory name already exists within a category.
     * @param string $subcategory_name The subcategory name to check.
     * @param int $category_id The parent category ID.
     * @param int $exclude_id Optional subcategory ID to exclude from check.
     * @return bool True if exists, false otherwise.
     */
    public function subcategoryNameExists($subcategory_name, $category_id, $exclude_id = null) {
        if ($exclude_id) {
            $sql = "SELECT COUNT(*) as count FROM subcategories WHERE subcategory_name = ? AND category_id = ? AND subcategory_id != ?";
            $result = $this->executeQuerySingle($sql, [$subcategory_name, $category_id, $exclude_id]);
        } else {
            $sql = "SELECT COUNT(*) as count FROM subcategories WHERE subcategory_name = ? AND category_id = ?";
            $result = $this->executeQuerySingle($sql, [$subcategory_name, $category_id]);
        }
        return $result['count'] > 0;
    }
}
?>
