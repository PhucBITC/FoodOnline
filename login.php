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
<?php
include("connection/connect.php"); 
error_reporting(0); 
session_start(); 

if(isset($_POST['submit'])) {
	$username = $_POST['username'];  
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"])) {
        $loginquery ="SELECT * FROM users WHERE username='$username' && password='".md5($password)."'"; 
        $result=mysqli_query($db, $loginquery); 
        $row=mysqli_fetch_array($result);
	
        if(is_array($row)) {
            $_SESSION["user_id"] = $row['u_id']; 
            header("refresh:1;url=index.php"); 
        } else {
            $message = "Invalid Username or Password!"; 
        }
	}
}
?>

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
        <a href="index.php" class="text-muted small"><i class="fa fa-arrow-left"></i> Back to Homepage</a>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
