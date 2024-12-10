<?php
session_start();
include('config.php');

// Admin oturumu kontrolü (Eğer admin girişi kontrolü varsa)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Siparişleri ve sipariş detaylarını veritabanından çekme
$query = "SELECT orders.*, order_items.product_id, order_items.quantity, products.name as product_name, products.image as product_image, products.price as product_price 
          FROM orders 
          JOIN order_items ON orders.id = order_items.order_id 
          JOIN products ON order_items.product_id = products.id 
          ORDER BY orders.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('header.php'); ?>
    <div id="wrapper">
        <?php include('top_bar.php'); ?>
        <?php include('left_sidebar.php'); ?>

        <div id="content">      
            <div id="content-header">
                <h1>Orders</h1>
            </div> <!-- #content-header --> 

            <div id="content-container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <h2>Recent Orders</h2>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address1</th>
                                    <th>Address2</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>ZIP</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($order = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $order['order_number']; ?></td>
                                    <td><?php echo $order['first_name']; ?></td>
                                    <td><?php echo $order['last_name']; ?></td>
                                    <td><?php echo $order['email']; ?></td>
                                    <td><?php echo $order['mobile']; ?></td>
                                    <td><?php echo $order['address1']; ?></td>
                                    <td><?php echo $order['address2']; ?></td>
                                    <td><?php echo $order['country']; ?></td>
                                    <td><?php echo $order['city']; ?></td>
                                    <td><?php echo $order['state']; ?></td>
                                    <td><?php echo $order['zip']; ?></td>
                                    <td>
                                        <img src="path_to_images/<?php echo $order['product_image']; ?>" alt="<?php echo $order['product_name']; ?>" style="width: 50px;">
                                        <?php echo $order['product_name']; ?>
                                    </td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td>$<?php echo $order['product_price']; ?></td>
                                    <td>$<?php echo $order['total_price']; ?></td>
                                    <td><?php echo $order['created_at']; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div> <!-- /#content-container -->
        </div> <!-- #content -->    
    </div> <!-- #wrapper -->
    <?php include('footer.php'); ?>
</body>
</html>
