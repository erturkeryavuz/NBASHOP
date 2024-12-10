<?php
include('config.php');

// Fetch categories from the database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);
$categories = [];
while ($category_row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $category_row;
}

// Fetch top selling products
$top_selling_query = "SELECT p.*, SUM(oi.quantity) as total_sales FROM products p JOIN order_items oi ON p.id = oi.product_id GROUP BY p.id ORDER BY total_sales DESC LIMIT 3";
$top_selling_result = mysqli_query($conn, $top_selling_query);
$top_selling_products = [];
while ($row = mysqli_fetch_assoc($top_selling_result)) {
    $top_selling_products[] = $row;
}

// Fetch top stock products
$top_stock_query = "SELECT * FROM products ORDER BY stock_quantity DESC LIMIT 3";
$top_stock_result = mysqli_query($conn, $top_stock_query);
$top_stock_products = [];
while ($row = mysqli_fetch_assoc($top_stock_result)) {
    $top_stock_products[] = $row;
}

// Fetch top priced products
$top_priced_query = "SELECT * FROM products ORDER BY price DESC LIMIT 3";
$top_priced_result = mysqli_query($conn, $top_priced_query);
$top_priced_products = [];
while ($row = mysqli_fetch_assoc($top_priced_result)) {
    $top_priced_products[] = $row;
}

// Fetch cheapest products
$cheapest_query = "SELECT * FROM products ORDER BY price ASC LIMIT 3";
$cheapest_result = mysqli_query($conn, $cheapest_query);
$cheapest_products = [];
while ($row = mysqli_fetch_assoc($cheapest_result)) {
    $cheapest_products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NBA Shop</title>
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
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="cart.php" class="btn border">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge">0</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0" id="navbar-vertical">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <div class="nav-item dropdown">
                            <a class="nav-link" data-toggle="collapse" href="#navbar-jerseys" role="button" aria-expanded="false" aria-controls="navbar-jerseys">Jerseys <i class="fa fa-angle-down float-right mt-1"></i></a>
                            <div class="collapse" id="navbar-jerseys">
                                <div class="bg-secondary border-0 rounded-0 w-100 m-0">
                                    <a href="category.php?id=1" class="dropdown-item">Men's Jersey</a>
                                    <a href="category.php?id=2" class="dropdown-item">Woman's Jersey</a>
                                    <a href="category.php?id=3" class="dropdown-item">Teenager's Jersey</a>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($categories as $category): ?>
                            <?php if ($category['name'] != "Men's Jersey" && $category['name'] != "Woman's Jersey" && $category['name'] != "Teenager's Jersey"): ?>
                                <a class="nav-item nav-link" href="category.php?id=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="index.php" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">NBA</span>SHOP</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
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
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($top_selling_products as $index => $product): ?>
                            <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>" style="height: 410px;">
                                <img class="img-fluid" src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h4 class="text-light text-uppercase font-weight-medium mb-3">Top Selling Product</h4>
                                        <h3 class="display-4 text-white font-weight-semi-bold mb-4"><?php echo $product['name']; ?></h3>
                                        <p class="text-white mb-4">$<?php echo $product['price']; ?></p>
                                        <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-light py-2 px-3">View Detail</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Top Selling Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Top Selling Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php foreach ($top_selling_products as $product): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?php echo $product['name']; ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6>$<?php echo $product['price']; ?></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Top Selling Products End -->

    <!-- Top Stock Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Top Stock Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php foreach ($top_stock_products as $product): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?php echo $product['name']; ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6>$<?php echo $product['price']; ?></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Top Stock Products End -->

    <!-- Top Priced Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Top Priced Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php foreach ($top_priced_products as $product): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?php echo $product['name']; ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6>$<?php echo $product['price']; ?></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Top Priced Products End -->

    <!-- Cheapest Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Cheapest Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php foreach ($cheapest_products as $product): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3"><?php echo $product['name']; ?></h6>
                            <div class="d-flex justify-content-center">
                                <h6>$<?php echo $product['price']; ?></h6>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-light border">
                            <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Cheapest Products End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">NBA Shop</h5>
                <p class="mb-4">NBA Shop is the official online store for NBA fans around the world. We provide a wide variety of merchandise for all NBA teams.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 NBA St, Los Angeles, USA</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>support@nbashop.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Shop</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Shop</a>
                            <a class="text-secondary mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">My Account</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Shop</a>
                            <a class="text-secondary mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Subscribe to our newsletter to get the latest updates and offers.</p>
                        <form action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Your Email Address">
                                <div class="input-group-append">
                                    <button class="btn btn-primary">Sign Up</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="#">NBA Shop</a>. All Rights Reserved.
                </p>
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

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
