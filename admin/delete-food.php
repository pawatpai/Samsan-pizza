<?php 
    session_start();
    include("../config/constant.php");

    if(isset($_GET["id"]) && isset($_GET['image_name'])) 
    {
        //1 get id and image name
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $image_name = mysqli_real_escape_string($conn, $_GET['image_name']);

        //2 remove the image if available
        //check whether the image is available or not and delete only if available
        if($image_name != '')
        {
            //it has an image and needs to remove from the folder
            //get the image path
            $path = '../images/food/'.$image_name;

            //remove image file from folder
            $remove = unlink($path);

            //check whether the image is removed or not
            if($remove == false)
            {
                //failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to remove image file.</div>";
                //redirect to manage food
                header('location: manage-food.php');
                //stop the process of deleting food
                die();
            }
        }

        //3 delete food from the database
        $sql = "DELETE FROM tbl_food WHERE id='$id'";
        //execute the query
        $res = mysqli_query($conn, $sql);

        //4 redirect to manage food with a session message
        if($res == true)
        {
            //food deleted
            $_SESSION["delete"] = "<div class='success'>Food Deleted Successfully.</div>";
            header('location: manage-food.php');
        }
        else
        {
             //failed deleted
             $_SESSION["delete"] = "<div class='error'>Failed to Deleted Food.</div>";
             header('location: manage-food.php');
        }
    }
    else
    {
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
        header('location: manage-food.php');
    }
?>
