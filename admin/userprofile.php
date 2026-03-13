<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(empty($_SESSION['adm_id']) && empty($_SESSION['user_id'])) { 
    header('location:../login.php');
} else {
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Profile</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/modern-admin.css" rel="stylesheet">
    <script language="javascript" type="text/javascript">
        function f2() { window.close(); }
        function f3() { window.print(); }
    </script>
    <style>
        body { background: #f8f9fa; font-family: 'Inter', sans-serif; padding: 20px; }
        .profile-card { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; max-width: 600px; margin: auto; }
        .profile-header { background: var(--primary); color: white; padding: 30px; text-align: center; }
        .profile-img { width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; margin-bottom: 15px; object-fit: cover; }
        .profile-body { padding: 30px; }
        .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #eee; }
        .info-label { font-weight: 600; color: #6c757d; font-size: 0.9rem; }
        .info-value { color: #212529; font-weight: 500; }
        .btn-close-custom { background: #fee; color: #e74c3c; border: none; padding: 10px 20px; border-radius: 8px; width: 100%; transition: 0.3s; font-weight: 600; margin-top: 20px; }
        .btn-close-custom:hover { background: #e74c3c; color: white; }
    </style>
</head>

<body>
    <div class="profile-card animate-fade">
        <?php 
            $ret1=mysqli_query($db,"select * FROM users_orders where o_id='".$_GET['newform_id']."'");
            $ro=mysqli_fetch_array($ret1);
            
            if(!empty($ro['adm_id'])) {
                // It's an admin order
                $ret2=mysqli_query($db,"select *, username as f_name, '' as l_name, 'N/A' as phone, 'Active' as status_text FROM admin where adm_id='".$ro['adm_id']."'");
            } else {
                // It's a regular user order
                $ret2=mysqli_query($db,"select *, (case when status=1 then 'Active' else 'Blocked' end) as status_text FROM users where u_id='".$ro['u_id']."'");
            }
            
            while($row=mysqli_fetch_array($ret2)) {
        ?>
        <div class="profile-header">
            <img src="images/users/5.jpg" alt="user" class="profile-img">
            <h3 class="mb-0 font-weight-bold"><?php echo $row['f_name'] . ' ' . $row['l_name'];?></h3>
            <p class="mb-0 opacity-75">Customer Profile</p>
        </div>
        <div class="profile-body">
            <div class="info-row">
                <span class="info-label">Register Date</span>
                <span class="info-value"><?php echo date("M d, Y", strtotime($row['date'])); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Username</span>
                <span class="info-value"><?php echo $row['username']; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value"><?php echo $row['email']; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Phone</span>
                <span class="info-value"><?php echo $row['phone']; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Account Status</span>
                <span class="info-value">
                    <?php 
                        $badge_class = ($row['status_text'] == 'Active') ? 'status-delivered' : 'status-cancelled';
                        echo "<span class='status-badge $badge_class'>".$row['status_text']."</span>";
                    ?>
                </span>
            </div>
            
            <button class="btn-close-custom mt-4" onClick="return f2();">
                <i class="fa fa-times-circle mr-2"></i> Close Window
            </button>
        </div>
        <?php } ?>
    </div>
</body>
</html>
<?php } ?>