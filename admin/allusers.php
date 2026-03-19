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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Customer Management</h3>
                        <p class="text-muted">A comprehensive list of all registered users in the system.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-12">
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title font-weight-bold mb-0">All Registered Users</h4>
                                    <a href="add_users.php" class="btn btn-primary"><i class="fa fa-plus"></i> Create User</a>
                                </div>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Joined Date</th>
                                                <th class="text-center" style="min-width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql="SELECT * FROM users order by u_id desc";
                                                $query=mysqli_query($db,$sql);
                                                
                                                if(!mysqli_num_rows($query) > 0) {
                                                    echo '<tr><td colspan="7" class="text-center py-5">No User Data Found</td></tr>';
                                                } else {				
                                                    while($rows=mysqli_fetch_array($query)) {
                                                        echo '<tr>
                                                            <td class="font-weight-bold">'.$rows['username'].'</td>
                                                            <td>'.$rows['f_name'].' '.$rows['l_name'].'</td>
                                                            <td>'.$rows['email'].'</td>
                                                            <td>'.$rows['phone'].'</td>
                                                            <td style="max-width: 200px;" class="text-truncate">'.$rows['address'].'</td>																								
                                                            <td><span class="text-muted small">'.$rows['date'].'</span></td>
                                                            <td class="text-center">
                                                                <div class="action-btns">
                                                                    <a href="update_users.php?user_upd='.$rows['u_id'].'" class="btn btn-action btn-outline-info" title="Edit"><i class="fa fa-edit"></i></a>
                                                                    <a href="delete_users.php?user_del='.$rows['u_id'].'" onclick="return confirm(\'Are you sure you want to delete this user?\');" class="btn btn-action btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
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
