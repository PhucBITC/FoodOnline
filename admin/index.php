<!DOCTYPE html>
<html lang="en" >
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	if(!empty($_POST["submit"])) 
     {
	$loginquery ="SELECT * FROM admin WHERE username='$username' && password='".md5($password)."'";
	$result=mysqli_query($db, $loginquery);
	$row=mysqli_fetch_array($result);
	
	                        if(is_array($row))
								{
                                    	$_SESSION["adm_id"] = $row['adm_id'];
										 header("refresh:1;url=dashboard.php");
	                            } 
							else
							    {
                                      	$message = "Invalid Username or Password!";
                                }
	 }
	
	
}

if(isset($_POST['submit1'] ))
{
     if(empty($_POST['cr_user']) ||
   	    empty($_POST['cr_email'])|| 
		empty($_POST['cr_pass']) ||  
		empty($_POST['cr_cpass']) ||
		empty($_POST['code']))
		{
			$message = "ALL fields must be fill";
		}
	else
	{
		
	
	$check_username= mysqli_query($db, "SELECT username FROM admin where username = '".$_POST['cr_user']."' ");
	
	$check_email = mysqli_query($db, "SELECT email FROM admin where email = '".$_POST['cr_email']."' ");
	
	  $check_code = mysqli_query($db, "SELECT adm_id FROM admin where code = '".$_POST['code']."' ");

	
	if($_POST['cr_pass'] != $_POST['cr_cpass']){
       	$message = "Password not match";
    }
	
    elseif (!filter_var($_POST['cr_email'], FILTER_VALIDATE_EMAIL)) // Validate email address
    {
       	$message = "Invalid email address please type a valid email!";
    }
	elseif(mysqli_num_rows($check_username) > 0)
     {
    	$message = 'username Already exists!';
     }
	elseif(mysqli_num_rows($check_email) > 0)
     {
    	$message = 'Email Already exists!';
     }
	 if(mysqli_num_rows($check_code) > 0)           // if code already exist 
             {
                   $message = "Unique Code Already Redeem!";
             }
	else{
       $result = mysqli_query($db,"SELECT id FROM admin_codes WHERE codes =  '".$_POST['code']."'");  //query to select the id of the valid code enter by user! 
					  
                     if(mysqli_num_rows($result) == 0)     //if code is not valid
						 {
                            // row not found, do stuff...
			                 $message = "invalid code!";
                         } 
                      
                      else                                 //if code is valid 
					     {
	
								$mql = "INSERT INTO admin (username,password,email,code) VALUES ('".$_POST['cr_user']."','".md5($_POST['cr_pass'])."','".$_POST['cr_email']."','".$_POST['code']."')";
								mysqli_query($db, $mql);
									$success = "Admin Added successfully!";
						 }
        }
	}

}
?>

<head>
  <meta charset="UTF-8">
  <title>Admin Login | FoodPicko</title>
  
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/modern-ui.css">
</head>

<body class="auth-page">

<div class="auth-card animate-up">
  <div class="mb-4 text-center">
    <img src="images/manager.png" alt="Admin" style="height: 80px; border-radius: 50%; border: 3px solid var(--primary); padding: 5px;">
  </div>

  <div class="info mb-4">
    <h2>Administration</h2>
    <p>Login Account</p>
  </div>

  <div class="form">
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

    <form class="register-form" action="index.php" method="post" style="display: none;">
      <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" placeholder="Pick a username" name="cr_user" required/>
      </div>
      <div class="form-group">
        <label>Email Address</label>
        <input type="text" class="form-control" placeholder="email@example.com"  name="cr_email" required/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" placeholder="Min. 6 characters"  name="cr_pass" required/>
      </div>
      <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" class="form-control" placeholder="Repeat your password"  name="cr_cpass" required/>
      </div>
      <div class="form-group">
        <label>Unique-Code</label>
        <input type="password" class="form-control" placeholder="Enter unique code"  name="code" required/>
      </div>
      <input type="submit" name="submit1" class="btn theme-btn btn-block" value="Create Account" />
      <p class="auth-footer message">Already registered? <a href="#">Sign In</a></p>
    </form>

    <form class="login-form" action="index.php" method="post">
      <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" placeholder="Enter username" name="username" required/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" placeholder="Enter password" name="password" required/>
      </div>
      <input type="submit" name="submit" class="btn theme-btn btn-block" value="Login" />
      
      <div class="mt-4 p-3 bg-light rounded small text-muted">
        <strong>Demo Credentials:</strong><br>
        username: admin | password: 1234
      </div>

      <p class="auth-footer message mt-3">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>
  $('.message a').click(function(){
     $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
  });
</script>
</body>
</html>
