<?php include('config.php'); ?>

<?php
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id == 0) {
    // En son eklenen ürünü al
    $query = "SELECT * FROM products ORDER BY created_at DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_id = $product['id'];
    } else {
        $product = null;
    }
} else {
    // Belirtilen ID'ye sahip ürünü al
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        $product = null;
    }
}
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
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="index.php" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">NBA</span>SHOP</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left"></div>
            <div class="col-lg-3 col-6 text-right">
                <a href="cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">
                        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 1;">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link" data-toggle="dropdown">Jerseys <i class="fa fa-angle-down float-right mt-1"></i></a>
                            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                                <a href="category.php?id=1" class="dropdown-item">Men's Jersey</a>
                                <a href="category.php?id=2" class="dropdown-item">Woman's Jersey</a>
                                <a href="category.php?id=3" class="dropdown-item">Teenager's Jersey</a>
                            </div>
                        </div>
                        <a href="category.php?id=4" class="nav-item nav-link">T-Shirts</a>
                        <a href="category.php?id=5" class="nav-item nav-link">Hoodies</a>
                        <a href="category.php?id=6" class="nav-item nav-link">Shorts</a>
                        <a href="category.php?id=7" class="nav-item nav-link">Tracksuits</a>
                        <a href="category.php?id=8" class="nav-item nav-link">Caps</a>
                        <a href="category.php?id=9" class="nav-item nav-link">Accessories</a>
                        <a href="category.php?id=10" class="nav-item nav-link">Footwear</a>
                        <a href="category.php?id=11" class="nav-item nav-link">Socks</a>
                        <a href="category.php?id=12" class="nav-item nav-link">Bags</a>
                    </div>
                </nav>
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
                            <a href="detail.php?id=<?php echo $product_id; ?>" class="nav-item nav-link active">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="cart.php" class="dropdown-item">Shopping Cart</a>
                                    <a href="checkout.php" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop Detail</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Shop Detail Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <?php if ($product): ?>
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="images/<?php echo $product['image']; ?>" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold"><?php echo $product['name']; ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(<?php echo '0'; ?> Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">$<?php echo $product['price']; ?></h3>
                <p class="mb-4"><?php echo $product['description']; ?></p>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        
                        
                    </div>
                </div>
            </div>
            <?php else: ?>
                <div class="col-12">
                    <p>Geçersiz ürün ID'si.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    <?php
                    if ($product) {
                        $category_id = $product['category_id'];
                        $query = "SELECT * FROM products WHERE category_id = $category_id AND id != $product_id LIMIT 4";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($similar_product = $result->fetch_assoc()) {
                                echo "<div class='card product-item border-0'>";
                                echo "<div class='card-header product-img position-relative overflow-hidden bg-transparent border p-0'>";
                                echo "<img class='img-fluid w-100' src='images/{$similar_product['image']}' alt='{$similar_product['name']}'>";
                                echo "</div>";
                                echo "<div class='card-body border-left border-right text-center p-0 pt-4 pb-3'>";
                                echo "<h6 class='text-truncate mb-3'>{$similar_product['name']}</h6>";
                                echo "<div class='d-flex justify-content-center'>";
                                echo "<h6>\${$similar_product['price']}</h6>";
                                echo "</div>";
                                echo "</div>";
                                echo "<div class='card-footer d-flex justify-content-between bg-light border'>";
                                echo "<a href='detail.php?id={$similar_product['id']}' class='btn btn-sm text-dark p-0'><i class='fas fa-eye text-primary mr-1'></i>View Detail</a>";
                                
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="index.php" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">NBA</span>SHOP</h1>
                </a>
                <p>Welcome to NBA Shop, your one-stop destination for all things NBA. From jerseys to accessories, we have everything you need to show your love for the game.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@nbashop.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">NBA Shop</a>. All Rights Reserved.
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
