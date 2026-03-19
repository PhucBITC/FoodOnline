<?php include("includes/auth_check.php"); ?>
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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Menu Management</h3>
                        <p class="text-muted">Explore and manage all dishes available across restaurants.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-12">
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold mb-4">All Menu Items</h4>
                                <div class="table-responsive">
                                    <table id="example23" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Restaurant</th>
                                                <th>Dish Name</th>
                                                <th>Price</th>
                                                <th>Image</th>
                                                <th class="text-center" style="min-width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql="SELECT * FROM dishes order by d_id desc";
                                                $query=mysqli_query($db,$sql);
                                                
                                                if(!mysqli_num_rows($query) > 0) {
                                                    echo '<tr><td colspan="5" class="text-center py-5">No Dishes Found</td></tr>';
                                                } else {				
                                                    while($rows=mysqli_fetch_array($query)) {
                                                        $mql="select * from restaurant where rs_id='".$rows['rs_id']."'";
                                                        $newquery=mysqli_query($db,$mql);
                                                        $fetch=mysqli_fetch_array($newquery);
                                                        
                                                        echo '<tr>
                                                            <td><span class="text-muted small">'.$fetch['title'].'</span></td>
                                                            <td class="font-weight-bold">
                                                                <div>'.$rows['title'].'</div>
                                                                <small class="text-muted">'.$rows['slogan'].'</small>
                                                            </td>
                                                            <td class="font-weight-bold text-primary">$'.$rows['price'].'</td>
                                                            <td>
                                                                <img src="Res_img/dishes/'.$rows['img'].'" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="action-btns">
                                                                    <a href="update_menu.php?menu_upd='.$rows['d_id'].'" class="btn btn-action btn-outline-info" title="Edit"><i class="fa fa-edit"></i></a>
                                                                    <a href="delete_menu.php?menu_del='.$rows['d_id'].'" onclick="return confirm(\'Delete this dish?\');" class="btn btn-action btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
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