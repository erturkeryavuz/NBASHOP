<?php
include("config.php");
include("logged_in_check.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
    $product = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $stock_quantity = $_POST['stock_quantity'];
        $category_id = $_POST['category_id'];
        $image = $_FILES['image']['name'];
        $target = "images/".basename($image);

        $sql = "UPDATE products SET 
                name='$name', 
                description='$description', 
                price='$price', 
                stock_quantity='$stock_quantity', 
                category_id='$category_id', 
                image='$image' 
                WHERE id=$id";
        mysqli_query($conn, $sql);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $msg = "Product updated successfully";
        } else {
            $msg = "Failed to upload image";
        }

        header("Location: product_list.php");
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
            <h1>Edit Product</h1>
        </div> 
        <div id="content-container">
            <?php if (isset($msg)) { echo $msg; } ?>
            <form method="POST" enctype="multipart/form-data">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
                <label>Description:</label>
                <textarea name="description" required><?php echo $product['description']; ?></textarea>
                <label>Price:</label>
                <input type="text" name="price" value="<?php echo $product['price']; ?>" required>
                <label>Stock Quantity:</label>
                <input type="text" name="stock_quantity" value="<?php echo $product['stock_quantity']; ?>" required>
                <label>Category:</label>
                <select name="category_id" required>
                    <?php
                    $result = mysqli_query($conn, "SELECT * FROM categories");
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='".$row['id']."'".($row['id'] == $product['category_id'] ? " selected" : "").">".$row['name']."</option>";
                    }
                    ?>
                </select>
                <label>Image:</label>
                <input type="file" name="image" required>
                <button type="submit">Update Product</button>
            </form>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
