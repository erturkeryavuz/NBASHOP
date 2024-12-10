<?php
include("config.php");
include("logged_in_check.php");

$admin_id = $_GET['id'];
$sql = "DELETE FROM admin_table WHERE admin_id='$admin_id'";

if (mysqli_query($conn, $sql)) {
    header("Location: admin_list.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>
