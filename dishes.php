<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); 
error_reporting(0);
session_start();
include_once 'product-action.php'; 
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dishes | FoodPicko</title>
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
                        <li class="nav-item"> <a class="nav-link active" href="restaurants.php">Restaurants</a> </li>
                        <?php
                        if(empty($_SESSION["user_id"])) {
                            echo '<li class="nav-item"><a href="login.php" class="nav-link">Login</a> </li>
                                  <li class="nav-item"><a href="registration.php" class="nav-link">Signup</a> </li>';
                        } else {
                            echo '<li class="nav-item"><a href="your_orders.php" class="nav-link">Your Orders</a> </li>';
                            echo '<li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a> </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-wrapper">
        <?php 
        $ress= mysqli_query($db,"select * from restaurant where rs_id='$_GET[res_id]'");
        $rows=mysqli_fetch_array($ress);
        ?>
        <div class="inner-page-hero animate-up" style="background-image: url('images/modern-hero.jpg');">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center text-md-left">
                        <img src="admin/Res_img/<?php echo $rows['image']; ?>" alt="Logo" class="img-fluid rounded-circle border border-white" style="width: 120px; height: 120px; object-fit: cover; box-shadow: var(--shadow-md);">
                    </div>
                    <div class="col-md-10 text-white">
                        <h1 class="mb-2"><?php echo $rows['title']; ?></h1>
                        <p class="lead mb-0"><i class="fa fa-map-marker"></i> <?php echo $rows['address']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container m-t-30">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                    <div class="widget widget-cart animate-up">
                        <div class="widget-heading">
                            <h3 class="widget-title">Your Cart</h3>
                        </div>
                        <div class="order-row">
                            <div class="widget-body">
                                <?php
                                $item_total = 0;
                                if(!empty($_SESSION["cart_item"])) {
                                    foreach ($_SESSION["cart_item"] as $item) {
                                ?>
                                    <div class="title-row">
                                        <span><?php echo $item["title"]; ?> x <?php echo $item["quantity"]; ?></span>
                                        <a href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>" class="text-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                    <p class="text-muted small">$<?php echo $item["price"]; ?></p>
                                <?php
                                        $item_total += ($item["price"]*$item["quantity"]);
                                    }
                                } else {
                                    echo '<p class="text-muted text-center py-4">Your cart is empty</p>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="price-wrap text-center">
                            <p class="small mb-1">TOTAL AMOUNT</p>
                            <h3 class="value"><strong>$<?php echo number_format($item_total, 2); ?></strong></h3>
                            <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check" class="btn theme-btn">Checkout Now</a>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                    <div class="menu-widget animate-up">
                        <div class="widget-heading">
                            <h3 class="widget-title">Menu Items</h3>
                        </div>
                        <div class="collapse in" id="popular2">
                            <?php 
                            $stmt = $db->prepare("select * from dishes where rs_id='$_GET[res_id]'");
                            $stmt->execute();
                            $products = $stmt->get_result();
                            if (!empty($products)) {
                                foreach($products as $product) {
                            ?>
                                <div class="food-item">
                                    <div class="row align-items-center">
                                        <div class="col-sm-8">
                                            <form method="post" action='dishes.php?res_id=<?php echo $_GET['res_id'];?>&action=add&id=<?php echo $product['d_id']; ?>'>
                                                <div class="rest-logo float-left">
                                                    <img src="admin/Res_img/dishes/<?php echo $product['img']; ?>" alt="Food">
                                                </div>
                                                <div class="rest-descr">
                                                    <h6><?php echo $product['title']; ?></h6>
                                                    <p><?php echo $product['slogan']; ?></p>
                                                </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="item-cart-info">
                                                <span class="price">$<?php echo $product['price']; ?></span>
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn theme-btn btn-sm">Add</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-md-12 col-lg-3">
                    <div class="widget animate-up">
                        <div class="widget-heading">
                            <h3 class="widget-title">Information</h3>
                        </div>
                        <div class="widget-body">
                            <p class="text-muted small">All items are prepared fresh. Delivery within 30-45 minutes depending on your location.</p>
                            <hr>
                            <h6 class="mb-3">Offers</h6>
                            <a href="#" class="tag">10% OFF</a>
                            <a href="#" class="tag">Free Delivery</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container text-center text-md-left">
                <div class="row top-footer">
                    <div class="col-xs-12 col-sm-4 mb-4">
                        <img src="images/food-picky-logo.png" alt="Logo" class="mb-3" style="height: 40px;">
                        <p class="text-muted">Discover the best food and drinks in your city.</p>
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
