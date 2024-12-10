<?php
include("config.php");
include("logged_in_check.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_name = $_POST['admin_name'];
    $admin_surname = $_POST['admin_surname'];
    $admin_username = $_POST['admin_username'];
    $admin_pass = password_hash($_POST['admin_pass'], PASSWORD_BCRYPT); // Yeni şifreyi hash'le
    $admin_status = $_POST['admin_status'];

    $sql = "INSERT INTO admin_table (admin_name, admin_surname, admin_username, admin_pass, admin_status) 
            VALUES ('$admin_name', '$admin_surname', '$admin_username', '$admin_pass', '$admin_status')";
    
    // Kullanıcı adı benzersiz mi kontrol et
    $check_query = "SELECT * FROM admin_table WHERE admin_username='$admin_username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $msg = "Already used";
    } else {
        if (mysqli_query($conn, $sql)) {
            $msg = "Admin greatly added";
        } else {
            $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<?php include('header.php'); ?>

<body>
<div id="wrapper">
    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>
    <div id="content">      
        <div id="content-header">
            <h1>Add New Admin</h1>
        </div> 
        <div id="content-container">
            <form method="POST">
                <label>First Name:</label>
                <input type="text" name="admin_name" required>
                <label>Last Name:</label>
                <input type="text" name="admin_surname" required>
                <label>Username:</label>
                <input type="text" name="admin_username" required>
                <label>Password:</label>
                <input type="password" name="admin_pass" required>
                <label>Status:</label>
                <select name="admin_status" required>
                    <option value="Killer">Killer</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
                <button type="submit">Add Admin</button>
            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
