<?php
include("config.php");
include("logged_in_check.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
        header("Location: product_list.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}
?>
