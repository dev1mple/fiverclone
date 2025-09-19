<?php
require_once 'classloader.php';

// Check if user is logged in and is a Fiverr administrator
if (!$userObj->isLoggedIn() || !$userObj->isFiverrAdministrator()) {
    header("Location: login.php");
    exit;
}

// Get system statistics
$categories = $categoryObj->getCategories();
$subcategories = $categoryObj->getAllSubcategories();
$proposals = $proposalObj->getProposals();
$offers = $offerObj->getOffers();
$users = $userObj->getUsers();

// Count statistics
$totalCategories = count($categories);
$totalSubcategories = count($subcategories);
$totalProposals = count($proposals);
$totalOffers = count($offers);
$totalUsers = count($users);

// Count users by role
$adminCount = 0;
$clientCount = 0;
$freelancerCount = 0;

foreach ($users as $user) {
    switch ($user['user_role']) {
        case 'fiverr_administrator':
            $adminCount++;
            break;
        case 'client':
            $clientCount++;
            break;
        case 'freelancer':
            $freelancerCount++;
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Fiverr Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .quick-action-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .quick-action-card:hover {
            transform: translateY(-3px);
        }
        .admin-badge {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="admin-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">
                        <i class="fas fa-tachometer-alt me-3"></i>
                        Admin Dashboard
                    </h1>
                    <p class="mb-0 mt-2">Welcome back, <strong><?php echo $_SESSION['username']; ?></strong>!</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge admin-badge fs-6 px-3 py-2">
                        <i class="fas fa-crown me-2"></i>ADMINISTRATOR
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- System Statistics -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-chart-bar text-primary me-2"></i>
                    System Statistics
                </h2>
            </div>
            
            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center h-100">
                    <div class="card-body">
                        <div class="stat-icon text-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="card-title"><?php echo $totalUsers; ?></h3>
                        <p class="card-text">Total Users</p>
                        <small class="text-muted">
                            <?php echo $adminCount; ?> Admins, 
                            <?php echo $clientCount; ?> Clients, 
                            <?php echo $freelancerCount; ?> Freelancers
                        </small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center h-100">
                    <div class="card-body">
                        <div class="stat-icon text-success">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3 class="card-title"><?php echo $totalProposals; ?></h3>
                        <p class="card-text">Total Proposals</p>
                        <small class="text-muted">Active service listings</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center h-100">
                    <div class="card-body">
                        <div class="stat-icon text-warning">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="card-title"><?php echo $totalOffers; ?></h3>
                        <p class="card-text">Total Offers</p>
                        <small class="text-muted">Client submissions</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card stat-card text-center h-100">
                    <div class="card-body">
                        <div class="stat-icon text-info">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3 class="card-title"><?php echo $totalCategories; ?></h3>
                        <p class="card-text">Categories</p>
                        <small class="text-muted"><?php echo $totalSubcategories; ?> subcategories</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-bolt text-warning me-2"></i>
                    Quick Actions
                </h2>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card quick-action-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-plus-circle text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Manage Categories</h5>
                        <p class="card-text">Add, edit, or delete categories and subcategories</p>
                        <a href="admin_panel.php" class="btn btn-success">
                            <i class="fas fa-cog me-2"></i>Manage Categories
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card quick-action-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-plus text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">User Management</h5>
                        <p class="card-text">View and manage user accounts and roles</p>
                        <a href="#" class="btn btn-primary" onclick="alert('User management feature coming soon!')">
                            <i class="fas fa-users me-2"></i>Manage Users
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card quick-action-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-chart-line text-info" style="font-size: 3rem;"></i>
                        </div>
                        <h5 class="card-title">Analytics</h5>
                        <p class="card-text">View detailed system analytics and reports</p>
                        <a href="#" class="btn btn-info" onclick="alert('Analytics feature coming soon!')">
                            <i class="fas fa-chart-bar me-2"></i>View Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-clock text-secondary me-2"></i>
                    Recent Activity
                </h2>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-briefcase me-2"></i>
                            Latest Proposals
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $recentProposals = array_slice($proposals, 0, 5);
                        if (empty($recentProposals)): 
                        ?>
                            <p class="text-muted">No proposals found.</p>
                        <?php else: ?>
                            <?php foreach ($recentProposals as $proposal): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong><?php echo htmlspecialchars($proposal['username']); ?></strong>
                                        <?php if ($proposal['user_role'] === 'fiverr_administrator'): ?>
                                            <span class="badge badge-warning ml-1">ADMIN</span>
                                        <?php endif; ?>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars(substr($proposal['description'], 0, 50)) . '...'; ?></small>
                                    </div>
                                    <small class="text-muted"><?php echo date('M j, Y', strtotime($proposal['proposals_date_added'])); ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-handshake me-2"></i>
                            Latest Offers
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php 
                        $recentOffers = array_slice($offers, 0, 5);
                        if (empty($recentOffers)): 
                        ?>
                            <p class="text-muted">No offers found.</p>
                        <?php else: ?>
                            <?php foreach ($recentOffers as $offer): ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong><?php echo htmlspecialchars($offer['username']); ?></strong>
                                        <?php if ($offer['user_role'] === 'fiverr_administrator'): ?>
                                            <span class="badge badge-warning ml-1">ADMIN</span>
                                        <?php endif; ?>
                                        <br>
                                        <small class="text-muted"><?php echo htmlspecialchars(substr($offer['description'], 0, 50)) . '...'; ?></small>
                                    </div>
                                    <small class="text-muted"><?php echo date('M j, Y', strtotime($offer['offer_date_added'])); ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
