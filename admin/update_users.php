<?php include("includes/auth_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");

if(isset($_POST['submit'])) {
    if(empty($_POST['uname']) || empty($_POST['fname'])|| empty($_POST['lname']) || empty($_POST['email'])|| empty($_POST['password'])|| empty($_POST['phone'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields are required!</strong>
                  </div>';
    } else {
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
        } else {
            $mql = "UPDATE users SET username='$_POST[uname]', f_name='$_POST[fname]', l_name='$_POST[lname]', email='$_POST[email]', phone='$_POST[phone]', password='".md5($_POST['password'])."' WHERE u_id='$_GET[user_upd]'";
            mysqli_query($db, $mql);
            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> User Updated Successfully.
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Update User</h3>
                        <p class="text-muted">Modify the details of an existing customer or admin user.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <?php echo $error; echo $success; ?>
                        
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <?php 
                                    $ssql ="SELECT * FROM users WHERE u_id='$_GET[user_upd]'";
                                    $res=mysqli_query($db, $ssql); 
                                    $newrow=mysqli_fetch_array($res);
                                ?>
                                <form action='' method='post'>
                                    <div class="form-body">
                                        <h4 class="card-title font-weight-bold mb-4">Account Information</h4>
                                        <hr class="mb-4">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Username</label>
                                                    <input type="text" name="uname" value="<?php echo $newrow['username']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Password</label>
                                                    <input type="password" name="password" value="<?php echo $newrow['password']; ?>" class="form-control" placeholder="******">
                                                    <small class="text-muted">Note: Password is hashed in the database.</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">First Name</label>
                                                    <input type="text" name="fname" value="<?php echo $newrow['f_name']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Last Name</label>
                                                    <input type="text" name="lname" value="<?php echo $newrow['l_name']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Email Address</label>
                                                    <input type="text" name="email" value="<?php echo $newrow['email']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Phone Number</label>
                                                    <input type="text" name="phone" value="<?php echo $newrow['phone']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions mt-4 pt-3 border-top d-flex">
                                        <input type="submit" name="submit" class="btn btn-primary px-4 py-2 mr-2" value="Update User"> 
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