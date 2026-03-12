<?php
include("connection/connect.php");

$sql = "ALTER TABLE admin ADD COLUMN img VARCHAR(255) DEFAULT 'default.png' AFTER email";
if (mysqli_query($db, $sql)) {
    echo "Column 'img' added successfully.";
} else {
    echo "Error adding column: " . mysqli_error($db);
}
?>
