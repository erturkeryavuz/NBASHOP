<?php
session_start();
include('config.php');

// AJAX ile sepete ekleme ve çıkarma işlemleri
if (isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
    $product_id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'add') {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    } elseif ($action == 'remove') {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]--;
            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    } elseif ($action == 'delete') {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }

    // Sepetteki ürünleri getirme ve toplam fiyatı hesaplama
    $cart_products = [];
    $total_price = 0;
    if (!empty($_SESSION['cart'])) {
        $product_ids = implode(',', array_keys($_SESSION['cart']));
        $query = "SELECT * FROM products WHERE id IN ($product_ids)";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $row['quantity'] = $_SESSION['cart'][$row['id']];
            $cart_products[] = $row;
            $total_price += $row['price'] * $row['quantity'];
        }
    }

    // JSON formatında yanıt döndürme
    $response = [
        'cart_products' => $cart_products,
        'total_price' => $total_price
    ];
    echo json_encode($response);
    exit();
}

// Sepetteki ürünleri getirme
$cart_products = [];
$total_price = 0;
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($product_ids)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['quantity'] = $_SESSION['cart'][$row['id']];
        $cart_products[] = $row;
        $total_price += $row['price'] * $row['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Shopping Cart - NBA Shop</title>
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
                    <span class="badge"><?php echo array_sum($_SESSION['cart'] ?? []); ?></span>
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
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="cart-body">
                        <?php if (!empty($cart_products)): ?>
                            <?php foreach ($cart_products as $product): ?>
                                <tr>
                                    <td class="align-middle"><img src="images/<?php echo $product['image']; ?>" alt="" style="width: 50px;"></td>
                                    <td class="align-middle"><?php echo $product['name']; ?></td>
                                    <td class="align-middle">$<?php echo $product['price']; ?></td>
                                    <td class="align-middle">
                                        <div class="input-group quantity mx-auto" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button onclick="updateCart('remove', <?php echo $product['id']; ?>)" class="btn btn-sm btn-primary btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm bg-secondary text-center" value="<?php echo $product['quantity']; ?>" readonly>
                                            <div class="input-group-btn">
                                                <button onclick="updateCart('add', <?php echo $product['id']; ?>)" class="btn btn-sm btn-primary btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">$<?php echo $product['price'] * $product['quantity']; ?></td>
                                    <td class="align-middle"><button onclick="updateCart('delete', <?php echo $product['id']; ?>)" class="btn btn-sm btn-danger">Remove</button></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="4" class="text-right">Total</td>
                                <td class="align-middle">$<?php echo $total_price; ?></td>
                                <td></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Your cart is empty</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="font-weight-medium">Subtotal</h5>
                            <h5 class="font-weight-medium" id="subtotal">$<?php echo $total_price; ?></h5>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="font-weight-medium">Shipping</h5>
                            <h5 class="font-weight-medium">$10</h5>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="total">$<?php echo $total_price + 10; ?></h5>
                        </div>
                        <a href="checkout.php" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

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
                            <a class="text-secondary mb-2" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
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

    <!-- Custom Javascript -->
    <script>
        function updateCart(action, id) {
            $.ajax({
                url: 'cart.php',
                method: 'GET',
                data: {
                    action: action,
                    id: id,
                    ajax: true
                },
                success: function(response) {
                    let data = JSON.parse(response);
                    $('#cart-body').html('');
                    let total_price = 0;

                    data.cart_products.forEach(product => {
                        $('#cart-body').append(`
                            <tr>
                                <td class="align-middle"><img src="images/${product.image}" alt="" style="width: 50px;"></td>
                                <td class="align-middle">${product.name}</td>
                                <td class="align-middle">$${product.price}</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button onclick="updateCart('remove', ${product.id})" class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="${product.quantity}" readonly>
                                        <div class="input-group-btn">
                                            <button onclick="updateCart('add', ${product.id})" class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">$${product.price * product.quantity}</td>
                                <td class="align-middle"><button onclick="updateCart('delete', ${product.id})" class="btn btn-sm btn-danger">Remove</button></td>
                            </tr>
                        `);
                        total_price += product.price * product.quantity;
                    });

                    $('#cart-body').append(`
                        <tr>
                            <td colspan="4" class="text-right">Total</td>
                            <td class="align-middle">$${total_price}</td>
                            <td></td>
                        </tr>
                    `);

                    $('#subtotal').text('$' + total_price);
                    $('#total').text('$' + (total_price + 10));
                }
            });
        }
    </script>
</body>

</html>
