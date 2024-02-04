
<?php include ("../config/constant.php");?>

<html>
<head>
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
    <div class="login">
        <h1 class="text-center">Login</h1>
        <br><br>
        <!--Login start-->
        <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"><br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"><br><br>
            
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br><br>
        </form>
        <!--Login End-->
        <p class="text-center">2023 SAMSANPIZZA</p>
    </div>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    // Process Login
    // 1. Data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);

    // SQL
    $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";

    // Execute
    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    // Count rows
    $count = mysqli_num_rows($res);

    echo $count;

    if ($count == 1) {
        // Fetch the admin ID from the result   [[0],[1]]
        $row = mysqli_fetch_assoc($res);
        $admin_id = $row['id']; // Assuming the column name for admin ID is 'id'

        // Start the session
        session_start();

        // Store the admin ID in the session
        $_SESSION['admin_id'] = $admin_id;

        // Redirect to home page/dashboard
        header('Location: index.php');
    } else {
        // Redirect to login page
        echo "<div class ='error text-center'>Username or Password is not correct.</div>";
    }
}
?>