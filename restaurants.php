<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Restaurants | FoodPicko</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/modern-ui.css" rel="stylesheet">
</head>

<body>
    <!--header starts-->
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img src="images/food-picky-logo.png" alt="Logo"> </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link" href="index.php">Home</a> </li>
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants</a> </li>
                        <?php if(isset($_SESSION["adm_id"])): ?>
                            <li class="nav-item"><a href="admin/dashboard.php" class="nav-link text-primary font-weight-bold">Admin Panel</a> </li>
                        <?php endif; ?>
                        <?php
                        if(empty($_SESSION["user_id"]) && empty($_SESSION["adm_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link">Login</a> </li>
                                  <li class="nav-item"><a href="registration.php" class="nav-link">Signup</a> </li>';
                        } else {
                            if(!empty($_SESSION["user_id"]) || !empty($_SESSION["adm_id"])) {
                                echo '<li class="nav-item"><a href="your_orders.php" class="nav-link">Your Orders</a> </li>';
                            }
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a> </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-wrapper">
        <div class="inner-page-hero animate-up" data-image-src="images/modern-hero.jpg" style="background-image: url('images/modern-hero.jpg');">
            <div class="container text-center">
                <h1 class="text-white">Discover Local Flavors</h1>
            </div>
        </div>

        <section class="restaurants-page">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-3">
                        <div class="widget animate-up">
                            <div class="widget-heading">
                                <h3 class="widget-title">Categories</h3>
                            </div>
                            <div class="widget-body">
                                <ul class="tags">
                                    <?php 
                                    $res= mysqli_query($db,"select * from res_category");
                                    while($row=mysqli_fetch_array($res)) {
                                        echo '<li><a href="#" class="tag">'.ucfirst($row['c_name']).'</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-9">
                        <div class="restaurant-entry">
                            <?php 
                            $ress= mysqli_query($db,"select * from restaurant");
                            while($rows=mysqli_fetch_array($ress)) {
                                echo '
                                <div class="restaurant-wrap animate-up">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-8">
                                            <div class="entry-logo float-left mr-4">
                                                <a href="dishes.php?res_id='.$rows['rs_id'].'" > 
                                                    <img src="admin/Res_img/'.$rows['image'].'" alt="Logo" style="width: 100px; height: 100px; object-fit: cover;">
                                                </a>
                                            </div>
                                            <div class="entry-dscr">
                                                <h5><a href="dishes.php?res_id='.$rows['rs_id'].'" >'.$rows['title'].'</a></h5> 
                                                <span><i class="fa fa-map-marker"></i> '.$rows['address'].'</span>
                                                <ul class="list-inline mt-2">
                                                    <li class="list-inline-item text-muted small"><i class="fa fa-check-circle text-success"></i> Min $10.00</li>
                                                    <li class="list-inline-item text-muted small ml-3"><i class="fa fa-clock-o"></i> 30 min</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-12 col-lg-4 text-center">
                                            <div class="rating-block mb-2"> 
                                                <i class="fa fa-star text-warning"></i> 
                                                <i class="fa fa-star text-warning"></i> 
                                                <i class="fa fa-star text-warning"></i> 
                                                <i class="fa fa-star text-warning"></i> 
                                                <i class="fa fa-star-o text-warning"></i> 
                                            </div>
                                            <p class="text-muted small">245 Reviews</p>
                                            <a href="dishes.php?res_id='.$rows['rs_id'].'" class="btn theme-btn">View Menu</a>
                                        </div>
                                    </div>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
  
    
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
</body>

</html>