<?php
require_once '../client/classloader.php';

// Logout the user
$userObj->logout();

// Redirect to admin login page
header("Location: login.php");
exit;
?>
