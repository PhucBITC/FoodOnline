<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['submit'])) {
    if(empty($_POST['d_name'])||empty($_POST['about'])||$_POST['price']==''||$_POST['res_name']=='') {	
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
        $store = "Res_img/dishes/".basename($fnew);

        if($fname) { // If new image is uploaded
            if($extension == 'jpg'||$extension == 'png'||$extension == 'gif' ) {        
                if($fsize>=1000000) {
                    $error = '<div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Max Image Size is 1024kb!</strong> Try a different image.
                              </div>';
                } else {
                    $sql = "UPDATE dishes SET rs_id='$_POST[res_name]', title='$_POST[d_name]', slogan='$_POST[about]', price='$_POST[price]', img='$fnew' WHERE d_id='$_GET[menu_upd]'";
                    mysqli_query($db, $sql); 
                    move_uploaded_file($temp, $store);
                    $success = '<div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Success!</strong> Menu Item Updated Successfully.
                                </div>';
                }
            } else {
                $error = '<div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Invalid extension!</strong> PNG, JPG, GIF are accepted.
                          </div>';
            }
        } else { // If no new image, update other fields only
            $sql = "UPDATE dishes SET rs_id='$_POST[res_name]', title='$_POST[d_name]', slogan='$_POST[about]', price='$_POST[price]' WHERE d_id='$_GET[menu_upd]'";
            mysqli_query($db, $sql);
            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> Menu Item Updated Successfully.
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Update Menu Item</h3>
                        <p class="text-muted">Modify the details of an existing dish.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <?php echo $error; echo $success; ?>
                        
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <?php 
                                    $qml ="SELECT * FROM dishes WHERE d_id='$_GET[menu_upd]'";
                                    $rest=mysqli_query($db, $qml); 
                                    $roww=mysqli_fetch_array($rest);
                                ?>
                                <form action='' method='post' enctype="multipart/form-data">
                                    <div class="form-body">
                                        <h4 class="card-title font-weight-bold mb-4">Dish Information</h4>
                                        <hr class="mb-4">
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Dish Name</label>
                                                    <input type="text" name="d_name" value="<?php echo $roww['title'];?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">About/Slogan</label>
                                                    <input type="text" name="about" value="<?php echo $roww['slogan'];?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Price ($)</label>
                                                    <input type="text" name="price" value="<?php echo $roww['price'];?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Restaurant</label>
                                                    <select name="res_name" class="form-control custom-select">
                                                        <option value="">--Select Restaurant--</option>
                                                        <?php 
                                                            $ssql ="SELECT * FROM restaurant";
                                                            $res=mysqli_query($db, $ssql); 
                                                            while($row=mysqli_fetch_array($res)) {
                                                                $sel = ($roww['rs_id'] == $row['rs_id']) ? "selected" : "";
                                                                echo '<option value="'.$row['rs_id'].'" '.$sel.'>'.$row['title'].'</option>';
                                                            }  
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Dish Image</label>
                                                    <input type="file" name="file" class="form-control border-0 p-0">
                                                    <small class="text-muted">Current: <?php echo $roww['img']; ?> (Leave blank to keep current)</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions mt-4 pt-3 border-top d-flex">
                                        <input type="submit" name="submit" class="btn btn-primary px-4 py-2 mr-2" value="Update Dish"> 
                                        <a href="all_menu.php" class="btn btn-outline-secondary px-4 py-2">Cancel</a>
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