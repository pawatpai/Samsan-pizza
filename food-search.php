<?php include('partials-front/menu.php'); ?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 

                //Get the Search Keyword
                $search = $_POST['search'];

            ?>
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 

                //SQL Query to get foods based on search keyword
                
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' or Description LIKE '%$search%'";

                //Excute the query
                $res = mysqli_query($conn,$sql);

                //Count rows
                $count = mysqli_num_rows($res);

                //Check whether food available or not
                if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                if ($image_name == "") {
                                    echo "Image not available";
                                } else {
                                    ?>
                                    <img src="images/food/<?php echo $image_name; ?>" alt="Food Image" class="img-responsive img-curve">
                                    <?php
                                }
                                ?>
                            </div>
        
                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>
        
                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
        
                    <?php
                    }
                }
                else
                {
                    //Food not Available
                    echo "<div class ='error'>Food not Found.</div>";
                }
            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

</body>
</html>