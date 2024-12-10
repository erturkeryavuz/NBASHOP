<?php
include("config.php");
include("logged_in_check.php");

$result = mysqli_query($conn, "SELECT * FROM admin_table");
?>

<?php include('header.php'); ?>

<body>
<div id="wrapper">
    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>
    <div id="content">      
        <div id="content-header">
            <h1>Admin List</h1>
        </div> 
        <div id="content-container">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['admin_id']; ?></td>
                    <td><?php echo $row['admin_name']; ?></td>
                    <td><?php echo $row['admin_surname']; ?></td>
                    <td><?php echo $row['admin_username']; ?></td>
                    <td><?php echo $row['admin_status']; ?></td>
                    <td>
                        <a href="edit_admin.php?id=<?php echo $row['admin_id']; ?>">Edit</a>
                        <a href="delete_admin.php?id=<?php echo $row['admin_id']; ?>">Delete</a>
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
