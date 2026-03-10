<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if(empty($_SESSION['user_id'])) {
    header('location:login.php');
} else {
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Your Orders | FoodPicko</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/modern-ui.css" rel="stylesheet">
</head>

<body>
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img src="images/food-picky-logo.png" alt="Logo"> </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link" href="index.php">Home</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="restaurants.php">Restaurants</a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="your_orders.php">Your Orders</a></li>
                        <li class="nav-item"> <a class="nav-link text-danger" href="logout.php">Logout</a> </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-wrapper">
        <div class="inner-page-hero animate-up" style="background-image: url('images/modern-hero.jpg'); height: 200px;">
            <div class="container text-center">
                <h1 class="text-white">Your Order History</h1>
            </div>
        </div>

        <section class="restaurants-page mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="orders-card animate-up">
                            <h4 class="mb-4">Recent Orders</h4>
                            <div class="table-responsive">
                                <table class="table-modern">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $query_res= mysqli_query($db,"select * from users_orders where u_id='".$_SESSION['user_id']."' order by date desc");
                                        if(!mysqli_num_rows($query_res) > 0 ) {
                                            echo '<tr><td colspan="6" class="text-center py-5">You have no orders yet.</td></tr>';
                                        } else {			      
                                            while($row=mysqli_fetch_array($query_res)) {
                                        ?>
                                            <tr>	
                                                <td><strong><?php echo $row['title']; ?></strong></td>
                                                <td><?php echo $row['quantity']; ?></td>
                                                <td>$<?php echo $row['price']; ?></td>
                                                <td> 
                                                    <?php 
                                                    $status=$row['status'];
                                                    if($status=="" or $status=="NULL") {
                                                        echo '<span class="status-badge status-dispatch">Dispatched</span>';
                                                    } else if($status=="in process") {
                                                        echo '<span class="status-badge status-process"><i class="fa fa-cog fa-spin mr-1"></i> On Way</span>';
                                                    } else if($status=="closed") {
                                                        echo '<span class="status-badge status-delivered"><i class="fa fa-check-circle mr-1"></i> Delivered</span>';
                                                    } else if($status=="rejected") {
                                                        echo '<span class="status-badge status-cancelled"><i class="fa fa-close mr-1"></i> Cancelled</span>';
                                                    } 
                                                    ?>
                                                </td>
                                                <td><?php echo date('d M Y, H:i', strtotime($row['date'])); ?></td>
                                                <td class="text-right">
                                                    <a href="delete_orders.php?order_del=<?php echo $row['o_id'];?>" onclick="return confirm('Cancel this order?');" class="btn btn-outline-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php 
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
        </section>

        <footer class="footer mt-5">
            <div class="container text-center text-md-left">
                <div class="row top-footer">
                    <div class="col-xs-12 col-sm-4 mb-4">
                        <img src="images/food-picky-logo.png" alt="Logo" class="mb-3" style="height: 40px;">
                        <p class="text-muted">High quality food delivered to your doorstep.</p>
                    </div>
                    <div class="col-xs-12 col-sm-4 mb-4">
                        <h5>Quick Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="restaurants.php">Restaurants</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-4 mb-4">
                        <h5>Contact</h5>
                        <p class="text-muted"><i class="fa fa-envelope"></i> support@foodpicko.com</p>
                    </div>
                </div>
                <div class="bottom-footer text-center mt-4 pt-3 border-top border-dark">
                    <p class="text-muted">&copy; 2024 FoodPicko. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
?>