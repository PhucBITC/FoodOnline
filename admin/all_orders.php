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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Order Management</h3>
                        <p class="text-muted">Monitor and update all cutomer orders in real-time.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-12">
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <h4 class="card-title font-weight-bold mb-4">All User Orders</h4>
                                <div class="table-responsive">
                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>		
                                                <th>Dish</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Address</th>
                                                <th>Status</th>												
                                                <th>Date</th>
                                                <th class="text-center" style="min-width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $sql="SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id ORDER BY users_orders.o_id DESC";
                                                $query=mysqli_query($db,$sql);
                                                
                                                if(!mysqli_num_rows($query) > 0) {
                                                    echo '<tr><td colspan="8" class="text-center py-5">No Orders Found</td></tr>';
                                                } else {				
                                                    while($rows=mysqli_fetch_array($query)) {
                                                        echo '<tr>
                                                            <td class="font-weight-bold">'.$rows['username'].'</td>
                                                            <td>'.$rows['title'].'</td>
                                                            <td><span class="badge badge-light">'.$rows['quantity'].'</span></td>
                                                            <td class="font-weight-bold text-primary">$'.$rows['price'].'</td>
                                                            <td class="text-truncate" style="max-width: 150px;">'.$rows['address'].'</td>';
                                                            
                                                            $status=$rows['status'];
                                                            if($status=="" or $status=="NULL") {
                                                                echo '<td><span class="status-badge status-dispatch"><i class="fa fa-clock-o mr-1"></i> Dispatch</span></td>';
                                                            } elseif($status=="in process") {
                                                                echo '<td><span class="status-badge status-process"><i class="fa fa-cog fa-spin mr-1"></i> On the Way</span></td>';
                                                            } elseif($status=="closed") {
                                                                echo '<td><span class="status-badge status-delivered"><i class="fa fa-check-circle mr-1"></i> Delivered</span></td>';
                                                            } elseif($status=="rejected") {
                                                                echo '<td><span class="status-badge status-cancelled"><i class="fa fa-times-circle mr-1"></i> Cancelled</span></td>';
                                                            }

                                                            echo '<td><span class="text-muted small">'.$rows['date'].'</span></td>
                                                            <td class="text-center">
                                                                <div class="action-btns">
                                                                    <a href="view_order.php?user_upd='.$rows['o_id'].'" class="btn btn-action btn-outline-info" title="Edit/View"><i class="fa fa-pencil"></i></a>
                                                                    <a href="delete_orders.php?order_del='.$rows['o_id'].'" onclick="return confirm(\'Are you sure?\');" class="btn btn-action btn-outline-danger" title="Delete"><i class="fa fa-trash"></i></a>
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
