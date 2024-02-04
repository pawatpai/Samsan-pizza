<?php include('partials/menu.php'); ?>
<?php
// Protect from entry without login
session_start();
if (!isset($_SESSION['admin_id'])) {
    // The username session key does not exist or it's empty.
    header('location: login.php');
    exit();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
             {
                $id = $_GET['id']; 
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password">
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    // Check if the submit button is clicked
    if(isset($_POST['submit'])) {
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // Check if the current password matches the user's password
        $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";
        $res = mysqli_query($conn, $sql);

        if($res) {
            $count = mysqli_num_rows($res);

            if($count == 1) {
                if($new_password == $confirm_password) {
                    // Update the password
                    $sql2 = "UPDATE tbl_admin SET password = '$new_password' WHERE id = $id";
                    $res2 = mysqli_query($conn, $sql2);

                    if($res2) {
                        echo 'Password updated successfully';
                        // You can redirect or display a success message here
                    } else {
                        echo 'Password update failed' ;
                        // Display an error message or redirect as needed
                    }
                } else {
                      echo 'Passwords do not match';
                    // Display an error message or redirect as needed
                }
            } else {
                 echo 'Current password does not match the users password';
                // Display an error message or redirect as needed
            }
        }
    }
?>

<?php include('partials/footer.php'); ?>
