<?php
require_once 'classloader.php';

// Check if user is logged in and is a Fiverr administrator
if (!$userObj->isLoggedIn() || !$userObj->isFiverrAdministrator()) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin - Fiverr Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .welcome-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4rem 0;
            text-align: center;
        }
        .admin-badge {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            font-weight: bold;
            font-size: 1.2rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
        }
        .feature-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="welcome-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="display-3 mb-4">
                        <i class="fas fa-crown me-3"></i>
                        Welcome, Administrator!
                    </h1>
                    <p class="lead mb-4">
                        You have successfully logged in as a <span class="admin-badge">FIVERR ADMINISTRATOR</span>
                    </p>
                    <p class="mb-4">
                        As an administrator, you have access to powerful tools to manage the platform, 
                        organize content, and ensure smooth operations.
                    </p>
                    <a href="admin_dashboard.php" class="btn btn-light btn-lg me-3">
                        <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                    </a>
                    <a href="index.php" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-briefcase me-2"></i>View as Freelancer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="display-5">Your Administrative Powers</h2>
                <p class="lead text-muted">Here's what you can do as an administrator</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card feature-card text-center">
                    <div class="card-body">
                        <div class="feature-icon text-primary">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h5 class="card-title">Category Management</h5>
                        <p class="card-text">
                            Create, edit, and organize categories and subcategories to help users 
                            find the services they need.
                        </p>
                        <a href="admin_panel.php" class="btn btn-primary">
                            <i class="fas fa-cog me-2"></i>Manage Categories
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card feature-card text-center">
                    <div class="card-body">
                        <div class="feature-icon text-success">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h5 class="card-title">Create Proposals</h5>
                        <p class="card-text">
                            As an administrator, you can also act as a freelancer and create 
                            categorized proposals for your services.
                        </p>
                        <a href="index.php" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Create Proposals
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card feature-card text-center">
                    <div class="card-body">
                        <div class="feature-icon text-info">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h5 class="card-title">System Overview</h5>
                        <p class="card-text">
                            Monitor system statistics, user activity, and platform performance 
                            from your dashboard.
                        </p>
                        <a href="admin_dashboard.php" class="btn btn-info">
                            <i class="fas fa-chart-line me-2"></i>View Statistics
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h5 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>
                        Quick Start Guide
                    </h5>
                    <p class="mb-0">
                        Start by setting up categories for your platform, then explore the dashboard 
                        to monitor activity. Remember, you can switch between admin and freelancer roles seamlessly!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
