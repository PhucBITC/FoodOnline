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
    <style>
        .hero {
            position: relative;
            background: #222;
            overflow: hidden;
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .hero-slider {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .hero-slide.active {
            opacity: 1;
        }

        /* Dark overlay to ensure text is readable */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(0deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
            z-index: 2;
        }

        .hero-inner {
            position: relative;
            z-index: 3;
            width: 100%;
        }

        .animate-up {
            animation: slideUp 0.8s ease-out forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
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

    <section class="hero animate-up">
        <div class="hero-slider">
            <div class="hero-slide active" style="background-image: url('images/hero-1.png');"></div>
            <div class="hero-slide" style="background-image: url('images/hero-2.png');"></div>
            <div class="hero-slide" style="background-image: url('images/hero-3.png');"></div>
        </div>
        <div class="hero-inner">
            <div class="container text-center hero-text">
                <h1 class="text-white">Savor the Best Flavors <br> Delivered to Your Door</h1>
                <h5 class="text-primary mt-3 mb-5">Discover top-rated restaurants and exclusive deals in your area</h5>
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
            <div class="row align-items-stretch">
                <?php 
                $query_res = mysqli_query($db, "select * from dishes LIMIT 6"); 
                while($r = mysqli_fetch_array($query_res)) {
                ?>
                    <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex animate-up">
                        <div class="card border-0 shadow-sm overflow-hidden w-100 transition-up d-flex flex-column h-100">
                            <div class="position-relative">
                                <img src="admin/Res_img/dishes/<?php echo $r['img']; ?>" class="card-img-top dish-card-img" alt="<?php echo $r['title']; ?>">
                            </div>
                            <div class="card-body p-4 d-flex flex-column flex-grow-1" style="padding-left:10px;padding-bottom:10px;">
                                <div class="text-center mb-3">
                                    <span class="text-primary font-weight-bold h5">$<?php echo $r['price']; ?></span>
                                </div>
                                <h5 class="card-title font-weight-bold mb-2 text-truncate-1 text-center" title="<?php echo $r['title']; ?>"><?php echo $r['title']; ?></h5>
                                <p class="card-text text-muted small mb-4 flex-grow-1 text-truncate-2 text-center" title="<?php echo $r['slogan']; ?>"><?php echo $r['slogan']; ?></p>
                                
                               <div class="d-flex justify-content-between align-items-center mt-auto w-100 gap-2">
                                 <a href="dishes.php?res_id=<?php echo $r['rs_id']; ?>" class="btn btn-primary flex-grow-1">Order Now</a>
    
                                 <a href="dish_detail.php?d_id=<?php echo $r['d_id']; ?>" class="btn btn-outline-primary px-3 d-flex align-items-center justify-content-center" title="View Details">
                                    <i class="fa fa-eye"></i>
                                 </a>
                                </div>
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
            <div class="row align-items-stretch">
                <?php 
                $ress = mysqli_query($db, "select * from restaurant LIMIT 4");  
                while($rows = mysqli_fetch_array($ress)) {
                ?>
                    <div class="col-12 col-md-6 mb-4 d-flex animate-up">
                        <div class="restaurant-wrap p-3 p-lg-4 bg-white shadow-sm rounded transition-up w-100 h-100 d-flex flex-column justify-content-center">
                            <div class="d-flex align-items-center">
                                <a href="restaurant_detail.php?res_id=<?php echo $rows['rs_id']; ?>" class="mr-3 overflow-hidden rounded" style="width: 100px; height: 100px; flex-shrink: 0;">
                                    <img src="admin/Res_img/<?php echo $rows['image']; ?>" alt="Restaurant" class="w-100 h-100" style="object-fit: cover;">
                                </a>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h5 class="mb-1 text-truncate-1" title="<?php echo $rows['title']; ?>">
                                        <a href="restaurant_detail.php?res_id=<?php echo $rows['rs_id']; ?>" class="text-dark font-weight-bold"><?php echo $rows['title']; ?></a>
                                    </h5>
                                    <p class="text-muted small mb-2 text-truncate-1" title="<?php echo $rows['address']; ?>">
                                        <i class="fa fa-map-marker text-primary mr-1"></i> <?php echo $rows['address']; ?>
                                    </p>
                                    <div class="d-flex align-items-center small text-muted flex-wrap">
                                        <span class="mr-3"><i class="fa fa-clock-o text-primary mr-1"></i> 25-35 min</span>
                                        <span><i class="fa fa-star text-warning mr-1"></i> 4.5 (122 Reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="d-flex justify-content-center mt-5" style="
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom:20px;
">
                <a href="restaurants.php" class="btn btn-primary btn-lg px-5">View All Restaurants</a>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 mb-5 mb-lg-0">
                    <img src="images/food-picky-logo.png" alt="Logo" class="footer-logo">
                    <p class="text-muted pr-lg-5">Savor the best local flavors delivered fresh and fast. We bring your favorite restaurant experience right to your doorstep with premium service and speed.</p>
                    <div class="social-links">
                        <a href="#" class="social-btn"><i class="fa fa-facebook"></i></a>
                        <a href="#" class="social-btn"><i class="fa fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fa fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php" class="footer-link">Home</a></li>
                        <li><a href="restaurants.php" class="footer-link">Restaurants</a></li>
                        <li><a href="registration.php" class="footer-link">Join Us</a></li>
                        <li><a href="#" class="footer-link">Latest Deals</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="footer-heading">Company</h5>
                    <ul class="footer-links">
                        <li><a href="#" class="footer-link">About Us</a></li>
                        <li><a href="#" class="footer-link">Our Team</a></li>
                        <li><a href="#" class="footer-link">Careers</a></li>
                        <li><a href="#" class="footer-link">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-4">
                    <div class="newsletter-box">
                        <h5 class="footer-heading">Newsletter</h5>
                        <p class="text-muted small">Subscribe to get the latest offers and restaurant updates directly in your inbox.</p>
                        <form action="#">
                            <div class="newsletter-input-group">
                                <input type="email" placeholder="Email Address" required>
                                <button type="submit" class="btn btn-primary shadow-sm">Join</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="bottom-footer-modern">
                <p class="text-muted small mb-0">&copy; 2024 FoodPicko. Crafted with <i class="fa fa-heart text-primary"></i> for food lovers. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            let currentSlide = 0;
            const slides = $('.hero-slide');
            const slideCount = slides.length;

            if (slideCount > 1) {
                function nextSlide() {
                    slides.eq(currentSlide).removeClass('active');
                    currentSlide = (currentSlide + 1) % slideCount;
                    slides.eq(currentSlide).addClass('active');
                }

                // Change slide every 5 seconds
                setInterval(nextSlide, 5000);
            }
        });
    </script>
</body>
</html>