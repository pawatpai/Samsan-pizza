<?php include('partials/menu.php'); ?>
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    // The username session key does not exist or it's empty.
    header('location: login.php');
    session_destroy();
}
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        <?php 
            // Display messages
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
    
            <table class ="tbl-30"> 

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type ="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type ="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name ="category">

                            <?php
                                //Create php code to display categories from Database
                                //1. Create SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='YES'";
                                
                                //Excute query
                                $res = mysqli_query($conn,$sql);

                                //Count Rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);
                                
                                //If count is greater than zero,we have categories else we do not have categories
                                if ($count > 0) 
                                {

                                    //We have categories
                                    while ($row = mysqli_fetch_assoc($res)) 
                                    {
                                        //get the details of categories
                                        $id = $row["id"];
                                        $title = $row["title"];
                                        ?>

                                        <option value="1"><?php echo $title; ?></option>
                                        
                                        <?php
                                    }


                                }
                                else
                                {
                                    //we do not have categories
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php

                                }

                                //2. Display on DropDown
                            ?>


                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Feature: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                <td colspan="2">
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php
            //check whether the button is clicked or not
            if(isset($_POST['submit']))
            {
                //Add the food in Database
                
                //1.Get the data from From
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //Check whether radio button for featured and active are checked or not
                $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
                $active = isset($_POST['active']) ? $_POST['active'] : "No";
                //2.Upload the image if selected
                
                //Check whether the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    // Get the detail of the selected image
                    $image_name = $_FILES['image']['name'];
                
                    // Check whether the image is selected or not and upload the image only if selected
                    if($image_name != "")
                    {
                        // Image is selected
                
                        // 1. Rename the image
                        // Get the extension of the selected image (jpg, png, etc.) "pizza.jpg"
                        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                
                        // Create a new name for the image
                        $image_name = "Food-Name-" . rand(0000,9999) . "." . $ext; // New image name may be "Food-Name-777.jpg"
                
                        // 2. Upload the image
                
                        // Source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];
                
                        // Destination path for the image to be uploaded
                        $dst = "../images/food/" . $image_name;
                
                        // Upload the food image
                        $upload = move_uploaded_file($src, $dst);
                
                        // Check whether the image uploaded successfully
                        if($upload)
                        {
                            // Image uploaded successfully
                        }
                        else
                        {
                            // Failed to upload the image
                            // Set a session message with an error
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        }
                    }
                    else
                    {
                        $image_name = ""; // Setting the default value as blank
                    }
                }
                
                //3.Insert into database

                //Create a SQL Query to save or add food
                $sql2 = "INSERT INTO tbl_food SET  
                title = '$title',description ='$description',
                price = $price,
                image_name = '$image_name',
                category_id = $category,
                featured = '$featured',
                active = '$active'
                ";

                //Excute the Query
                $res2 = mysqli_query($conn,$sql2);

                //Check whether data inserted or not
                //4.Redirect with message to message food page
                if($res2==true)
                {
                    //Data inserted sucessfully
                    $_SESSION['add'] ="<div class ='success'>Food Added Sucessfully.</div>";
                    header('location: manage-food.php');
                }
                else
                {   
                    //Failed to inserted data
                    $_SESSION['add'] ="<div class ='error'>Failed to Add Food.</div>";
                    header('location: manage-food.php');
                }

            }
        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>


