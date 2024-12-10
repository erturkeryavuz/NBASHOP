<?php
include('config.php');

// Add to cart functionality
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = intval($_GET['id']);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['cart'][$id] = 1;
    }
    header('Location: cart.php');
    exit();
}

// Fetch categories from the database
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);
$categories = [];
while ($category_row = mysqli_fetch_assoc($category_result)) {
    $categories[] = $category_row;
}

// Filters
$category_filter = isset($_GET['category']) ? $_GET['category'] : [];
$price_min = isset($_GET['price_min']) ? $_GET['price_min'] : 0;
$price_max = isset($_GET['price_max']) ? $_GET['price_max'] : 10000; // Max price can be adjusted
$stock_min = isset($_GET['stock_min']) ? $_GET['stock_min'] : 0;
$stock_max = isset($_GET['stock_max']) ? $_GET['stock_max'] : 10000; // Max stock can be adjusted
$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination variables
$items_per_page = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $items_per_page;

// Total products count query for pagination
$count_query = "SELECT COUNT(*) as total FROM products WHERE price >= $price_min AND price <= $price_max AND stock_quantity >= $stock_min AND stock_quantity <= $stock_max";

// Add category filter to count query
if (!empty($category_filter)) {
    $categories_imploded = implode(',', array_map('intval', (array)$category_filter));
    $count_query .= " AND category_id IN ($categories_imploded)";
}

// Add search filter to count query
if (!empty($search_query)) {
    $count_query .= " AND name LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%'";
}

$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_products = $count_row['total'];
$total_pages = ceil($total_products / $items_per_page);

$query = "SELECT * FROM products WHERE price >= $price_min AND price <= $price_max AND stock_quantity >= $stock_min AND stock_quantity <= $stock_max";

// Add category filter to main query
if (!empty($category_filter)) {
    $categories_imploded = implode(',', array_map('intval', (array)$category_filter));
    $query .= " AND category_id IN ($categories_imploded)";
}

// Add search filter to main query
if (!empty($search_query)) {
    $query .= " AND name LIKE '%" . mysqli_real_escape_string($conn, $search_query) . "%'";
}

// Fetch products with pagination
$query .= " ORDER BY id LIMIT $items_per_page OFFSET $offset";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Failed to fetch products: " . mysqli_error($conn));
}

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NBA Shop</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
                            <a href="detail.php" class="nav-item nav-link active">Shop Detail</a>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <!-- Price and Stock Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by</h5>
                    <form method="GET" action="shop.php">
                        <div class="mb-4">
                            <h6 class="font-weight-semi-bold mb-3">Price</h6>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <input type="number" class="form-control" placeholder="Min" name="price_min" value="<?php echo $price_min; ?>">
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <input type="number" class="form-control" placeholder="Max" name="price_max" value="<?php echo $price_max; ?>">
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-weight-semi-bold mb-3">Stock</h6>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <input type="number" class="form-control" placeholder="Min" name="stock_min" value="<?php echo $stock_min; ?>">
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <input type="number" class="form-control" placeholder="Max" name="stock_max" value="<?php echo $stock_max; ?>">
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="font-weight-semi-bold mb-3">Category</h6>
                            <?php foreach ($categories as $category): ?>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="category-<?php echo $category['id']; ?>" name="category[]" value="<?php echo $category['id']; ?>" <?php if (in_array($category['id'], (array)$category_filter)) echo 'checked'; ?>>
                                    <label class="custom-control-label" for="category-<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Apply</button>
                    </form>
                </div>
                <!-- Price and Stock End -->
            </div>
            <!-- Shop Sidebar End -->

            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="shop.php" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" placeholder="Search by name">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort by
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                    <a class="dropdown-item" href="#">Latest</a>
                                    <a class="dropdown-item" href="#">Popularity</a>
                                    <a class="dropdown-item" href="#">Best Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                            <div class="card product-item border-0 mb-4">
                                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="height: 300px; object-fit: cover;">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3"><?php echo $product['name']; ?></h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>$<?php echo $product['price']; ?></h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="detail.php?id=<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                    <a href="shop.php?action=add&id=<?php echo $product['id']; ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination Start -->
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if($page > 1) echo '?page='.($page - 1); else echo '#'; ?>">Previous</a>
                                </li>
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                                    <a class="page-link" href="<?php if($page < $total_pages) echo '?page='.($page + 1); else echo '#'; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Pagination End -->
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">Get In Touch</h5>
                <p class="mb-4">NBA Shop, providing official NBA products online. We offer high-quality products and fast shipping to give our customers the best shopping experience.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Ataşehir, Istanbul, Turkey</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@nbashop.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+90 555 555 5555</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-secondary mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-secondary mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-secondary mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-secondary mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-secondary" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Newsletter</h5>
                        <p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat.</p>
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
