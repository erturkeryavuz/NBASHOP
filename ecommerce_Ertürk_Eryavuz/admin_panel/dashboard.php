<?php
include_once("config.php");
include("logged_in_check.php");

// Verileri al
function getTotalSales($conn) {
    $query = "SELECT SUM(total_price) as total_sales FROM orders";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_sales'];
}

function getTotalCustomers($conn) {
    $query = "SELECT COUNT(DISTINCT email) as total_customers FROM orders";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_customers'];
}

function getTotalOrders($conn) {
    $query = "SELECT COUNT(*) as total_orders FROM orders";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_orders'];
}

function getStockProducts($conn) {
    $query = "SELECT SUM(stock_quantity) as total_stock FROM products";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total_stock'];
    } else {
        return 0;
    }
}

function getMonthlySales($conn) {
    $query = "SELECT MONTH(created_at) as month, SUM(total_price) as total_sales FROM orders GROUP BY MONTH(created_at)";
    $result = mysqli_query($conn, $query);
    $sales_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $sales_data[] = $row;
    }
    return $sales_data;
}

function getCategoryStock($conn) {
    $query = "SELECT c.name as category, SUM(p.stock_quantity) as stock_quantity 
              FROM products p 
              JOIN categories c ON p.category_id = c.id 
              GROUP BY c.name";
    $result = mysqli_query($conn, $query);
    $category_stock_data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $category_stock_data[] = $row;
    }
    return $category_stock_data;
}

$monthly_sales = getMonthlySales($conn);
$monthly_sales_json = json_encode($monthly_sales);

$category_stock = getCategoryStock($conn);
$category_stock_json = json_encode($category_stock);
?>

<?php include('header.php'); ?>

<body>

<div id="wrapper">

    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>

    <div id="content">      
        <div id="content-header">
            <h1>Dashboard</h1>
        </div> <!-- #content-header --> 

        <div id="content-container">
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Toplam Satış</h4>
                            <p>$<?php echo number_format(getTotalSales($conn), 2); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Toplam Müşteri</h4>
                            <p><?php echo getTotalCustomers($conn); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Toplam Sipariş</h4>
                            <p><?php echo getTotalOrders($conn); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-xs-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h4>Stokta Ürün</h4>
                            <p><?php echo getStockProducts($conn); ?></p>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->

            <!-- Grafikler -->
            <div class="row">
                <div class="col-lg-6">
                    <canvas id="salesChart"></canvas>
                </div>
                <div class="col-lg-6">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>
        </div> <!-- /#content-container -->
    </div> <!-- #content -->    
    
</div> <!-- #wrapper -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // PHP'den gelen verileri JavaScript'e aktar
    var monthlySalesData = <?php echo $monthly_sales_json; ?>;
    var categoryStockData = <?php echo $category_stock_json; ?>;

    var salesLabels = [];
    var salesData = [];

    monthlySalesData.forEach(function(item) {
        salesLabels.push('Month ' + item.month);
        salesData.push(item.total_sales);
    });

    // Satışlar Grafiği
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Aylık Satışlar',
                data: salesData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var stockLabels = [];
    var stockData = [];

    categoryStockData.forEach(function(item) {
        stockLabels.push(item.category);
        stockData.push(item.stock_quantity);
    });

    // Kategoriye göre stok grafiği
    var stockCtx = document.getElementById('stockChart').getContext('2d');
    var stockChart = new Chart(stockCtx, {
        type: 'pie',
        data: {
            labels: stockLabels,
            datasets: [{
                data: stockData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<?php include('footer.php'); ?>

</body>
</html>
