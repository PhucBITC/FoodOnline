<?php include("includes/auth_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");

if(isset($_POST['submit'])) {
    if(empty($_POST['uname']) || empty($_POST['fname'])|| empty($_POST['lname']) || empty($_POST['email'])|| empty($_POST['password'])|| empty($_POST['phone']) || empty($_POST['address'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields are required!</strong>
                  </div>';
    } else {
        $check_username = mysqli_query($db, "SELECT username FROM users where username = '".$_POST['uname']."' ");
        $check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."' ");

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Invalid email address!</strong>
                      </div>';
        } elseif(strlen($_POST['password']) < 6) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Password must be at least 6 characters!</strong>
                      </div>';
        } elseif(strlen($_POST['phone']) < 10) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Invalid phone number!</strong>
                      </div>';
        } elseif(mysqli_num_rows($check_username) > 0) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Username already exists!</strong>
                      </div>';
        } elseif(mysqli_num_rows($check_email) > 0) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Email already exists!</strong>
                      </div>';
        } else {
            $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address) VALUES('".$_POST['uname']."','".$_POST['fname']."','".$_POST['lname']."','".$_POST['email']."','".$_POST['phone']."','".md5($_POST['password'])."','".$_POST['address']."')";
            mysqli_query($db, $mql);
            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> New User Added Successfully.
                        </div>';
        }
    }
}
include("includes/head.php");
?>

<body class="fix-header">
    <div id="main-wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles mb-4 animate-fade">
                    <div class="col-md-12">
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Add User</h3>
                        <p class="text-muted">Register a new customer or admin user to the platform.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <?php echo $error; echo $success; ?>
                        
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <form action='' method='post'>
                                    <div class="form-body">
                                        <h4 class="card-title font-weight-bold mb-4">Account Information</h4>
                                        <hr class="mb-4">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Username</label>
                                                    <input type="text" name="uname" class="form-control" placeholder="e.g. johndoe123">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Password</label>
                                                    <input type="password" name="password" class="form-control" placeholder="******">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">First Name</label>
                                                    <input type="text" name="fname" class="form-control" placeholder="John">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Last Name</label>
                                                    <input type="text" name="lname" class="form-control" placeholder="Doe">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Email Address</label>
                                                    <input type="text" name="email" class="form-control" placeholder="john@example.com">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Phone Number</label>
                                                    <input type="text" name="phone" class="form-control" placeholder="Phone number">
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title font-weight-bold mt-4 mb-4">Contact Details</h4>
                                        <hr class="mb-4">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Delivery Address</label>
                                                    <textarea name="address" style="height:100px;" class="form-control" placeholder="123 Street, City, Country"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions mt-4 pt-3 border-top d-flex">
                                        <input type="submit" name="submit" class="btn btn-primary px-4 py-2 mr-2" value="Save User"> 
                                        <a href="allusers.php" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("includes/footer.php"); ?>
        </div>
    </div>
</body>
</html>