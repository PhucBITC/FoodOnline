<?php
include("connection/connect.php");
error_reporting(0);
session_start();
include_once 'product-action.php';

// Fetch dish details
$dish_id = $_GET['d_id'];
$query_dish = mysqli_query($db, "SELECT * FROM dishes WHERE d_id='$dish_id'");
$dish = mysqli_fetch_array($query_dish);

if (!$dish) {
    header("Location: index.php");
    exit();
}

// Fetch restaurant details
$res_id = $dish['rs_id'];
$query_res = mysqli_query($db, "SELECT * FROM restaurant WHERE rs_id='$res_id'");
$restaurant = mysqli_fetch_array($query_res);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $dish['title']; ?> | FoodPicko</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/modern-ui.css" rel="stylesheet">
    <style>
        .dish-detail-hero {
            height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: center;
            color: white;
            border-radius: 0 0 var(--radius-lg) var(--radius-lg);
            overflow: hidden;
            margin-bottom: 3rem;
        }

        .dish-detail-hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .dish-badge {
            display: inline-block;
            padding: 6px 15px;
            background: var(--primary);
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .dish-price-large {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
        }

        .restaurant-link {
            display: inline-flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: var(--transition);
        }

        .restaurant-link:hover {
            color: white;
            text-decoration: none;
        }

        .restaurant-link i {
            margin-right: 8px;
            color: var(--primary);
        }

        .dish-main-card {
            background: var(--surface);
            border-radius: var(--radius-md);
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .order-action-box {
            background: #f8f9fa;
            border-radius: var(--radius-sm);
            padding: 1.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .quantity-input {
            width: 80px;
            text-align: center;
            border-radius: var(--radius-sm);
            margin-right: 10px;
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
                        <?php if(isset($_SESSION["adm_id"])): ?>
                            <li class="nav-item"><a href="admin/dashboard.php" class="nav-link text-primary font-weight-bold"> Admin Panel</a> </li>
                        <?php endif; ?>
                        <?php if(empty($_SESSION["user_id"]) && empty($_SESSION["adm_id"])): ?>
                            <li class="nav-item"><a href="login.php" class="nav-link">Login</a> </li>
                            <li class="nav-item"><a href="registration.php" class="nav-link">Signup</a> </li>
                        <?php else: ?>
                            <?php if(!empty($_SESSION["user_id"]) || !empty($_SESSION["adm_id"])): ?>
                                <li class="nav-item"><a href="your_orders.php" class="nav-link">Your Orders</a> </li>
                            <?php endif; ?>
                            <li class="nav-item"><a href="logout.php" class="nav-link text-danger">Logout</a> </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="page-wrapper">
        <section class="dish-detail-hero animate-up" style="background-image: url('admin/Res_img/dishes/<?php echo $dish['img']; ?>');">
            <div class="container">
                <div class="hero-content">
                    <div class="dish-badge">Popular Dish</div>
                    <h1 class="display-4 font-weight-bold mb-2"><?php echo $dish['title']; ?></h1>
                    <div class="d-flex align-items-center mb-4">
                        <a href="dishes.php?res_id=<?php echo $restaurant['rs_id']; ?>" class="restaurant-link h5 mb-0">
                            <i class="fa fa-cutlery"></i> <?php echo $restaurant['title']; ?>
                        </a>
                        <span class="mx-3 opacity-50">|</span>
                        <span class="text-white-50"><i class="fa fa-map-marker text-primary mr-2"></i><?php echo $restaurant['address']; ?></span>
                    </div>
                    <div class="dish-price-large">$<?php echo $dish['price']; ?></div>
                </div>
            </div>
        </section>

        <div class="container">
            <div class="row">
                <!-- Left Sidebar: Cart -->
                <div class="col-lg-3">
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
                                        <a href="dish_detail.php?d_id=<?php echo $dish_id; ?>&action=remove&id=<?php echo $item["d_id"]; ?>" class="text-danger">
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
                            <a href="checkout.php?res_id=<?php echo $res_id;?>&action=check" class="btn theme-btn">Checkout Now</a>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-6">
                    <div class="dish-main-card animate-up">
                        <h2 class="font-weight-bold mb-4">Description</h2>
                        <p class="lead text-muted mb-5">
                            <?php echo !empty($dish['slogan']) ? $dish['slogan'] : "No detailed description available for this dish yet. However, we guarantee it's prepared with the freshest ingredients and culinary passion."; ?>
                        </p>
                        
                        <div class="order-action-box">
                            <h5 class="font-weight-bold mb-3">Order this Dish</h5>
                            <form method="post" action='dish_detail.php?d_id=<?php echo $dish_id; ?>&action=add&id=<?php echo $dish['d_id']; ?>' class="d-flex align-items-center flex-nowrap">
                               <div class="dieuNgang" style="display: flex; justify-content: space-between;">
                                    <div class="form-group mb-0" style="margin-right: 25px;">
                                        <label class="sr-only">Quantity</label>
                                        <input type="number" name="quantity" class="form-control quantity-input" value="1" min="1" style="width: 90px; height: 48px; font-weight: 600;">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1" style="white-space: nowrap; height: 48px;">Add to Cart</button>
                               </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar: Info -->
                <div class="col-lg-3">
                    <div class="widget animate-up">
                        <div class="widget-heading">
                            <h3 class="widget-title">Information</h3>
                        </div>
                        <div class="widget-body">
                            <p class="text-muted small">All items are prepared fresh. Delivery within 30-45 minutes depending on your location.</p>
                            <hr>
                            <h6 class="mb-3 font-weight-bold">Restaurant Hours</h6>
                            <p class="small text-muted mb-2"><i class="fa fa-clock-o text-primary mr-2"></i> Mon-Fri: 9:00 AM - 10:00 PM</p>
                            <p class="small text-muted"><i class="fa fa-clock-o text-primary mr-2"></i> Sat-Sun: 10:00 AM - 11:00 PM</p>
                            <hr>
                            <h6 class="mb-3 font-weight-bold">Available Offers</h6>
                            <div class="d-flex flex-wrap">
                                <span class="tag">10% OFF</span>
                                <span class="tag">Free Delivery</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
