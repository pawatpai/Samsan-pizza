<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('partials-front/menu.php');

// Check whether food id is set or not
if (isset($_GET['food_id'])) {
    // Get the Food id and details of the selected food
    $food_id = $_GET['food_id'];

    // Get the details of the selected food
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Count the rows
    $count = mysqli_num_rows($res);

    // Check whether the data is available or not
    if ($count == 1) {
        // Data Available
        $row = mysqli_fetch_assoc($res);

        $image_name = isset($row['image_name']) ? $row['image_name'] : '';
        $title = isset($row['title']) ? $row['title'] : '';
        $price = isset($row['price']) ? $row['price'] : '';
    } else {
        // Food not Available and redirect to homepage
        header('location: index.php');
    }
} else {
    // Redirect to homepage
    header('location: index.php');
}

// Initialize variables
$success_message = $error_message = '';

// Check whether submit button is clicked or not
if (isset($_POST['submit'])) {
    // Get all the details from the form
    $food = $_POST['food'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    $total = $price * $qty; // total = price * qty

    $order_date = date("Y-m-d H:i:s"); // Order date

    $status = "Ordered"; // Ordered, On delivery, Delivered, Cancelled
    
    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];

    // Save the Order in Database

    // Create sql
    $sql2 = "INSERT INTO tbl_order SET 
        food = '$food',
        price = $price,
        qty = '$qty',
        total = '$total',
        order_date = '$order_date',
        status = '$status',
        customer_name = '$customer_name',
        customer_contact = '$customer_contact',
        customer_email = '$customer_email',
        customer_address = '$customer_address'
    ";
    
    // Execute the Query
    $res2 = mysqli_query($conn, $sql2);

    if ($res2) {
        $success_message = "Food Ordered Successfully.";
    } else {
        $error_message = "Failed to Order Food: " . mysqli_error($conn);
    }
}
?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        
        <?php
        if (!empty($success_message)) {
            echo "<div class='success text-center'>$success_message</div>";
        } elseif (!empty($error_message)) {
            echo "<div class='error text-center'>$error_message</div>";
        }
        ?>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

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
                    <h4><?php echo $title; ?></h4>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                
                    <p class="food-price2">$ <?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>

            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

</body>
</html>
