<?php include("partials/menu.php") ?> 
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
            <h1>Update Admin</h1>

            <br><br>

            <?php
                //get id 
                $id = $_GET['id'];
        
                //get the detail
                $sql = "SELECT * FROM tbl_admin WHERE id=$id";

                //execute
                $res = mysqli_query($conn, $sql);

                //check that execote or not
                if($res==true)
                {
                    //data avalibale or not
                    $count = mysqli_num_rows($res);
                    //check that we have datat or not
                    if($count==1)
                    {
                        //get the detali
                        //echo "Admin Avaliable";
                        $row = mysqli_fetch_assoc($res);

                        $full_name = $row['full_name'];
                        $username  = $row['username'];
                    }
                    else
                    {
                        //back to manage admin
                        header('location: manage-admin.php');
                    }
                }


            ?>

            <form action = "" method="POST">

                <table class = "tbl-30">
                    <tr>
                        <td>Full Name: </td>
                        <td>
                            <input type = "text" name = "full_name" value ="<?php echo $full_name;?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Username:</td>
                        <td>
                            <input type = "text" name = "username" value = "<?php echo $username;?>">
                        </td>
                    </tr>   

                    <tr>
                        <td colspan = "2">
                        <input type = "hidden" name = "id" value = "<?php echo $id; ?>">
                            <input type = "submit" name = "submit" value = "Update Admin" class = "btn-Primary">
                        </td>
                    </tr>   
                </table>
            </form>
        </div>
    </div>

    <?php

        //check submit button click
        if(isset($_POST['submit']))
        {
            //echo 'button clicked';
            //get the value for update
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];

            //update
            $sql = "UPDATE tbl_admin SET full_name = '$full_name', username = '$username' WHERE id = $id ";

            //exucute
            $res = mysqli_query($conn, $sql);

            //check that sucess or not
            if($res==true)
            {
                //admin updates
                //redirect to manage admin
                header('location: manage-admin.php');

            }
            else
            {
                //failed
                //redirect to manage admin
                header('location: manage-admin.php');
            }
        }

    ?>
  <?php include("partials/footer.php"); ?>
 
