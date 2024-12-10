<?php
include("config.php");
include("logged_in_check.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM categories WHERE id=$id");
    $category = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $sql = "UPDATE categories SET name='$name' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            header("Location: category_list.php");
        } else {
            $msg = "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>

<?php include('header.php'); ?>

<body>
<div id="wrapper">
    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>
    <div id="content">      
        <div id="content-header">
            <h1>Edit Category</h1>
        </div> 
        <div id="content-container">
            <?php if (isset($msg)) { echo $msg; } ?>
            <form method="POST">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $category['name']; ?>" required>
                <button type="submit">Update Category</button>
            </form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
