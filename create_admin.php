<?php
require_once 'client/classloader.php';

// Simple script to create an administrator user
// Run this script once to create an admin user

$username = 'admin';
$email = 'admin@fiverrclone.com';
$password = 'admin123';
$contact_number = '1234567890';
$is_client = 1; // Admin can act as client
$user_role = 'fiverr_administrator';

// Check if admin already exists
$existingUser = $userObj->getUsers();
$adminExists = false;

foreach ($existingUser as $user) {
    if ($user['user_role'] === 'fiverr_administrator') {
        $adminExists = true;
        break;
    }
}

if (!$adminExists) {
    if ($userObj->registerUser($username, $email, $password, $contact_number, $is_client, $user_role)) {
        echo "Administrator user created successfully!<br>";
        echo "Username: " . $username . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Password: " . $password . "<br>";
        echo "Role: " . $user_role . "<br>";
        echo "<br>You can now login with these credentials to access the admin panel.";
    } else {
        echo "Error creating administrator user!";
    }
} else {
    echo "Administrator user already exists!";
}
?>
