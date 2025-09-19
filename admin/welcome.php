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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Access - Fiverr Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .welcome-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 3rem;
            width: 100%;
            max-width: 600px;
            margin: 2rem;
            text-align: center;
        }
        
        .admin-icon {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
            box-shadow: 0 15px 30px rgba(255, 215, 0, 0.3);
        }
        
        .btn-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 1rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        
        .btn-outline-admin {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 10px;
            padding: 1rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }
        
        .btn-outline-admin:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .admin-badge {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: bold;
            font-size: 1rem;
            display: inline-block;
            margin-bottom: 2rem;
        }
        
        .feature-list {
            text-align: left;
            margin: 2rem 0;
        }
        
        .feature-list li {
            margin: 0.5rem 0;
            color: #6c757d;
        }
        
        .feature-list i {
            color: #667eea;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="admin-icon">
            <i class="fas fa-crown"></i>
        </div>
        
        <h1 class="mb-3">Admin Panel Access</h1>
        <span class="admin-badge">FIVERR ADMINISTRATOR</span>
        
        <p class="lead mb-4">
            Welcome to the administrative section of the Fiverr Clone platform. 
            This area is restricted to authorized administrators only.
        </p>
        
        <div class="feature-list">
            <h5 class="mb-3">Administrative Features:</h5>
            <ul class="list-unstyled">
                <li><i class="fas fa-chart-bar"></i> System Dashboard & Statistics</li>
                <li><i class="fas fa-tags"></i> Category & Subcategory Management</li>
                <li><i class="fas fa-users"></i> User Account Management</li>
                <li><i class="fas fa-briefcase"></i> Proposal Monitoring & Moderation</li>
                <li><i class="fas fa-handshake"></i> Offer Management & Tracking</li>
                <li><i class="fas fa-cog"></i> System Configuration & Settings</li>
            </ul>
        </div>
        
        <div class="mt-4">
            <a href="login.php" class="btn-admin">
                <i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel
            </a>
        </div>
        
        <div class="mt-3">
            <a href="../client/index.php" class="btn-outline-admin">
                <i class="fas fa-user me-2"></i>Client Section
            </a>
            <a href="../freelancer/index.php" class="btn-outline-admin">
                <i class="fas fa-briefcase me-2"></i>Freelancer Section
            </a>
        </div>
        
        <div class="mt-4 pt-3" style="border-top: 1px solid #e9ecef;">
            <small class="text-muted">
                <i class="fas fa-shield-alt me-1"></i>
                Secure access required. Only authorized administrators can access this section.
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
