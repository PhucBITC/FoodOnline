<?php include("includes/auth_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");

if(isset($_POST['submit'])) {
    if(empty($_POST['c_name'])) {
        $error = '<div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Category Name is required!</strong>
                  </div>';
    } else {
        $mql = "UPDATE res_category SET c_name ='$_POST[c_name]' WHERE c_id='$_GET[cat_upd]'";
        mysqli_query($db, $mql);
        $success = '<div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success!</strong> Category Updated Successfully.
                    </div>';
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Update Category</h3>
                        <p class="text-muted">Modify the name of a restaurant category.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <?php echo $error; echo $success; ?>
                        
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <?php 
                                    $ssql ="SELECT * FROM res_category WHERE c_id='$_GET[cat_upd]'";
                                    $res=mysqli_query($db, $ssql); 
                                    $row=mysqli_fetch_array($res);
                                ?>
                                <form action='' method='post'>
                                    <div class="form-body">
                                        <h4 class="card-title font-weight-bold mb-4">Category Details</h4>
                                        <hr class="mb-4">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold small text-uppercase">Category Name</label>
                                                    <input type="text" name="c_name" value="<?php echo $row['c_name']; ?>" class="form-control" placeholder="Italian, Thai, etc.">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-actions mt-4 pt-3 border-top d-flex">
                                        <input type="submit" name="submit" class="btn btn-primary px-4 py-2 mr-2" value="Update Category"> 
                                        <a href="add_category.php" class="btn btn-outline-secondary px-4 py-2">Back</a>
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