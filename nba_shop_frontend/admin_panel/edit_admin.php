<?php
include("config.php");
include("logged_in_check.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];
    $admin_surname = $_POST['admin_surname'];
    $admin_username = $_POST['admin_username'];
    $admin_pass = $_POST['admin_pass'];
    $admin_status = $_POST['admin_status'];

    // Şifre değişikliği kontrolü
    $result = mysqli_query($conn, "SELECT admin_pass FROM admin_table WHERE admin_id='$admin_id'");
    $admin = mysqli_fetch_assoc($result);
    if ($admin_pass !== $admin['admin_pass']) {
        // Şifre değişmişse hash'le
        $admin_pass = password_hash($admin_pass, PASSWORD_BCRYPT);
    }

    $sql = "UPDATE admin_table SET admin_name='$admin_name', admin_surname='$admin_surname', admin_username='$admin_username', admin_pass='$admin_pass', admin_status='$admin_status' WHERE admin_id='$admin_id'";

    // Kullanıcı adı benzersiz mi kontrol et (kendisi hariç)
    $check_query = "SELECT * FROM admin_table WHERE admin_username='$admin_username' AND admin_id != '$admin_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $msg = "Bu kullanıcı adı zaten kullanılıyor.";
    } else {
        if (mysqli_query($conn, $sql)) {
            $msg = "Admin başarıyla güncellendi";
        } else {
            $msg = "Hata: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

$admin_id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM admin_table WHERE admin_id='$admin_id'");
$admin = mysqli_fetch_assoc($result);
?>

<?php include('header.php'); ?>

<body>
<div id="wrapper">
    <?php include('top_bar.php'); ?>
    <?php include('left_sidebar.php'); ?>
    <div id="content">      
        <div id="content-header">
            <h1>Edit Admin</h1>
        </div> 
        <div id="content-container">
            <form method="POST">
                <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">
                <label>First Name:</label>
                <input type="text" name="admin_name" value="<?php echo $admin['admin_name']; ?>" required>
                <label>Last Name:</label>
                <input type="text" name="admin_surname" value="<?php echo $admin['admin_surname']; ?>" required>
                <label>Username:</label>
                <input type="text" name="admin_username" value="<?php echo $admin['admin_username']; ?>" required>
                <label>Password:</label>
                <input type="password" name="admin_pass" value="<?php echo $admin['admin_pass']; ?>" required>
                <label>Status:</label>
                <select name="admin_status" required>
                    <option value="Killer" <?php if($admin['admin_status'] == 'Killer') echo 'selected'; ?>>Killer</option>
                    <option value="Medium" <?php if($admin['admin_status'] == 'Medium') echo 'selected'; ?>>Medium</option>
                    <option value="Low" <?php if($admin['admin_status'] == 'Low') echo 'selected'; ?>>Low</option>
                </select>
                <button type="submit">Update Admin</button>
            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>
</body>
</html>
