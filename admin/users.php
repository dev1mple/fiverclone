<?php
require_once '../client/classloader.php';

// Check if user is logged in and is a Fiverr administrator
if (!$userObj->isLoggedIn() || !$userObj->isFiverrAdministrator()) {
    header("Location: login.php");
    exit;
}

$users = $userObj->getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .navbar-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }
        .user-card {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: box-shadow 0.3s ease;
        }
        .user-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Admin Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-admin">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-crown me-2"></i>Admin Panel
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="categories.php">
                            <i class="fas fa-tags me-1"></i>Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="users.php">
                            <i class="fas fa-users me-1"></i>Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="proposals.php">
                            <i class="fas fa-briefcase me-1"></i>Proposals
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="offers.php">
                            <i class="fas fa-handshake me-1"></i>Offers
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-crown me-1"></i><?php echo $_SESSION['username']; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../client/index.php">
                                <i class="fas fa-user me-2"></i>View as Client
                            </a></li>
                            <li><a class="dropdown-item" href="../freelancer/index.php">
                                <i class="fas fa-briefcase me-2"></i>View as Freelancer
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">User Management</h1>
                    <p class="mb-0 mt-2">Manage user accounts and roles</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="index.php" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5 class="alert-heading">
                        <i class="fas fa-info-circle me-2"></i>
                        User Management
                    </h5>
                    <p class="mb-0">
                        This feature is coming soon! You'll be able to view, edit, and manage all user accounts, 
                        change user roles, and monitor user activity.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h3>All Users (<?php echo count($users); ?>)</h3>
                <?php foreach ($users as $user): ?>
                    <div class="user-card">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <h5><?php echo htmlspecialchars($user['username']); ?>
                                    <?php if ($user['user_role'] === 'fiverr_administrator'): ?>
                                        <span class="badge bg-warning text-dark">ADMIN</span>
                                    <?php elseif ($user['user_role'] === 'client'): ?>
                                        <span class="badge bg-primary">CLIENT</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">FREELANCER</span>
                                    <?php endif; ?>
                                </h5>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-0"><?php echo htmlspecialchars($user['contact_number']); ?></p>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Joined: <?php echo date('M j, Y', strtotime($user['date_added'])); ?></small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
