<?php

    //include constant
    include("../config/constant.php");

    //get the id of admin
    $id = $_GET["id"];
    
    //create query to delete
    $sql = "DELETE FROM tbl_admin WHERE id = $id";

    //execute 
    $res = mysqli_query($conn, $sql);

    //check the exucute or not
    if($res == true)
    {
        //echo 'Admin Deleted';
        //redirext to manage admin
        header('location: manage-admin.php');

    }
    else
    {
        //echo 'Failed to Delete Admin';
        //redirext to manage admin
        header('location: manage-admin.php');
    }

    //redirect to manage admin page 

?>