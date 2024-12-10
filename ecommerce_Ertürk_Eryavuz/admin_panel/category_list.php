<?php
include("config.php");
include("logged_in_check.php");

// Kategorileri çekmek için veritabanı sorgusu
$result = mysqli_query($conn, "SELECT * FROM categories");
?>

<?php include('header.php'); ?>

<body>
<div id="wrapper">
    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>
    <div id="content">      
        <div id="content-header">
            <h1>Category List</h1>
        </div> 
        <div id="content-container">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <a href="edit_category.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete_category.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
