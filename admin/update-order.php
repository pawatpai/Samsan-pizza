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

<div class = "main-content">
    <div class = "wrapper">
        <h1>Update Order</h1>
        <br><br>
        <?php
                if(isset($_GET['id'])) {
                $id = $_GET['id'];

                // Fetch category data
                $sql = "SELECT * FROM tbl_order WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);

                    $food = $row['food'];
                    $price =$row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                } else {
                    header('location: manage-order.php');
                    exit();
                }
                } 
                else {
                header('location: manage-order.php');
                exit();
                }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><b> $ <?php echo $price; ?></b></td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td><input type="number" name="qty" value="<?php echo $qty; ?>"></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><select name="status">
                        <option <?php if($status=="Ordered"){echo "selected";}?> value="Ordered">Ordered</option>
                        <option <?php if($status=="On Delivery"){echo "selected";}?> value="On Delivery">On Delivery</option>
                        <option <?php if($status=="Delivered"){echo "selected";}?> value="Delivered">Delivered</option>
                        <option <?php if($status=="Cancelled"){echo "selected";}?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td><input type="text" name="customer_name" value="<?php echo $customer_name; ?>"></td>
                </tr>
                <tr>
                    <td>Customer Contact:</td>
                    <td><input type="text" name="customer_contact" value="<?php echo (string)$customer_contact; ?>"></td>
                </tr>
                <tr>
                    <td>Customer Email</td>
                    <td><input type="text" name="customer_email" value="<?php echo $customer_email; ?>"></td>
                </tr>
                <tr>
                    <td>Customer Address</td>
                    <td>
                        <textarea name="customer_address"  cols="30" rows="5"> <?php echo $customer_address; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
        <?php 
        if (isset($_POST['submit'])) {
            // Get all the details from the form
            $id = $_POST['id'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $price * $qty;
            $status = $_POST['status'];
            $customer_name = $_POST['customer_name'];
            $customer_contact = $_POST['customer_contact'];
            $customer_email = $_POST['customer_email'];
            $customer_address = $_POST['customer_address'];
        
            // Update the order in the database
            $sql2 = "UPDATE tbl_order SET  
                qty = ?,
                total = ?,
                status = ?,
                customer_name = ?,
                customer_contact = ?,
                customer_email = ?,
                customer_address = ?
                WHERE id = ?
            ";
        
            $stmt = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt, "idssisss", $qty, $total, $status, $customer_name, $customer_contact, $customer_email, $customer_address, $id);
            $res2 = mysqli_stmt_execute($stmt);
        
            if ($res2) {
                $_SESSION['update'] = "<div class='success'>Order Updated successfully.</div>";
                header('location: manage-order.php');
                exit();
            } else {
                $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                header('location: manage-order.php');
                exit();
            }
        }
        
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>
