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
        <h1>Manage Category</h1>

        <br><br>
        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>
        <br><br>
        <!--button to add category--> 
        <a href="add-category.php" class="btn-primary">Add Category</a>

        <br/><br/>                

        <table class="tbl-full"> 
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>  
            <?php 
                // Query to get all categories from the database
                $sql = "SELECT * FROM tbl_category";

                // Execute Query
                $res = mysqli_query($conn, $sql);
            
                // Count rows
                $count = mysqli_num_rows($res);

                // Create sn variable
                $sn = 1;

                // Check if we have data in the database or not
                if($count > 0)
                {
                    // Have data in the database
                    // Get the data and display
                    while($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row["id"];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>
                        <tr> 
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>
                                <?php 
                                    // Check if the image name is available or not
                                    if($image_name != "")
                                    {
                                        // Display the image with a width of 100 pixels
                                        ?>
                                        <img src="../images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="category-image" style="width: 100px;">
                                        <?php
                                    }
                                    else
                                    {
                                        // Display a placeholder or a message if the image is not available
                                        echo "<div class='error'>Image not Added.</div>";
                                    }
                                ?>
                            </td>
                            
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="update-category.php?id=<?php echo $id; ?>" class="btn-primary">Update Category</a> 
                                <a href="delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-primary">Delete Category</a>
                            </td>
                        </tr> 
                        <?php
                    }
                }
                else
                {
                    // No data in the database
                    // Display a message inside the table
                    ?>
                    <tr>
                        <td colspan="6"><div class="error">No Category Added.</div></td>
                    </tr>
                    <?php
                }
            ?>
        </table>
    </div>
</div>
<?php include('partials/footer.php'); ?>
