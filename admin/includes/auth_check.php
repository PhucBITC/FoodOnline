<?php
session_start();
error_reporting(0);
if(empty($_SESSION["adm_id"])) {
    header('location:index.php');
    exit();
}
?>
