<?php
include('config.php');
include('logged_in_check.php');
?>

<?php include('header.php'); ?>

<body>

<div id="wrapper">

    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>

    <div id="content">      
        <div id="content-header">
            <h1>Order List</h1>
        </div> <!-- #content-header --> 

        <div id="content-container">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <h2>Recent Orders</h2>
                    <?php
                    // Toplam sipariş sayısını alın
                    $query = "SELECT COUNT(*) as total_orders FROM orders";
                    $result = $conn->query($query);
                    $row = $result->fetch_assoc();
                    $total_orders = $row['total_orders'];

                    // Sayfalandırma parametreleri
                    $orders_per_page = 10; // Her sayfada gösterilecek sipariş sayısı
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $start = ($page - 1) * $orders_per_page;

                    // Siparişleri alın
                    $query = "SELECT * FROM orders ORDER BY created_at DESC LIMIT $start, $orders_per_page";
                    $result = $conn->query($query);
                    ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>State</th>
                                <th>ZIP</th>
                                <th>Total Price</th>
                                <th>Order Date & Estimated Delivery</th>
                                <th>Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($order = mysqli_fetch_assoc($result)) {
                                $order_id = $order['id'];
                                echo "<tr>";
                                echo "<td>{$order['order_number']}</td>";
                                echo "<td>{$order['first_name']}</td>";
                                echo "<td>{$order['last_name']}</td>";
                                echo "<td>{$order['email']}</td>";
                                echo "<td>{$order['mobile']}</td>";
                                echo "<td>{$order['address1']} {$order['address2']}</td>";
                                echo "<td>{$order['country']}</td>";
                                echo "<td>{$order['city']}</td>";
                                echo "<td>{$order['state']}</td>";
                                echo "<td>{$order['zip']}</td>";
                                echo "<td>$ {$order['total_price']}</td>";
                                echo "<td>{$order['created_at']}<br>Estimated: {$order['estimated_delivery']}</td>";
                                
                                // Ürünleri getirme
                                $product_query = "SELECT oi.quantity, p.name, p.price, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id";
                                $product_result = mysqli_query($conn, $product_query);
                                echo "<td>";
                                while ($product = mysqli_fetch_assoc($product_result)) {
                                    $image_path = "images/{$product['image']}"; // Resim yolunu güncelledik
                                    echo "{$product['name']} (x{$product['quantity']}) - $ {$product['price']} <br><img src='{$image_path}' width='50'><br>";
                                }
                                echo "</td>";
                                
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Sayfa numaralarını göster -->
                    <div class="pagination">
                        <?php
                        $total_pages = ceil($total_orders / $orders_per_page);

                        for ($i = 1; $i <= $total_pages; $i++) {
                            echo '<a href="order_list.php?page=' . $i . '">' . $i . '</a> ';
                        }
                        ?>
                    </div>
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /#content-container -->
    </div> <!-- #content -->    
    
</div> <!-- #wrapper -->

<?php include('footer.php'); ?>

</body>
</html>
