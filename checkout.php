<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();

if(empty($_SESSION["user_id"])) {
    header('location:login.php');
} else {
    $item_total = 0;
    if(isset($_SESSION["cart_item"])) {
        foreach ($_SESSION["cart_item"] as $item) {
            $item_total += ($item["price"]*$item["quantity"]);
        }
    }

    if(isset($_POST['submit'])) {
        foreach ($_SESSION["cart_item"] as $item) {
            $SQL="insert into users_orders(u_id,title,quantity,price) values('".$_SESSION["user_id"]."','".$item["title"]."','".$item["quantity"]."','".$item["price"]."')";
            mysqli_query($db,$SQL);
        }
        $success = "Thank you! Your order has been placed successfully!";
        unset($_SESSION["cart_item"]);
    }
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Checkout | FoodPicko</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/modern-ui.css" rel="stylesheet">
    <style>
        .checkout-widget {
            background: var(--surface);
            border-radius: var(--radius-md);
            padding: 2rem;
            box-shadow: var(--shadow-sm);
        }
        .payment-option-card {
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: var(--radius-sm);
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }
        .payment-option-card:hover:not(.disabled) {
            border-color: var(--primary);
            background: #fffcf9;
        }
        .payment-option-card.active {
            border-color: var(--primary);
            background: #fffcf9;
            box-shadow: 0 0 0 1px var(--primary);
        }
        .custom-radio-check {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
            position: relative;
        }
        input[type="radio"]:checked + .custom-radio-check {
            border-color: var(--primary);
        }
        input[type="radio"]:checked + .custom-radio-check::after {
            content: '';
            width: 10px;
            height: 10px;
            background: var(--primary);
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .payment-option-card input[type="radio"] {
            display: none;
        }
    </style>
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
                        <?php if(!empty($_SESSION["user_id"])): ?>
                            <li class="nav-item"> <a class="nav-link" href="your_orders.php">Your Orders</a></li>
                            <li class="nav-item"> <a class="nav-link text-danger" href="logout.php">Logout</a> </li>
                        <?php else: ?>
                            <li class="nav-item"><a href="login.php" class="nav-link">Login</a> </li>
                            <li class="nav-item"><a href="registration.php" class="nav-link">Signup</a> </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-wrapper">
        <div class="inner-page-hero animate-up" style="background-image: url('images/modern-hero.jpg'); height: 200px;">
            <div class="container text-center">
                <h1 class="text-white">Checkout</h1>
            </div>
        </div>

        <div class="container mt-5">
            <?php if(isset($success)): ?>
                <div class="alert alert-success animate-up">
                    <i class="fa fa-check-circle mr-2"></i> <?php echo $success; ?>
                    <div class="mt-2">
                        <a href="your_orders.php" class="btn btn-success btn-sm">View My Orders</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(!isset($success)): ?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout-widget animate-up mb-4">
                            <h4 class="mb-4">Select Payment Method</h4>
                            
                            <label class="payment-option-card active d-block">
                                <input type="radio" name="mod" value="COD" checked>
                                <span class="custom-radio-check"></span>
                                <span class="font-weight-bold mr-2">Cash on Delivery</span>
                                <span class="text-muted small">Pay when your food arrives</span>
                            </label>

                            <label class="payment-option-card disabled d-block text-muted" style="cursor: not-allowed; opacity: 0.7;">
                                <input type="radio" name="mod" value="paypal" disabled>
                                <span class="custom-radio-check"></span>
                                <span class="font-weight-bold mr-2">Paypal</span>
                                <img src="images/paypal.png" alt="Paypal" style="height: 20px;">
                                <span class="small ml-2">(Currently Unavailable)</span>
                            </label>

                            <div class="mt-4 p-3 bg-light rounded">
                                <p class="mb-0 small text-muted"><i class="fa fa-info-circle mr-1"></i> Cash on Delivery is currently the only available payment method. Please ensure you have the exact change if possible.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="widget-cart animate-up">
                            <div class="widget-heading p-4">
                                <h4 class="mb-0">Order Summary</h4>
                            </div>
                            <div class="p-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Items Subtotal</span>
                                    <span class="font-weight-bold">$<?php echo number_format($item_total, 2); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Delivery Fee</span>
                                    <span class="text-success font-weight-bold">Free</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="h5 mb-0">Total</span>
                                    <span class="h4 mb-0 text-primary font-weight-bold">$<?php echo number_format($item_total, 2); ?></span>
                                </div>
                                
                                <button type="submit" name="submit" onclick="return confirm('Place this order?');" class="btn btn-primary btn-block btn-lg py-3">
                                    Place Order <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>

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
