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
                        <h3 class="font-weight-bold" style="color: var(--secondary);">Dashboard Overview</h3>
                        <p class="text-muted">Welcome back, Admin! Here's what's happening today.</p>
                    </div>
                </div>

                <div class="row animate-fade">
                    <!-- Stores Stat -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon icon-stores">
                                <i class="fa fa-university"></i>
                            </div>
                            <h2 class="font-weight-bold mb-0">
                                <?php $sql="select * from restaurant";
                                      $result=mysqli_query($db,$sql); 
                                      echo mysqli_num_rows($result); ?>
                            </h2>
                            <p class="text-muted mb-0">Total Restaurants</p>
                        </div>
                    </div>

                    <!-- Dishes Stat -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon icon-dishes">
                                <i class="fa fa-cutlery"></i>
                            </div>
                            <h2 class="font-weight-bold mb-0">
                                <?php $sql="select * from dishes";
                                      $result=mysqli_query($db,$sql); 
                                      echo mysqli_num_rows($result); ?>
                            </h2>
                            <p class="text-muted mb-0">Total Dishes</p>
                        </div>
                    </div>

                    <!-- Users Stat -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon icon-users">
                                <i class="fa fa-users"></i>
                            </div>
                            <h2 class="font-weight-bold mb-0">
                                <?php $sql="select * from users";
                                      $result=mysqli_query($db,$sql); 
                                      echo mysqli_num_rows($result); ?>
                            </h2>
                            <p class="text-muted mb-0">Total Customers</p>
                        </div>
                    </div>

                    <!-- Orders Stat -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="stat-icon icon-orders">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <h2 class="font-weight-bold mb-0">
                                <?php $sql="select * from users_orders";
                                      $result=mysqli_query($db,$sql); 
                                      echo mysqli_num_rows($result); ?>
                            </h2>
                            <p class="text-muted mb-0">Total Orders</p>
                        </div>
                    </div>
                </div>

                <div class="row animate-fade" style="animation-delay: 0.1s;">
                    <div class="col-12">
                        <div class="card-modern p-4 text-center bg-white">
                            <img src="images/logo.png" alt="Logo" style="height: 60px; margin-bottom: 1.5rem;">
                            <h4 class="font-weight-bold mb-3">FoodPicko Administration System</h4>
                            <p class="text-muted mx-auto" style="max-width: 600px;">
                                Manage your restaurants, menus, and orders with ease. Use the navigation sidebar to access different management modules.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <?php include("includes/footer.php"); ?>
        </div>
    </div>
</body>
</html>
