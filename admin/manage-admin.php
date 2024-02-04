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
        <!-- main content start -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>



                <br/><br/>

                    <!--button to add admin--> 
                    <a href = "add-admin.php" class = "btn-primary">Add Admin</a>
                
                <br/><br/>                

                    <table class ="tbl-full"> 
                        <tr>
                            <th>S.N.</th>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>  

                        <?php
                            //get all admin
                            $sql = 'SELECT * FROM tbl_admin';
                            //execute
                            $res =mysqli_query($conn, $sql);
                            //check tht it execute or not
                            if($res == true)
                            {
                                //count rows
                                $count = mysqli_num_rows($res);//get the rows

                                $num = 1;
                                
                                //check row
                                if($count > 0)
                                {
                                    // we have data
                                    while($row = mysqli_fetch_array($res))
                                    {
                                        //get all the data
                                        $id = $row['id'];
                                        $full_name = $row['full_name'];
                                        $username = $row['username'];

                                        //show the value
                                        ?>

                                        <tr> 
                                            <td><?php echo $num++; ?></td>
                                            <td><?php echo $full_name; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td>
                                                <a href = "update-password.php?id=<?php echo $id; ?>" class = btn-primary>Change Password</a> 
                                                <a href = "update-admin.php?id=<?php echo $id; ?>" class = btn-primary>Update Admin</a> 
                                                <a href = "delete-admin.php?id=<?php echo $id; ?>" class = btn-primary>Delete admin</a>
                                            </td>
                                        </tr> 

                                        <?php
                                    }
                                }
                                else
                                {
                                    //we dont have data
                                }
                            }

                        ?>
                       
                    </table>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- main content end -->

<?php include('partials/footer.php'); ?>