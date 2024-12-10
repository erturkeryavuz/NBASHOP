<?php
include('config.php');

// Fetch categories from the database
$query = "SELECT * FROM categories";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

// Separate jerseys categories and other categories
$jerseys = [];
$others = [];

while ($row = mysqli_fetch_assoc($result)) {
    if (strpos($row['name'], 'Jersey') !== false) {
        $jerseys[] = $row;
    } else {
        $others[] = $row;
    }
}
?>

<div class="bg-primary text-white" style="height: 65px; margin-top: -1px; padding: 0 30px;">
    <h6 class="m-0">Categories</h6>
</div>
<nav class="navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0">
    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
        <!-- Dinamik kategoriler burada başlıyor -->
        <div class="nav-item dropdown">
            <a href="#" class="nav-link" data-toggle="dropdown">Jerseys <i class="fa fa-angle-down float-right mt-1"></i></a>
            <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">
                <?php foreach ($jerseys as $jersey): ?>
                    <a href="category.php?id=<?php echo $jersey['id']; ?>" class="dropdown-item"><?php echo $jersey['name']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php foreach ($others as $category): ?>
            <a href="category.php?id=<?php echo $category['id']; ?>" class="nav-item nav-link"><?php echo $category['name']; ?></a>
        <?php endforeach; ?>
    </div>
</nav>
