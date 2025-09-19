<?php
require_once '../client/classloader.php';

// Check if user is logged in and is a Fiverr administrator
if ($userObj->isLoggedIn() && $userObj->isFiverrAdministrator()) {
    // User is logged in as admin, redirect to dashboard
    header("Location: index.php");
} else {
    // User is not logged in or not admin, redirect to welcome page
    header("Location: welcome.php");
}
exit;
?>
