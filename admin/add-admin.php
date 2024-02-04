<?php include("partials/menu.php") ?> 
<?php include('constant.php') ?>

<?php
// Protect from entry without login
session_start();
if (!isset($_SESSION['admin_id'])) {
    // The username session key does not exist or it's empty.
    header('location: login.php');
    exit();
}
?>

<div class = "main-content">
    <div class = "wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <form action="" method="POST">

            <table class = "tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type = 'text'name="full_name">
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td> 
                        <input type = 'text'name="username">
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                    <input type = 'text'name="password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class = "btn-primary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
     
</div>

<?php include("partials/footer.php") ?> 

<?php

    //process the value Form and save it in datatbase
    //check that button is clicked or not
    if(isset($_POST['submit']))
    {
        //button clicked
        //echo'Button Clicked';
        
        //get the data from form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //encrypt password with md5

        //save to database

        $sql = "INSERT INTO tbl_admin SET 
            full_name = '$full_name',
            username =  '$username',
            password = '$password'
        ";

        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
        if ($res) {
           // echo "Admin added successfully.";
        } else {
            //echo "Failed to add admin: " . mysqli_error($conn);
        }

        //check that data is inserted or not
        if ($res == TRUE) {
            // Data inserted
            // Redirect to another page
            header('location: manage-admin.php');
        }
        else
        {
            //failed to insert data
            //echo "failed to insert data";
            // Redirect to add admin
            header('location: add-admin.php');
        }
    }

?>