<?php include("includes/auth_check.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
include("includes/head.php");
?>

<head>
    <script language="javascript" type="text/javascript">
    var popUpWin=0;
    function popUpWindow(URLStr, left, top, width, height) {
        if(popUpWin) {
            if(!popUpWin.closed) popUpWin.close();
        }
        popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
    }
    </script>
</head>

<body class="fix-header">
    <div id="main-wrapper">
        <?php include("includes/header.php"); ?>
        <?php include("includes/sidebar.php"); ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles mb-4 animate-fade">
                    <div class="col-md-12">
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Order Details</h3>
                        <p class="text-muted">Detailed view of the customer order and actions.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <div class="col-lg-12">
                        <div class="card-modern shadow-sm border-0">
                            <div class="card-body p-4">
                                <?php
                                    $sql="SELECT users_orders.*, users.username as user_name, admin.username as admin_name 
                                          FROM users_orders 
                                          LEFT JOIN users ON users.u_id = users_orders.u_id 
                                          LEFT JOIN admin ON admin.adm_id = users_orders.adm_id 
                                          WHERE o_id='".$_GET['user_upd']."'";
                                    $query=mysqli_query($db,$sql);
                                    $rows=mysqli_fetch_array($query);
                                ?>
                                
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title font-weight-bold mb-0">Order Information</h4>
                                    <div class="d-flex">
                                        <a href="javascript:void(0);" onClick="popUpWindow('order_update.php?form_id=<?php echo htmlentities($rows['o_id']);?>');" class="btn btn-primary btn-sm mr-2">
                                            <i class="fa fa-edit mr-1"></i> Update Status
                                        </a>
                                        <a href="javascript:void(0);" onClick="popUpWindow('userprofile.php?newform_id=<?php echo htmlentities($rows['o_id']);?>');" class="btn btn-info btn-sm">
                                            <i class="fa fa-user mr-1"></i> View Customer
                                        </a>
                                    </div>
                                </div>
                                <hr class="mb-4">

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold bg-light" style="width: 250px;">Customer Username</td>
                                                <td>
                                                    <?php 
                                                        if(!empty($rows['admin_name'])) {
                                                            echo '<span class="text-primary"><i class="fa fa-user-secret"></i> Admin: '.$rows['admin_name'].'</span>';
                                                        } else {
                                                            echo $rows['user_name'];
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold bg-light">Dish Title</td>
                                                <td><?php echo $rows['title']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold bg-light">Quantity</td>
                                                <td><?php echo $rows['quantity']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold bg-light">Price</td>
                                                <td class="text-primary font-weight-bold">$<?php echo $rows['price']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold bg-light">Delivery Address</td>
                                                <td><?php echo $rows['address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold bg-light">Order Date</td>
                                                <td><?php echo date("M d, Y H:i", strtotime($rows['date'])); ?></td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold bg-light">Current Status</td>
                                                <td>
                                                    <?php 
                                                        $status=$rows['status'];
                                                        if($status=="" or $status=="NULL") {
                                                            echo '<span class="status-badge status-pending">Dispatched</span>';
                                                        } else if($status=="in process") {
                                                            echo '<span class="status-badge status-processing">On the Way</span>';
                                                        } else if($status=="closed") {
                                                            echo '<span class="status-badge status-delivered">Delivered</span>';
                                                        } else if($status=="rejected") {
                                                            echo '<span class="status-badge status-cancelled">Cancelled</span>';
                                                        } 
                                                    ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-4">
                                    <a href="all_orders.php" class="btn btn-outline-secondary px-4">Back to All Orders</a>
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