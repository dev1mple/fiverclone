<?php
require_once '../client/classloader.php';

// Check if user is already logged in and redirect appropriately
if ($userObj->isLoggedIn()) {
    if ($userObj->isFiverrAdministrator()) {
        header("Location: index.php");
    } else {
        // Redirect non-admin users to their appropriate section
        if ($userObj->isAdmin()) {
            header("Location: ../client/index.php");
        } else {
            header("Location: ../freelancer/index.php");
        }
    }
    exit;
}

// Handle login form submission
if (isset($_POST['loginUserBtn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        if ($userObj->loginUser($email, $password)) {
            // Check if the logged-in user is an administrator
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'fiverr_administrator') {
                // Direct redirect to admin index without success message
                header("Location: index.php");
            } else {
                // User is not an administrator, redirect to appropriate section
                $_SESSION['status'] = '400';
                $_SESSION['message'] = "Access denied. Administrator privileges required.";
                
                // Redirect to appropriate section based on user role
                if ($userObj->isAdmin()) {
                    header("Location: ../client/index.php");
                } else {
                    header("Location: ../freelancer/index.php");
                }
            }
        } else {
            $_SESSION['status'] = '400';
            $_SESSION['message'] = "Invalid email or password. Please try again.";
            header("Location: login.php");
        }
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please fill in all required fields.";
        header("Location: login.php");
    }
} else {
    // If no form submission, redirect to login page
    header("Location: login.php");
}
exit;
?>
