<?php
include("connection/connect.php"); 
error_reporting(0); 
session_start(); 

// Redirect if already logged in
if(isset($_SESSION["user_id"])) {
    header("location:index.php");
    exit;
}
if(isset($_SESSION["adm_id"])) {
    header("location:admin/dashboard.php");
    exit;
}

if(isset($_POST['submit'])) {
    $username = $_POST['username'];  
    $password = md5($_POST['password']);
    
    if(!empty($_POST["submit"])) {
        // 1. Check if it's an Admin
        $adminquery ="SELECT * FROM admin WHERE username='$username' && password='$password'"; 
        $adminresult=mysqli_query($db, $adminquery); 
        $adminrow=mysqli_fetch_array($adminresult);

        if(is_array($adminrow)) {
            $_SESSION["adm_id"] = $adminrow['adm_id']; 
            $success = "Welcome Admin! Redirecting to Dashboard...";
            header("refresh:1;url=admin/dashboard.php"); 
        } else {
            // 2. If not admin, check if it's a regular User
            $userquery ="SELECT * FROM users WHERE username='$username' && password='$password'"; 
            $userresult=mysqli_query($db, $userquery); 
            $userrow=mysqli_fetch_array($userresult);

            if(is_array($userrow)) {
                $_SESSION["user_id"] = $userrow['u_id']; 
                $success = "Login successful! Welcome back.";
                header("refresh:1;url=index.php"); 
            } else {
                $message = "Invalid Username or Password!"; 
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | FoodPicko</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/modern-ui.css">
</head>

<body class="auth-page">

<div class="auth-card animate-up">
    <div class="mb-4">
        <a href="index.php">
            <img src="images/food-picky-logo.png" alt="Logo" style="height: 45px;">
        </a>
    </div>
    
    <h2>Welcome Back!</h2>
    <p>Sign in to continue your food journey</p>

    <?php if(isset($message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <?php if(isset($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" placeholder="Enter your username" name="username" required>
        </div>
        
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
        </div>
        
        <input type="submit" name="submit" class="btn theme-btn btn-block" value="Login">
    </form>
    
    <div class="auth-footer">
        Not registered? <a href="registration.php">Create an account</a>
        <br><br>
        <div class="d-flex justify-content-between align-items-center">
            <a href="index.php" class="text-muted small"><i class="fa fa-arrow-left"></i> Back to Homepage</a>
            <a href="admin/index.php" class="text-primary small font-weight-bold">Admin Portal <i class="fa fa-lock"></i></a>
        </div>
    </div>
</div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
