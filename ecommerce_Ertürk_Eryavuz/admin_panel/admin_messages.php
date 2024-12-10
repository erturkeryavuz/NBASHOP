<?php
include("config.php");
include("logged_in_check.php");

// Pagination ayarları
$limit = 10; // Sayfa başına gösterilecek mesaj sayısı
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_query = "SELECT COUNT(*) FROM messages";
$total_result = mysqli_query($conn, $total_query);
$total_messages = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_messages / $limit);

$query = "SELECT * FROM messages ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $query);
?>

<?php include('header.php'); ?>

<body>
<div id="wrapper">
    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>
    <div id="content">      
        <div id="content-header">
            <h1>Messages</h1>
        </div> 
        <div id="content-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Received At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>".$row['email']."</td>";
                        echo "<td>".$row['subject']."</td>";
                        echo "<td>".$row['message']."</td>";
                        echo "<td>".$row['created_at']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="admin_messages.php?page=<?php echo $page - 1; ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if($i == $page) echo 'active'; ?>"><a class="page-link" href="admin_messages.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endfor; ?>
                    <?php if($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="admin_messages.php?page=<?php echo $page + 1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
