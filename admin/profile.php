<?php include("includes/auth_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
include("includes/head.php");

$message = "";
$error = "";

if(isset($_POST['update'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];
    
    // Fetch current data
    $current = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM admin WHERE adm_id='".$_SESSION['adm_id']."'"));
    
    $update_fields = "username='$username', email='$email'";
    
    if(!empty($password)) {
        $hashed_password = md5($password); // Note: System seems to use MD5 based on SQL dump
        $update_fields .= ", password='$hashed_password'";
    }

    // Image Upload Logic
    if(!empty($_FILES['image']['name'])) {
        $fname = $_FILES['image']['name'];
        $temp = $_FILES['image']['tmp_name'];
        $fsize = $_FILES['image']['size'];
        $extension = pathinfo($fname, PATHINFO_EXTENSION);
        $fnew = uniqid().'.'.$extension;
        $store = "images/users/".$fnew;

        if($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
            if($fsize <= 1000000) { // 1MB limit
                if(move_uploaded_file($temp, $store)) {
                    $update_fields .= ", img='$fnew'";
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Image size must be less than 1MB.";
            }
        } else {
            $error = "Invalid file extension. Only JPG, PNG, JPEG allowed.";
        }
    }

    if(empty($error)) {
        $sql = "UPDATE admin SET $update_fields WHERE adm_id='".$_SESSION['adm_id']."'";
        if(mysqli_query($db, $sql)) {
            $message = "Profile updated successfully!";
        } else {
            $error = "Error updating profile: " . mysqli_error($db);
        }
    }
}

// Fetch final data
$admin_data = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM admin WHERE adm_id='".$_SESSION['adm_id']."'"));
$admin_img = !empty($admin_data['img']) ? 'images/users/'.$admin_data['img'] : 'images/users/profile.png';
?>

<body class="fix-header">
    <div id="main-wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles mb-4 animate-fade">
                    <div class="col-md-12">
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Admin Profile</h3>
                        <p class="text-muted">Manage your personal information and profile settings.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-8 mx-auto">
                        <div class="card card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <?php if($message) echo '<div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$message.'</div>'; ?>
                                <?php if($error) echo '<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$error.'</div>'; ?>

                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <img src="<?php echo $admin_img; ?>" id="profile-preview" alt="Profile" class="rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                                            <label for="image" class="position-absolute" style="bottom: 0; right: 0; background: var(--primary); color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid #fff;" title="Click to change photo">
                                                <i class="fa fa-camera"></i>
                                            </label>
                                            <input type="file" name="image" id="image" style="display: none;" accept="image/*">
                                        </div>
                                        <h4 class="mt-3 font-weight-bold"><?php echo $admin_data['username']; ?></h4>
                                        <p class="text-xs text-muted">Click the camera icon to change your profile picture</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Username</label>
                                            <input type="text" name="username" class="form-control" value="<?php echo $admin_data['username']; ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="font-weight-bold">Email Address</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $admin_data['email']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-weight-bold">New Password (leave blank to keep current)</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                                    </div>

                                    <div class="mt-4">
                                        <button type="submit" name="update" class="btn btn-primary px-4 font-weight-bold" style="background: var(--primary); border: none;">
                                            Update Profile
                                        </button>
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

    <script>
        document.getElementById('image').onchange = function (evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;
            
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function () {
                    document.getElementById('profile-preview').src = fr.result;
                }
                fr.readAsDataURL(files[0]);
            }
        }
    </script>
</body>
</html>
