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
        $check_cat= mysqli_query($db, "SELECT c_name FROM res_category where c_name = '".$_POST['c_name']."' ");
        if(mysqli_num_rows($check_cat) > 0) {
            $error = '<div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Category already exists!</strong>
                      </div>';
        } else {
            $mql = "INSERT INTO res_category(c_name) VALUES('".$_POST['c_name']."')";
            mysqli_query($db, $mql);
            $success = '<div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> New Category Added Successfully.
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Restaurant Categories</h3>
                        <p class="text-muted">Manage categories to organize your restaurants efficiently.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <?php echo $error; echo $success; ?>
                        
                        <div class="card-modern shadow-sm border-0 mb-4">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold mb-4">Add New Category</h4>
                                <form action='' method='post'>
                                    <div class="row align-items-end">
                                        <div class="col-md-8">
                                            <div class="form-group mb-0">
                                                <label class="font-weight-bold small text-uppercase text-muted">Category Name</label>
                                                <input type="text" name="c_name" class="form-control" placeholder="e.g. Italian, Thai, Fast Food">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" name="submit" class="btn btn-primary btn-block py-2 mt-3 mt-md-0" value="Save Category">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold mb-4">Existing Categories</h4>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Category Name</th>
                                                <th>Date Created</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql="SELECT * FROM res_category order by c_id desc";
                                                $query=mysqli_query($db,$sql);
                                                
                                                if(!mysqli_num_rows($query) > 0) {
                                                    echo '<tr><td colspan="4" class="text-center py-5">No Categories Found</td></tr>';
                                                } else {				
                                                    while($rows=mysqli_fetch_array($query)) {
                                                        echo '<tr>
                                                            <td><span class="text-muted small">#'.$rows['c_id'].'</span></td>
                                                            <td class="font-weight-bold">'.$rows['c_name'].'</td>
                                                            <td>'.date("M d, Y", strtotime($rows['date'])).'</td>
                                                            <td class="text-center">
                                                                <a href="update_category.php?cat_upd='.$rows['c_id'].'" class="btn btn-sm btn-outline-info mr-2"><i class="fa fa-edit"></i></a>
                                                                <a href="delete_category.php?cat_del='.$rows['c_id'].'" onclick="return confirm(\'Delete this category?\');" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
                                                            </td>
                                                        </tr>';
                                                    }	
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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