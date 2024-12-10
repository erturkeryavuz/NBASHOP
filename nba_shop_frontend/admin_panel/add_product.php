<?php
include("config.php");
include("logged_in_check.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $image = $_FILES['image']['name'];
    $target = "images/".basename($image);

    $sql = "INSERT INTO products (name, description, price, stock_quantity, category_id, image) 
            VALUES ('$name', '$description', '$price', '$stock_quantity', '$category_id', '$image')";
    if (mysqli_query($conn, $sql)) {
        $msg = "Product added successfully";
    } else {
        $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $msg .= " and image uploaded successfully";
    } else {
        $msg .= " but failed to upload image";
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
            <h1>Add Product</h1>
        </div> 
        <div id="content-container">
            <?php if (isset($msg)) { echo $msg; } ?>
            <form method="POST" enctype="multipart/form-data">
                <label>Name:</label>
                <input type="text" name="name" required>
                <label>Description:</label>
                <textarea name="description" required></textarea>
                <label>Price:</label>
                <input type="text" name="price" required>
                <label>Stock Quantity:</label>
                <input type="text" name="stock_quantity" required>
                <label>Category:</label>
                <select name="category_id" required>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM categories");
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                    ?>
                </select>
                <label>Image:</label>
                <input type="file" name="image" required>
                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
