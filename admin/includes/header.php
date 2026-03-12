<div class="header">
    <nav class="navbar top-navbar">
        <div class="d-flex align-items-center">
            <button class="btn btn-link text-dark sidebar-toggle mr-3" id="sidebarCollapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>
        <?php 
            $admin_data = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM admin WHERE adm_id='".$_SESSION['adm_id']."'"));
            $admin_img = !empty($admin_data['img']) ? 'images/users/'.$admin_data['img'] : 'images/users/profile.png';
        ?>
        <div class="ml-auto d-flex align-items-center">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-muted p-0" href="#" data-toggle="dropdown">
                    <img src="<?php echo $admin_img; ?>" alt="user" class="rounded-circle" style="width: 35px; height: 35px; border: 2px solid var(--primary); object-fit: cover;">
                    <span class="ml-2 font-weight-bold" style="color: var(--secondary);"><?php echo $admin_data['username']; ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow border-0 mt-3 animate-fade" style="border-radius: 12px;">
                    <a class="dropdown-item py-2" href="../index.php"><i class="fa fa-home mr-2"></i> View Site</a>
                    <a class="dropdown-item py-2" href="profile.php"><i class="fa fa-user mr-2"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item py-2" href="logout.php"><i class="fa fa-power-off mr-2"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>
</div>
