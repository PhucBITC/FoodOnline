<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Restaurant Management</h3>
                        <p class="text-muted">Manage all registered restaurants and their details.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-12">
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold mb-4">All Registered Restaurants</h4>
                                <div class="table-responsive">
                                    <table id="example23" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Open Hours</th>
                                                <th>Address</th>
                                                <th>Image</th>
                                                <th class="text-center" style="min-width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql="SELECT * FROM restaurant order by rs_id desc";
                                                $query=mysqli_query($db,$sql);
                                                
                                                if(!mysqli_num_rows($query) > 0) {
                                                    echo '<tr><td colspan="7" class="text-center py-5">No Restaurants Found</td></tr>';
                                                } else {				
                                                    while($rows=mysqli_fetch_array($query)) {
                                                        $mql="SELECT * FROM res_category where c_id='".$rows['c_id']."'";
                                                        $res=mysqli_query($db,$mql);
                                                        $row=mysqli_fetch_array($res);
                                                        
                                                        echo '<tr>
                                                            <td><span class="badge badge-pill badge-light px-3 py-2">'.$row['c_name'].'</span></td>
                                                            <td class="font-weight-bold">'.$rows['title'].'</td>
                                                            <td>
                                                                <div class="small">'.$rows['email'].'</div>
                                                                <div class="text-muted small">'.$rows['phone'].'</div>
                                                            </td>
                                                            <td>
                                                                <span class="text-success small font-weight-bold">'.$rows['o_hr'].' - '.$rows['c_hr'].'</span>
                                                                <div class="text-muted smallest">'.$rows['o_days'].'</div>
                                                            </td>
                                                            <td style="max-width: 150px;" class="text-truncate">'.$rows['address'].'</td>
                                                            <td>
                                                                <img src="Res_img/'.$rows['image'].'" class="rounded" style="width: 80px; height: 50px; object-fit: cover; border: 1px solid #eee;">
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="action-btns">
                                                                    <a href="update_restraunt.php?res_upd='.$rows['rs_id'].'" class="btn btn-action btn-outline-info" title="Edit"><i class="fa fa-edit"></i></a>
                                                                    <a href="delete_stores.php?res_del='.$rows['rs_id'].'" onclick="return confirm(\'Delete this restaurant?\');" class="btn btn-action btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
                                                                </div>
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

    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>
</html>