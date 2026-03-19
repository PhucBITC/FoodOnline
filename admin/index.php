<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

// Redirect to the main login page in the root directory
header("Location: ../login.php");
exit();
?>
