<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Savor the Best Flavors | FoodPicko</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/modern-ui.css" rel="stylesheet">
</head>

<body class="home">
    <header id="header" class="header-scroll top-header headrom">
        <nav class="navbar navbar-dark">
            <div class="container">
                <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#mainNavbarCollapse">&#9776;</button>
                <a class="navbar-brand" href="index.php"> <img src="images/food-picky-logo.png" alt="Logo"> </a>
                <div class="collapse navbar-toggleable-md float-lg-right" id="mainNavbarCollapse">
                    <ul class="nav navbar-nav">
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="restaurants.php">Restaurants</a> </li>
                        <?php if(empty($_SESSION["user_id"])): ?>
                            <li class="nav-item"><a href="login.php" class="nav-link">Login</a> </li>
                            <li class="nav-item"><a href="registration.php" class="nav-link">Signup</a> </li>
                        <?php else: ?>
                            <li class="nav-item"><a href="your_orders.php" class="nav-link">Your Orders</a> </li>
                            <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a> </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero bg-image animate-up" style="background-image: url('images/modern-hero.jpg');">
        <div class="hero-inner">
            <div class="container text-center hero-text">
                <h1 class="text-white">Savor the Best Flavors <br> Delivered to Your Door</h1>
                <h5 class="text-white-50 mt-3 mb-5">Discover top-rated restaurants and exclusive deals in your area</h5>
                <div class="banner-form mx-auto" style="max-width: 600px;">
                    <form class="form-inline d-flex" action="restaurants.php" method="get">
                        <input type="text" name="search" class="form-control form-control-lg flex-grow-1" placeholder="What are you craving?" style="border-radius: 30px 0 0 30px; border: none;">
                        <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius: 0 30px 30px 0;">Find Food</button>
                    </form>
                </div>
                
                <div class="steps row mt-5 pt-5 text-white">
                    <div class="col-md-4 mb-4">
                        <div class="h3 mb-2 text-primary">01</div>
                        <h6>Choose Restaurant</h6>
                        <p class="small opacity-75">Select from hundreds of menus</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="h3 mb-2 text-primary">02</div>
                        <h6>Pick Your Food</h6>
                        <p class="small opacity-75">Find your favorite cravings</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="h3 mb-2 text-primary">03</div>
                        <h6>Fast Delivery</h6>
                        <p class="small opacity-75">Enjoy fresh food at home</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="popular py-5 bg-white">
        <div class="container">
            <div class="title text-center mb-5">
                <h2 class="animate-up">Popular Dishes of the Month</h2>
                <p class="text-muted animate-up">The easiest way to your favorite food, delivered fresh and fast.</p>
            </div>
            <div class="row">
                <?php 
                $query_res = mysqli_query($db, "select * from dishes LIMIT 6"); 
                while($r = mysqli_fetch_array($query_res)) {
                ?>
                    <div class="col-md-4 mb-4 food-item animate-up">
                        <div class="card border-0 shadow-sm overflow-hidden h-100 transition-up">
                            <div class="position-relative">
                                <img src="admin/Res_img/dishes/<?php echo $r['img']; ?>" class="card-img-top" alt="<?php echo $r['title']; ?>" style="height: 200px; object-fit: cover;">
                                <div class="position-absolute p-3" style="top: 0; right: 0;">
                                    <span class="badge badge-light shadow-sm text-primary px-3 py-2" style="border-radius: 20px;">$<?php echo $r['price']; ?></span>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="card-title font-weight-bold mb-2"><?php echo $r['title']; ?></h5>
                                <p class="card-text text-muted small mb-4"><?php echo $r['slogan']; ?></p>
                                <a href="dishes.php?res_id=<?php echo $r['rs_id']; ?>" class="btn btn-outline-primary btn-block">Order Now</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="featured-restaurants py-5 bg-light">
        <div class="container">
            <div class="title text-center mb-5">
                <h2 class="animate-up">Explore Top Restaurants</h2>
                <p class="text-muted animate-up">Handpicked local favorites just for you.</p>
            </div>
            <div class="row">
                <?php 
                $ress = mysqli_query($db, "select * from restaurant LIMIT 4");  
                while($rows = mysqli_fetch_array($ress)) {
                ?>
                    <div class="col-md-6 mb-4 animate-up">
                        <div class="restaurant-wrap p-3 bg-white shadow-sm rounded transition-up h-100">
                            <div class="d-flex align-items-center">
                                <a href="dishes.php?res_id=<?php echo $rows['rs_id']; ?>" class="mr-3 overflow-hidden rounded" style="width: 100px; height: 100px; flex-shrink: 0;">
                                    <img src="admin/Res_img/<?php echo $rows['image']; ?>" alt="Restaurant" class="w-100 h-100" style="object-fit: cover;">
                                </a>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1"><a href="dishes.php?res_id=<?php echo $rows['rs_id']; ?>" class="text-dark font-weight-bold"><?php echo $rows['title']; ?></a></h5>
                                    <p class="text-muted small mb-2"><i class="fa fa-map-marker text-primary mr-1"></i> <?php echo $rows['address']; ?></p>
                                    <div class="d-flex align-items-center small text-muted">
                                        <span class="mr-3"><i class="fa fa-clock-o text-primary mr-1"></i> 25-35 min</span>
                                        <span><i class="fa fa-star text-warning mr-1"></i> 4.5 (122 Reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="text-center mt-4">
                <a href="restaurants.php" class="btn btn-primary btn-lg px-5">View All Restaurants</a>
            </div>
        </div>
    </section>

    <footer class="footer mt-5 py-5 bg-dark text-white">
        <div class="container">
            <div class="row top-footer">
                <div class="col-md-4 mb-4">
                    <img src="images/food-picky-logo.png" alt="Logo" class="mb-3" style="height: 40px;">
                    <p class="text-muted">Premium Food Delivery experience right at your fingertips. Discover the best local flavors today.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-muted">Home</a></li>
                        <li><a href="restaurants.php" class="text-muted">Restaurants</a></li>
                        <li><a href="registration.php" class="text-muted">Join Us</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5 class="mb-3">About</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted">Our Story</a></li>
                        <li><a href="#" class="text-muted">Team</a></li>
                        <li><a href="#" class="text-muted">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">Newsletter</h5>
                    <p class="text-muted small">Stay updated with the latest offers.</p>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Your email address" style="background: rgba(255,255,255,0.05); border: none; color: white;">
                        <button class="btn btn-primary ml-1 px-4">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="bottom-footer text-center mt-5 pt-4 border-top border-secondary">
                <p class="text-muted small mb-0">&copy; 2024 FoodPicko. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>