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
    <title>Admin Login - Fiverr Clone</title>
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
        
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            margin: 2rem;
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .admin-icon {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(255, 215, 0, 0.3);
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-admin {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }
        
        .back-links {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e9ecef;
        }
        
        .back-links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .back-links a:hover {
            color: #764ba2;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 3;
        }
        
        .input-group .form-control {
            padding-left: 3rem;
        }
        
        .admin-badge {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            color: #333;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
        }
        
        .btn-outline-success {
            background: transparent;
            border: 2px solid #28a745;
            color: #28a745;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }
        
        .btn-outline-success:hover {
            background: #28a745;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-outline-primary {
            background: transparent;
            border: 2px solid #667eea;
            color: #667eea;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin: 0.5rem;
        }
        
        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .form-section {
            transition: all 0.3s ease;
        }
        
        .form-section.hidden {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="admin-header">
            <div class="admin-icon">
                <i class="fas fa-crown"></i>
            </div>
            <h2 class="mb-3">Admin Login</h2>
            <span class="admin-badge">FIVERR ADMINISTRATOR</span>
            <p class="text-muted">Access the administrative dashboard</p>
        </div>

        <?php if (isset($_SESSION['message']) && isset($_SESSION['status'])): ?>
            <div class="alert <?php echo $_SESSION['status'] == '200' ? 'alert-success' : 'alert-danger'; ?>">
                <i class="fas <?php echo $_SESSION['status'] == '200' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> me-2"></i>
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php 
            unset($_SESSION['message']);
            unset($_SESSION['status']);
            ?>
        <?php endif; ?>

        <!-- Login Form -->
        <div class="form-section" id="loginSection">
            <form action="handle_login.php" method="POST" id="loginForm">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" name="loginUserBtn" class="btn btn-primary btn-admin">
                        <i class="fas fa-sign-in-alt me-2"></i>Login to Admin Panel
                    </button>
                </div>
            </form>
        </div>

        <!-- Register Form -->
        <div class="form-section hidden" id="registerSection">
            <form action="handle_register.php" method="POST" id="registerForm">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-phone"></i>
                    <input type="tel" class="form-control" name="contact_number" placeholder="Contact Number" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" name="registerUserBtn" class="btn btn-success btn-admin">
                        <i class="fas fa-user-plus me-2"></i>Create Admin Account
                    </button>
                </div>
            </form>
        </div>

        <!-- Toggle Buttons -->
        <div class="text-center mt-3">
            <button type="button" class="btn btn-outline-primary btn-sm" id="toggleLogin" style="display: none;">
                <i class="fas fa-sign-in-alt me-1"></i>Already have an account? Login
            </button>
            <button type="button" class="btn btn-outline-success btn-sm" id="toggleRegister">
                <i class="fas fa-user-plus me-1"></i>Need an admin account? Register
            </button>
        </div>

        <div class="back-links">
            <a href="../client/login.php">
                <i class="fas fa-user me-1"></i>Client Login
            </a>
            <a href="../freelancer/login.php">
                <i class="fas fa-briefcase me-1"></i>Freelancer Login
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle between login and register forms
        document.getElementById('toggleRegister').addEventListener('click', function() {
            document.getElementById('loginSection').classList.add('hidden');
            document.getElementById('registerSection').classList.remove('hidden');
            document.getElementById('toggleLogin').style.display = 'inline-block';
            this.style.display = 'none';
        });

        document.getElementById('toggleLogin').addEventListener('click', function() {
            document.getElementById('registerSection').classList.add('hidden');
            document.getElementById('loginSection').classList.remove('hidden');
            document.getElementById('toggleRegister').style.display = 'inline-block';
            this.style.display = 'none';
        });

        // Password confirmation validation (temporarily disabled for debugging)
        /*
        document.querySelector('input[name="confirm_password"]').addEventListener('input', function() {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
        */

        // Real-time password strength indicator
        document.querySelector('input[name="password"]').addEventListener('input', function() {
            const password = this.value;
            const strength = getPasswordStrength(password);
            
            // You can add visual feedback here if needed
            console.log('Password strength:', strength);
        });

        function getPasswordStrength(password) {
            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            return strength;
        }
    </script>
</body>
</html>
