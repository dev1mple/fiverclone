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

// Handle registration form submission
if (isset($_POST['registerUserBtn'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $contact_number = trim($_POST['contact_number']);
    
    // Additional debugging - remove any potential hidden characters
    $password = preg_replace('/\s+/', '', $password);
    $confirm_password = preg_replace('/\s+/', '', $confirm_password);
    
    // Debug output (remove this after testing)
    error_log("Registration Debug - Password: '" . $password . "' (len: " . strlen($password) . ")");
    error_log("Registration Debug - Confirm: '" . $confirm_password . "' (len: " . strlen($confirm_password) . ")");
    error_log("Registration Debug - Match: " . ($password === $confirm_password ? 'YES' : 'NO'));

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($contact_number)) {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please fill in all required fields.";
        header("Location: login.php");
        exit;
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Passwords do not match. Please try again. (Debug: Password: '" . $password . "' (len:" . strlen($password) . "), Confirm: '" . $confirm_password . "' (len:" . strlen($confirm_password) . "))";
        header("Location: login.php");
        exit;
    }

    // Check password strength (minimum 6 characters)
    if (strlen($password) < 6) {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Password must be at least 6 characters long.";
        header("Location: login.php");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please enter a valid email address.";
        header("Location: login.php");
        exit;
    }

    // Validate contact number (basic validation)
    if (!preg_match('/^[0-9+\-\s()]+$/', $contact_number)) {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Please enter a valid contact number.";
        header("Location: login.php");
        exit;
    }

    // Check if email already exists
    if ($userObj->isEmailExists($email)) {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "An account with this email already exists. Please use a different email or try logging in.";
        header("Location: login.php");
        exit;
    }

    // Check if username already exists
    if ($userObj->isUsernameExists($username)) {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "This username is already taken. Please choose a different username.";
        header("Location: login.php");
        exit;
    }

    // Register the user as a Fiverr Administrator
    $is_client = 0; // Administrators are not clients by default
    $user_role = "fiverr_administrator";

    if ($userObj->registerUser($username, $email, $password, $contact_number, $is_client, $user_role)) {
        $_SESSION['status'] = '200';
        $_SESSION['message'] = "Admin account created successfully! You can now login with your credentials.";
        header("Location: login.php");
    } else {
        $_SESSION['status'] = '400';
        $_SESSION['message'] = "Failed to create admin account. Please try again.";
        header("Location: login.php");
    }
} else {
    // If no form submission, redirect to login page
    header("Location: login.php");
}
exit;
?>
