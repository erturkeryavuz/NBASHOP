<?php
// Hata raporlamayı etkinleştirme
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('config.php');

if (!isset($_GET['id'])) {
    die("Kategori ID'si belirtilmemiş");
}

$category_id = intval($_GET['id']);

// Kategori adını çek
$result = mysqli_query($conn, "SELECT name FROM categories WHERE id = $category_id");
if (!$result) {
    die("Kategori adı alınamadı: " . mysqli_error($conn));
}
$category_name = mysqli_fetch_assoc($result)['name'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NBA-SHOP</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    <!-- Custom CSS for product layout -->
    <style>
        .product {
            width: 100%;
            max-width: 300px; /* Her bir ürünün genişliğini belirler */
            margin: 15px; /* Ürünler arası boşluk */
            float: left; /* Ürünleri yan yana dizmek için */
            box-sizing: border-box;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }

        .product img {
            width: 100%;
            height: auto;
        }

        .product h2 {
            font-size: 20px;
            margin: 10px 0;
        }

        .product p {
            font-size: 14px;
        }

        #content-container {
            display: flex;
            flex-wrap: wrap; /* Ürünlerin ekran genişliğine göre yeni satıra geçmesini sağlar */
            justify-content: space-between; /* Ürünler arasındaki boşluğu düzenler */
        }
    </style>
</head>

<body>
    <!-- Topbar Start -->
    <?php include('top_bar.php'); ?>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <?php include('left_sidebar.php'); ?>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">NBA</span>SHOP</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <a href="shop.php" class="nav-item nav-link">Shop</a>
                            <a href="detail.php" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="login.php" class="nav-item nav-link">Login</a>
                            <a href="register.php" class="nav-item nav-link">Register</a>
                        </div>
                    </div>
                </nav>
                <div id="content">
                    <div id="content-header">
                        <h1><?php echo htmlspecialchars($category_name); ?></h1>
                    </div>
                    <div id="content-container">
                        <?php
                        // Ürünleri seç ve görüntüle
                        $result = mysqli_query($conn, "SELECT * FROM products WHERE category_id = $category_id");
                        if (!$result) {
                            die("Ürünler alınamadı: " . mysqli_error($conn));
                        }
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<div class='product'>";
                                echo "<img src='images/".htmlspecialchars($row['image'])."' alt='".htmlspecialchars($row['name'])."'>";
                                echo "<h2>".htmlspecialchars($row['name'])."</h2>";
                                echo "<p>".htmlspecialchars($row['description'])."</p>";
                                echo "<p>Price: $".htmlspecialchars($row['price'])."</p>";
                                echo "<p>Stock: ".htmlspecialchars($row['stock_quantity'])."</p>";
                                echo "</div>";
                            }
                        } else {
                            echo "No products found in this category.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Footer Start -->
    <?php include('footer.php'); ?>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
