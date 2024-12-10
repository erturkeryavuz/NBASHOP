<?php
include("config.php");
include("logged_in_check.php");
?>

<?php include('header.php'); ?>

<body>
<div id="wrapper">
    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>
    <div id="content">      
        <div id="content-header">
            <h1>Product List</h1>
        </div> 
        <div id="content-container">
            <?php
            // Toplam ürün sayısını alın
            $query = "SELECT COUNT(*) as total_products FROM products";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            $total_products = $row['total_products'];

            // Sayfalandırma parametreleri
            $products_per_page = 10; // Her sayfada gösterilecek ürün sayısı
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $start = ($page - 1) * $products_per_page;

            // Ürünleri alın
            $query = "SELECT products.*, categories.name as category_name FROM products JOIN categories ON products.category_id = categories.id ORDER BY products.id ASC LIMIT $start, $products_per_page";
            $result = $conn->query($query);
            ?>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock Quantity</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['description']."</td>";
                    echo "<td>".$row['price']."</td>";
                    echo "<td>".$row['stock_quantity']."</td>";
                    echo "<td>".$row['category_name']."</td>";
                    echo "<td><img src='images/".$row['image']."' width='50'></td>";
                    echo "<td><a href='edit_product.php?id=".$row['id']."'>Edit</a> | <a href='delete_product.php?id=".$row['id']."'>Delete</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <!-- Sayfa numaralarını göster -->
            <div class="pagination">
                <?php
                $total_pages = ceil($total_products / $products_per_page);

                for ($i = 1; $i <= $total_pages; $i++) {
                    echo '<a href="product_list.php?page=' . $i . '">' . $i . '</a> ';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
