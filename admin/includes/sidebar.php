<head>
    <style>
        .left-sidebar {
            transition: var(--transition);
        }

        .scroll-sidebar {
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            padding-bottom: 20px;
        }

        /* Làm đẹp thanh cuộn */
        .scroll-sidebar::-webkit-scrollbar { width: 6px; }
        .scroll-sidebar::-webkit-scrollbar-track { background: transparent; }
        .scroll-sidebar::-webkit-scrollbar-thumb { background-color: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .scroll-sidebar::-webkit-scrollbar-thumb:hover { background-color: rgba(255, 255, 255, 0.4); }

        /* Sidebar active link styling */
        .sidebar-nav ul li a.active {
            color: #f38220 !important;
            background: rgba(243, 130, 32, 0.1) !important;
            border-left: 3px solid #f38220;
        }
        
        .sidebar-nav ul li a.active i {
            color: #f38220 !important;
        }
    </style>
</head>
<div class="left-sidebar">
    <div class="scroll-sidebar">
        <div class="p-4 text-center">
            <a href="dashboard.php">
                <img src="../images/food-picky-logo.png" alt="Logo" style="height: 35px; filter: brightness(0) invert(1);">
            </a>
        </div>
        <nav class="sidebar-nav">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <ul id="sidebarnav">
                <li class="nav-label">Main</li>
                <li> 
                    <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
                </li>
                
                <li class="nav-label">Management</li>
                <li> 
                    <a href="allusers.php" class="<?php echo ($current_page == 'allusers.php' || $current_page == 'update_users.php') ? 'active' : ''; ?>"><i class="fa fa-users"></i><span>Users</span></a>
                </li>
                <li> 
                    <a href="allrestraunt.php" class="<?php echo ($current_page == 'allrestraunt.php' || $current_page == 'update_restraunt.php') ? 'active' : ''; ?>"><i class="fa fa-university"></i><span>Restaurants</span></a>
                </li>
                <li> 
                    <a href="all_menu.php" class="<?php echo ($current_page == 'all_menu.php' || $current_page == 'update_menu.php') ? 'active' : ''; ?>"><i class="fa fa-cutlery"></i><span>Menu</span></a>
                </li>
                <li> 
                    <a href="all_orders.php" class="<?php echo ($current_page == 'all_orders.php' || $current_page == 'view_order.php') ? 'active' : ''; ?>"><i class="fa fa-shopping-cart"></i><span>Orders</span></a>
                </li>
                
                <li class="nav-label">Add Content</li>
                <li> 
                    <a href="add_category.php" class="<?php echo ($current_page == 'add_category.php' || $current_page == 'update_category.php') ? 'active' : ''; ?>"><i class="fa fa-plus-circle"></i><span>Category</span></a>
                </li>
                <li> 
                    <a href="add_restraunt.php" class="<?php echo ($current_page == 'add_restraunt.php') ? 'active' : ''; ?>"><i class="fa fa-plus-circle"></i><span>Restaurant</span></a>
                </li>
                <li> 
                    <a href="add_menu.php" class="<?php echo ($current_page == 'add_menu.php') ? 'active' : ''; ?>"><i class="fa fa-plus-circle"></i><span>Menu Item</span></a>
                </li>
                
                <li class="nav-divider mt-4" style="border-top: 1px solid rgba(255,255,255,0.1);"></li>
                <li> 
                    <a href="logout.php" class="text-danger"><i class="fa fa-power-off"></i><span>Logout</span></a>
                </li>
            </ul>
        </nav>
    </div>
</div>
