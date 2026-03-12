<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

if(isset($_POST['update'])) {
    $form_id=$_GET['form_id'];
    $status=$_POST['status'];
    $remark=$_POST['remark'];
    $query=mysqli_query($db,"INSERT INTO remark(frm_id,status,remark) VALUES('$form_id','$status','$remark')");
    $sql=mysqli_query($db,"UPDATE users_orders SET status='$status' WHERE o_id='$form_id'");
    $success = true;
}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Order Status</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="css/modern-admin.css" rel="stylesheet">
    <script language="javascript" type="text/javascript">
        function f2() { window.close(); }
    </script>
    <style>
        body { background: #f8f9fa; font-family: 'Inter', sans-serif; padding: 20px; }
        .update-card { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; max-width: 500px; margin: auto; }
        .update-header { background: var(--secondary); color: white; padding: 25px; text-align: center; }
        .update-body { padding: 30px; }
        .form-label { font-weight: 600; color: #6c757d; font-size: 0.85rem; text-transform: uppercase; margin-bottom: 8px; display: block; }
        .btn-update { background: var(--primary); color: white; border: none; padding: 12px; border-radius: 8px; width: 100%; font-weight: 600; transition: 0.3s; margin-top: 10px; }
        .btn-update:hover { background: #e04d2e; transform: translateY(-2px); }
        .btn-close-popup { background: #eee; color: #666; border: none; padding: 12px; border-radius: 8px; width: 100%; font-weight: 600; margin-top: 10px; transition: 0.3s; }
        .btn-close-popup:hover { background: #ddd; }
    </style>
</head>

<body>
    <div class="update-card animate-fade">
        <div class="update-header">
            <h4 class="mb-0 font-weight-bold text-white">Update Order Status</h4>
            <p class="mb-0 opacity-75 small">Order ID: #<?php echo htmlentities($_GET['form_id']); ?></p>
        </div>
        <div class="update-body">
            <?php if($success): ?>
                <div class="alert alert-success text-center mb-4">
                    <strong>Success!</strong> Order status updated.
                </div>
            <?php endif; ?>

            <form name="updateticket" id="updatecomplaint" method="post">
                <div class="form-group mb-4">
                    <label class="form-label">New Status</label>
                    <select name="status" class="form-control custom-select" required>
                        <option value="">-- Select Status --</option>
                        <option value="in process">In Process</option>
                        <option value="closed">Closed (Delivered)</option>
                        <option value="rejected">Rejected (Cancelled)</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label">Remark / Note</label>
                    <textarea name="remark" class="form-control" rows="5" placeholder="Enter order notes here..." required></textarea>
                </div>

                <button type="submit" name="update" class="btn-update">
                    <i class="fa fa-check-circle mr-2"></i> Update Order
                </button>
                
                <button type="button" class="btn-close-popup" onClick="f2();">
                    Close Window
                </button>
            </form>
        </div>
    </div>
</body>
</html>