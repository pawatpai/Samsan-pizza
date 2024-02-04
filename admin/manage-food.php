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
        <h1>Manage Food</h1>

        <br/><br/>

<!--button to add food--> 
<a href = "add-food.php" class = "btn-primary">Add Food</a>

<br/><br/><br/>     

<?php
    if(isset($_SESSION['add']))
    {
        echo $_SESSION['add'];
        unset ($_SESSION['add']);
    }

    if(isset($_SESSION['delete']))
    {
        echo $_SESSION['delete'];
        unset ($_SESSION['delete']);
    }

    if(isset($_SESSION['upload']))
    {
        echo $_SESSION['upload'];
        unset ($_SESSION['upload']);
    }

    if(isset($_SESSION['unauthorize']))
    {
        echo $_SESSION['unauthorize'];
        unset ($_SESSION['unauthorize']);
    }

    if(isset($_SESSION['update']))
    {
        echo $_SESSION['update'];
        unset ($_SESSION['update']);
    }
?>

<table class ="tbl-full"> 
    <tr>
        <th>S.N.</th>
        <th>Title</th>
        <th>Price</th>
        <th>Image</th>
        <th>Featured</th>
        <th>Active</th>
        <th>Actions</th>
    </tr>  

    <?php
        //Create a SQL Query to get all the food
        $sql = "SELECT * FROM tbl_food";

        //Execute the query
        $res = mysqli_query($conn,$sql);

        //Count rows to check whether we have food or not
        $count = mysqli_num_rows($res);

        //Create serial number variable and set default value as 1
        $sn=1;

        if($count>0)
        {
            //We have food in database
            //Get the foods from database and display
            while($row=mysqli_fetch_assoc($res))
            {
                //Get the values from individual columns
                $id = $row['id'];
                $title = $row['title'];
                $price =$row['price'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
                ?>

                    <tr> 
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
                        <td>$<?php echo $price; ?></td>
                        <td>
                            <?php 
                                // Check if the image name is available or not
                                if($image_name != "")
                                {
                                    // Display the image with a width of 100 pixels
                                    ?>
                                    <img src="../images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="food-image" style="width: 100px;">
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
                            <a href = "update-food.php?id=<?php echo $id; ?>" class = btn-primary>Update Food</a> 
                            <a href = "delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class = btn-primary>Delete Food</a>
                        </td>
                    </tr> 

                <?php
            }
        }
        else
        {
            //Food not added in database
            echo "<tr><td colspan='7' class='error> Food not added Yet.</td> </tr>";
        }
    ?>


   
    </table>
</div>
</div>
<?php include('partials/footer.php'); ?>