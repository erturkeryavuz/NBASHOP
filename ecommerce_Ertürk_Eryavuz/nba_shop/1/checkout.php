<?php
session_start();
include('config.php');

$total = 0; // Toplam fiyatı başlat
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    // Toplam fiyat hesapla ve ürün sayısını belirle
    $total_quantity = 0;
    if(isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $query = "SELECT * FROM products WHERE id = $product_id";
            $result = mysqli_query($conn, $query);
            $product = mysqli_fetch_assoc($result);
            $subtotal = $product['price'] * $quantity;
            $total += $subtotal;
            $total_quantity += $quantity;
        }
    }

    $total_price = $total + 10; // Sabit kargo ücreti olarak 10$ ekleniyor

    // Estimated delivery hesaplama (ürün sayısı başına 4 gün eklenir)
    $estimated_delivery = date('Y-m-d', strtotime('+' . ($total_quantity * 4) . ' days'));

    // Sipariş bilgilerini orders tablosuna kaydetme
    $stmt = $conn->prepare("INSERT INTO orders (first_name, last_name, email, mobile, address1, address2, country, city, state, zip, order_number, total_price, estimated_delivery, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $order_number = uniqid();
    $stmt->bind_param("sssssssssssds", $first_name, $last_name, $email, $mobile, $address1, $address2, $country, $city, $state, $zip, $order_number, $total_price, $estimated_delivery);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Sepetteki ürünleri order_items tablosuna kaydetme
    if(isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, (SELECT price FROM products WHERE id = ?))");
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $product_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Sipariş tamamlandı, sepeti temizle
    unset($_SESSION['cart']);

    // Sipariş başarı mesajı ve yönlendirme
    echo "<script>alert('Siparişiniz başarıyla tamamlandı!'); window.location='invoice.php?order_id={$order_id}';</script>";
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

    <script>
        function showPaymentDetails(paymentMethod) {
            document.getElementById('credit_card_details').style.display = 'none';
            document.getElementById('paypal_details').style.display = 'none';
            document.getElementById('bank_transfer_details').style.display = 'none';
            if (paymentMethod) {
                document.getElementById(paymentMethod + '_details').style.display = 'block';
            }
        }
    </script>
</head>

<body>
    <!-- Topbar Start -->
   
                <!-- Support links removed -->
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <!-- Social icons removed -->
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="index.php" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">NBA</span>SHOP</h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <!-- Search bar removed -->
            </div>
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
                            <a href="detail.php" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">Pages</a>
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
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="index.php">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Checkout</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>
                    <form action="checkout.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" name="first_name" placeholder="John" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="last_name" placeholder="Doe" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="email" name="email" placeholder="example@email.com" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" name="mobile" placeholder="+123 456 789" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" type="text" name="address1" placeholder="123 Street" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" type="text" name="address2" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" name="country" required>
                                    <option selected>United States</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" placeholder="New York" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" name="state" placeholder="New York" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" name="zip" placeholder="123" required>
                            </div>
                        </div>
                        <div class="card border-secondary mb-5">
                            <div class="card-header bg-secondary border-0">
                                <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                            </div>
                            <div class="card-body">
                                <h5 class="font-weight-medium mb-3">Products</h5>
                                <?php
                                $total = 0;
                                if(isset($_SESSION['cart'])) {
                                    foreach($_SESSION['cart'] as $product_id => $quantity) {
                                        $query = "SELECT * FROM products WHERE id = $product_id";
                                        $result = mysqli_query($conn, $query);
                                        $product = mysqli_fetch_assoc($result);
                                        $subtotal = $product['price'] * $quantity;
                                        $total += $subtotal;
                                        echo '
                                        <div class="d-flex justify-content-between">
                                            <p>' . $product['name'] . ' x ' . $quantity . '</p>
                                            <p>$' . $subtotal . '</p>
                                        </div>';
                                    }
                                }
                                ?>
                                <hr class="mt-0">
                                <div class="d-flex justify-content-between mb-3 pt-1">
                                    <h6 class="font-weight-medium">Subtotal</h6>
                                    <h6 class="font-weight-medium">$<?php echo $total; ?></h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h6 class="font-weight-medium">Shipping</h6>
                                    <h6 class="font-weight-medium">$10</h6>
                                </div>
                            </div>
                            <div class="card-footer border-secondary bg-transparent">
                                <div class="d-flex justify-content-between mt-2">
                                    <h5 class="font-weight-bold">Total</h5>
                                    <h5 class="font-weight-bold">$<?php echo $total + 10; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card border-secondary mb-5">
    <div class="card-header bg-secondary border-0">
        <h4 class="font-weight-semi-bold m-0">Payment</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="payment_method" value="credit_card" id="credit_card" onclick="showPaymentDetails('credit_card')">
                <label class="custom-control-label" for="credit_card">Credit Card</label>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="payment_method" value="paypal" id="paypal" onclick="showPaymentDetails('paypal')">
                <label class="custom-control-label" for="paypal">PayPal</label>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-control custom-radio">
                <input type="radio" class="custom-control-input" name="payment_method" value="bank_transfer" id="bank_transfer" onclick="showPaymentDetails('bank_transfer')">
                <label class="custom-control-label" for="bank_transfer">Bank Transfer</label>
            </div>
        </div>
    </div>
    <div class="card-footer border-secondary bg-transparent">
        <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
    </div>
</div>
<!-- Payment Method Details -->
<div id="credit_card_details" style="display:none;">
    <h3>Credit Card Details</h3>
    <div class="form-group">
        <label for="cc_number">Card Number</label>
        <input type="text" class="form-control" id="cc_number" name="cc_number" placeholder="1234 5678 9012 3456">
    </div>
    <div class="form-group">
        <label for="cc_expiry">Expiry Date</label>
        <input type="text" class="form-control" id="cc_expiry" name="cc_expiry" placeholder="MM/YY">
    </div>
    <div class="form-group">
        <label for="cc_cvc">CVC</label>
        <input type="text" class="form-control" id="cc_cvc" name="cc_cvc" placeholder="123">
    </div>
</div>

<div id="paypal_details" style="display:none;">
    <h3>PayPal Details</h3>
    <div class="form-group">
        <label for="paypal_card_number">Card Number</label>
        <input type="text" class="form-control" id="paypal_card_number" name="paypal_card_number" placeholder="1234 5678 9012 3456">
    </div>
    <div class="form-group">
        <label for="paypal_expiry">Expiry Date</label>
        <input type="text" class="form-control" id="paypal_expiry" name="paypal_expiry" placeholder="MM/YY">
    </div>
    <div class="form-group">
        <label for="paypal_cvc">CVC</label>
        <input type="text" class="form-control" id="paypal_cvc" name="paypal_cvc" placeholder="123">
    </div>
</div>

<div id="bank_transfer_details" style="display:none;">
    <h3>Bank Transfer Details</h3>
    <div class="form-group">
        <label for="bank_name">Bank Name</label>
        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Your Bank Name">
    </div>
    <div class="form-group">
        <label for="account_number">Account Number</label>
        <input type="text" class="form-control" id="account_number" name="account_number" placeholder="123456789">
    </div>
    <div class="form-group">
        <label for="iban">IBAN</label>
        <input type="text" class="form-control" id="iban" name="iban" placeholder="TR12345678901234567890">
    </div>
</div>

<script>
    function showPaymentDetails(paymentMethod) {
        document.getElementById('credit_card_details').style.display = 'none';
        document.getElementById('paypal_details').style.display = 'none';
        document.getElementById('bank_transfer_details').style.display = 'none';
        if (paymentMethod) {
            document.getElementById(paymentMethod + '_details').style.display = 'block';
        }
    }
</script>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="index.php" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">NBA</span>SHOP</h1>
                </a>
                <p>NBA Shop, providing official NBA products online. We offer high-quality products and fast shipping to give our customers the best shopping experience.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Ataşehir, Istanbul, Turkey</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@nbashop.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+90 555 555 5555</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark mb-2" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.php"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.php"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="detail.php"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                            <a class="text-dark mb-2" href="cart.php"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.php"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark mb-2" href="contact.php"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                </div>
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

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>
</html>
