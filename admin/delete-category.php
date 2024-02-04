
<?php
    include("../config/constant.php");
   
    //echo "delete page";
    //check imagename value
    if(isset($_GET["id"]))
    {
        //get value and delete
        $id = $_GET["id"];
        $image_name = $_GET["image_name"];

        //remove file
        if($image_name != "")
        {
            $path = "../image/category".$image_name;
            $remove = unlink($path);

            // if failed
            if( $remove == false )
            {
                header('location: manage-category.php');
            }
        }

        //delete from datatbase
        $sql = "DELETE FROM tbl_category WHERE id = $id";
        
        //execute
        $res = mysqli_query($conn, $sql); 

        //check the data is delete or not
        if($res == true)
    {
        header('location: manage-category.php');
    }
    else
    {
        header('location: manage-category.php');
    }

    }
    else
    {
        header('location: manage-category.php');
    }
?>