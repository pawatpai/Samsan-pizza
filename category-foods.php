<?php include('partials-front/menu.php'); ?>

<?php
    //Check whether id is passed or not
    if(isset($_GET['category_id']))
    {
        //Category id is set and get the id
        $category_id = $_GET['category_id'];

        //Get the category title based on category id
        $sql = "SELECT title FROM tbl_category WHERE id = $category_id";

        //Excute
        $res = mysqli_query($conn,$sql);

        //Get the value
        $row = mysqli_fetch_assoc($res);

        //Get the title
        $category_title = $row['title'];
    }
    else
    {
        //Category not passed and redirect to home page
        header('location: index.php'); 
    }
?>

    
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h4>Foods on <a href="#" class="text-white">"<?php echo $category_title ?>"</a></h4>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //Create SQL Query to get foods based on selected category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

                //Execute
                $res2 = mysqli_query($conn,$sql2);

                //Count the rows
                $count2 = mysqli_num_rows($res2);

                //Check whether food is available or not
                if($count2>0)
                {
                    //Food is Available
                    while($row2=mysqli_fetch_assoc($res2))
                    {   
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php
                                    if ($image_name == "") {
                                        echo "<div class ='error'>Image not available.</div>";
                                    } else {
                                        ?>
                                        <img src="images/food/<?php echo $image_name; ?>" alt="Food Image" class="img-responsive img-curve">
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h3><?php echo $title; ?></h3>
                                    <p class="food-price">$ <?php echo $price; ?></p>
                                    <p class="food-detail"><?php echo $description; ?></p>
                                    <br>

                                    <a href="order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                        <?php
                    }
                }
                else
                {
                    //Fodd is not Available
                    echo "<div class='error'>Food not Available.</div>";
                }
            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

</body>
</html>