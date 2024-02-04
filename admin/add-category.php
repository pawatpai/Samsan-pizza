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
        <h1>Add Category</h1>
        <br><br>
        <?php 
            // Display success or error messages
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Category title"></td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No" checked> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No" checked> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category Form Ends -->

        <?php 
            // Check if the form is submitted
            if(isset($_POST['submit']))
            {
                // 1.Get values from the form
                $title = $_POST['title'];
                $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
                $active = isset($_POST['active']) ? $_POST['active'] : "No";

                // Check if an image is selected
                if(isset($_FILES['image']['name']))
                {   //To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];


                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/".$image_name;

                    // Attempt to upload the image
                    if(move_uploaded_file($source_path, $destination_path))
                    {
                        // Image uploaded successfully
                    }
                    else
                    {
                        // Image upload failed
                        $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                        header('location: add-category.php');
                        die();
                    }
                }
                else
                {
                    $image_name = "";
                }

                // 2.Insert data into the database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'";

                // 3.execute the query and save in database
                $res = mysqli_query($conn, $sql);
                // 4.check whether the query executed or not and data added or not
                if($res)
                {
                    // Category added successfully
                    $_SESSION['add'] = "<div class='success'>Category added successfully.</div>";
                    header('location: manage-category.php');
                }
                else
                {
                    // Failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to add category.</div>";
                    header('location: add-category.php');
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
