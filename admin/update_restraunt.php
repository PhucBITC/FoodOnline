<?php include("includes/auth_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");

if(isset($_POST['submit'])) {
    if(empty($_POST['c_name'])||empty($_POST['res_name'])||$_POST['email']==''||$_POST['phone']==''||$_POST['url']==''||$_POST['o_hr']==''||$_POST['c_hr']==''||$_POST['o_days']==''||$_POST['address']=='') {	
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>All fields must be filled!</strong>
                  </div>';
    } else {
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.',$fname);
        $extension = strtolower(end($extension));  
        $fnew = uniqid().'.'.$extension;
        $store = "Res_img/".basename($fnew);

        if($fname) { // If new image is uploaded
            if($extension == 'jpg'||$extension == 'png'||$extension == 'gif' ) {        
                if($fsize>=1000000) {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Max Image Size is 1024kb!</strong> Try a different image.
                              </div>';
                } else {
                    $sql = "UPDATE restaurant SET c_id='$_POST[c_name]', title='$_POST[res_name]', email='$_POST[email]', phone='$_POST[phone]', url='$_POST[url]', o_hr='$_POST[o_hr]', c_hr='$_POST[c_hr]', o_days='$_POST[o_days]', address='$_POST[address]', image='$fnew' WHERE rs_id='$_GET[res_upd]'";
                    mysqli_query($db, $sql); 
                    move_uploaded_file($temp, $store);
                    $success = '<div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Success!</strong> Restaurant Updated Successfully.
                                </div>';
                }
            } else {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid extension!</strong> PNG, JPG, GIF are accepted.
                          </div>';
            }
        } else { // If no new image, update other fields only
            $sql = "UPDATE restaurant SET c_id='$_POST[c_name]', title='$_POST[res_name]', email='$_POST[email]', phone='$_POST[phone]', url='$_POST[url]', o_hr='$_POST[o_hr]', c_hr='$_POST[c_hr]', o_days='$_POST[o_days]', address='$_POST[address]' WHERE rs_id='$_GET[res_upd]'";
            mysqli_query($db, $sql);
            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Restaurant Updated Successfully.
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Update Restaurant</h3>
                        <p class="text-muted">Modify the details of an existing restaurant.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <?php echo $error; echo $success; ?>
                        
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <?php 
                                    $ssql ="SELECT * FROM restaurant WHERE rs_id='$_GET[res_upd]'";
                                    $res=mysqli_query($db, $ssql); 
                                    $row=mysqli_fetch_array($res);
                                ?>
                                <form action='' method='post' enctype="multipart/form-data">
                                    <div class="form-body">
                                        <h4 class="card-title font-weight-bold mb-4">Basic Information</h4>
                                        <hr class="mb-4">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Restaurant Name</label>
                                                    <input type="text" name="res_name" value="<?php echo $row['title']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Business Email</label>
                                                    <input type="text" name="email" value="<?php echo $row['email']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Phone Number</label>
                                                    <input type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Website URL</label>
                                                    <input type="text" name="url" value="<?php echo $row['url']; ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title font-weight-bold mt-4 mb-4">Operational Details</h4>
                                        <hr class="mb-4">
                                        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Open Hours</label>
                                                    <select name="o_hr" class="form-control custom-select">
                                                        <option value="">--Select Hours--</option>
                                                        <?php $hours = ['6am','7am','8am','9am','10am','11am'];
                                                        foreach($hours as $h) {
                                                            $sel = ($row['o_hr'] == $h) ? "selected" : "";
                                                            echo "<option value='$h' $sel>$h</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Close Hours</label>
                                                    <select name="c_hr" class="form-control custom-select">
                                                        <option value="">--Select Hours--</option>
                                                        <?php $chours = ['3pm','4pm','5pm','6pm','7pm','8pm'];
                                                        foreach($chours as $h) {
                                                            $sel = ($row['c_hr'] == $h) ? "selected" : "";
                                                            echo "<option value='$h' $sel>$h</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Open Days</label>
                                                    <select name="o_days" class="form-control custom-select">
                                                        <option value="">--Select Days--</option>
                                                        <?php $days = ['mon-tue','mon-wed','mon-thu','mon-fri','mon-sat','24hr-x7'];
                                                        foreach($days as $d) {
                                                            $sel = ($row['o_days'] == $d) ? "selected" : "";
                                                            echo "<option value='$d' $sel>$d</option>";
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Category</label>
                                                    <select name="c_name" class="form-control custom-select">
                                                        <option value="">--Select Category--</option>
                                                        <?php 
                                                            $csql ="SELECT * FROM res_category";
                                                            $cres=mysqli_query($db, $csql); 
                                                            while($crow=mysqli_fetch_array($cres)) {
                                                                $sel = ($row['c_id'] == $crow['c_id']) ? "selected" : "";
                                                                echo '<option value="'.$crow['c_id'].'" '.$sel.'>'.$crow['c_name'].'</option>';
                                                            }  
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Restaurant Image</label>
                                                    <input type="file" name="file" class="form-control border-0 p-0">
                                                    <small class="text-muted">Current: <?php echo $row['image']; ?> (Leave blank to keep current)</small>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title font-weight-bold mt-4 mb-4">Location</h4>
                                        <hr class="mb-4">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Full Address</label>
                                                    <textarea name="address" style="height:100px;" class="form-control"><?php echo $row['address']; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions mt-4 pt-3 border-top d-flex">
                                        <input type="submit" name="submit" class="btn btn-primary px-4 py-2 mr-2" value="Update Restaurant"> 
                                        <a href="allrestraunt.php" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
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