<?php
include("config.php");
include("logged_in_check.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $sql = "INSERT INTO categories (name) VALUES ('$name')";
    if (mysqli_query($conn, $sql)) {
        $msg = "Category added successfully";
    } else {
        $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
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
            <h1>Add Category</h1>
        </div> 
        <div id="content-container">
            <?php if (isset($msg)) { echo $msg; } ?>
            <form method="POST">
                <label>Name:</label>
                <input type="text" name="name" required>
                <button type="submit">Add Category</button>
            </form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
