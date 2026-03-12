<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

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

        if($extension == 'jpg'||$extension == 'png'||$extension == 'gif' ) {        
            if($fsize>=1000000) {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Max Image Size is 1024kb!</strong> Try a different image.
                          </div>';
            } else {
                $res_name=$_POST['res_name'];
                $sql = "INSERT INTO restaurant(c_id,title,email,phone,url,o_hr,c_hr,o_days,address,image) VALUE('".$_POST['c_name']."','".$res_name."','".$_POST['email']."','".$_POST['phone']."','".$_POST['url']."','".$_POST['o_hr']."','".$_POST['c_hr']."','".$_POST['o_days']."','".$_POST['address']."','".$fnew."')";
                mysqli_query($db, $sql); 
                move_uploaded_file($temp, $store);
                $success = '<div class="alert alert-success alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Success!</strong> New Restaurant Added Successfully.
                            </div>';
            }
        } elseif($extension == '') {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Select an image</strong>
                      </div>';
        } else {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Invalid extension!</strong> PNG, JPG, GIF are accepted.
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Add Restaurant</h3>
                        <p class="text-muted">Register a new restaurant unit in the system.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <?php echo $error; echo $success; ?>
                        
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <form action='' method='post' enctype="multipart/form-data">
                                    <div class="form-body">
                                        <h4 class="card-title font-weight-bold mb-4">Restaurant Details</h4>
                                        <hr class="mb-4">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Restaurant Name</label>
                                                    <input type="text" name="res_name" class="form-control" placeholder="e.g. Italian Garden">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Business E-mail</label>
                                                    <input type="text" name="email" class="form-control" placeholder="restaurant@example.com">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Phone Number</label>
                                                    <input type="text" name="phone" class="form-control" placeholder="1-(555)-555-5555">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Website URL</label>
                                                    <input type="text" name="url" class="form-control" placeholder="http://example.com">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Open Hours</label>
                                                    <select name="o_hr" class="form-control custom-select">
                                                        <option value="">--Select Hours--</option>
                                                        <option value="6am">6am</option>
                                                        <option value="7am">7am</option> 
                                                        <option value="8am">8am</option>
                                                        <option value="9am">9am</option>
                                                        <option value="10am">10am</option>
                                                        <option value="11am">11am</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Close Hours</label>
                                                    <select name="c_hr" class="form-control custom-select">
                                                        <option value="">--Select Hours--</option>
                                                        <option value="3pm">3pm</option>
                                                        <option value="4pm">4pm</option> 
                                                        <option value="5pm">5pm</option>
                                                        <option value="6pm">6pm</option>
                                                        <option value="7pm">7pm</option>
                                                        <option value="8pm">8pm</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Open Days</label>
                                                    <select name="o_days" class="form-control custom-select">
                                                        <option value="">--Select Days--</option>
                                                        <option value="mon-tue">mon-tue</option>
                                                        <option value="mon-wed">mon-wed</option> 
                                                        <option value="mon-thu">mon-thu</option>
                                                        <option value="mon-fri">mon-fri</option>
                                                        <option value="mon-sat">mon-sat</option>
                                                        <option value="24hr-x7">24hr-x7</option>
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
                                                            $ssql ="select * from res_category";
                                                            $res=mysqli_query($db, $ssql); 
                                                            while($row=mysqli_fetch_array($res)) {
                                                                echo ' <option value="'.$row['c_id'].'">'.$row['c_name'].'</option>';
                                                            }  
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Restaurant Image</label>
                                                    <input type="file" name="file" class="form-control border-0 p-0">
                                                    <small class="text-muted">Accepted formats: PNG, JPG, GIF (Max 1MB)</small>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title font-weight-bold mt-4 mb-4">Location Details</h4>
                                        <hr class="mb-4">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Full Address</label>
                                                    <textarea name="address" style="height:100px;" class="form-control" placeholder="123 Street, City, Country"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions mt-4 pt-3 border-top d-flex">
                                        <input type="submit" name="submit" class="btn btn-primary px-4 py-2 mr-2" value="Save Restaurant"> 
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