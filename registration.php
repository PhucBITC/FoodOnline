<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
error_reporting(0); 
include("connection/connect.php"); 

if(isset($_POST['submit'] )) {
     if(empty($_POST['username']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['cpassword']) || empty($_POST['address'])) {
			$message = "All fields are required!";
		} else {
            $check_username= mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."' ");
            $check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."' ");
            
            if($_POST['password'] != $_POST['cpassword']){
                $message = "Passwords do not match!";
            } elseif(strlen($_POST['password']) < 6) {
                $message = "Password must be at least 6 characters!";
            } elseif(strlen($_POST['phone']) < 10) {
                $message = "Invalid phone number!";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $message = "Invalid email address!";
            } elseif(mysqli_num_rows($check_username) > 0) {
                $message = 'Username already exists!';
            } elseif(mysqli_num_rows($check_email) > 0) {
                $message = 'Email already exists!';
            } else {
                $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address) VALUES('".$_POST['username']."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['email']."','".$_POST['phone']."','".md5($_POST['password'])."','".$_POST['address']."')";
                mysqli_query($db, $mql);
                $success = "Account created successfully! Redirecting...";
                header("refresh:3;url=login.php"); 
            }
	    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register | FoodPicko</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/modern-ui.css" rel="stylesheet">
</head>

<body class="auth-page">

<div class="auth-container">
    <div class="auth-card reg-card animate-up">
        <div class="mb-4 text-center">
            <a href="index.php">
                <img src="images/food-picky-logo.png" alt="Logo" style="height: 45px;">
            </a>
        </div>
        
        <h2>Create Your Account</h2>
        <p>Join FoodPicko and start enjoying delicious food!</p>

        <?php if($message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="reg-grid">
                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Pick a username" required> 
                </div>
                <div class="form-group">
                    <label>First Name</label>
                    <input class="form-control" type="text" name="firstname" placeholder="Enter first name" required> 
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input class="form-control" type="text" name="lastname" placeholder="Enter last name" required> 
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input class="form-control" type="text" name="phone" placeholder="Your phone number" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Min. 6 characters" required> 
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="cpassword" placeholder="Repeat your password" required> 
                </div>
                <div class="form-group">
                    <label>Delivery Address</label>
                    <textarea class="form-control" name="address" rows="1" placeholder="Where should we deliver?" required></textarea>
                </div>
            </div>
            
            <input type="submit" name="submit" class="btn theme-btn btn-block" value="Register Now">
        </form>
        
        <div class="auth-footer text-center">
            Already have an account? <a href="login.php">Sign In</a>
            <br><br>
            <a href="index.php" class="text-muted small"><i class="fa fa-arrow-left"></i> Back to Homepage</a>
        </div>
    </div>
</div>

    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>
</html>