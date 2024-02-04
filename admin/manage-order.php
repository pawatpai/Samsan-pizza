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
        <h1>Manage Order</h1>

        <br /><br /><br />
        <?php 
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset ($_SESSION['update']);
            }
        ?>        
        <br><br>

<table class ="tbl-full"> 
    <tr>
        <th>S.N.</th>
        <th>Food</th>
        <th>Price</th>
        <th>Qty.</th>
        <th>Total</th>
        <th>Order Date</th>
        <th>Status</th>
        <th>Customer Name</th>
        <th>Contact</th>
        <th>Email</th>
        <th>Address</th>
        <th>Action</th>
    </tr>

    <?php
        //Create a SQL Query to get all the order
        $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //display last order first

        //Execute the query
        $res = mysqli_query($conn,$sql);

        //Count rows to check whether we have order or not
        $count = mysqli_num_rows($res);

        //Create serial number variable and set default value as 1
        $sn=1;

        if($count>0)
        {
            //We have order in the database
            //Get the orders from the database and display
            while($row=mysqli_fetch_assoc($res))
            {
                //Get the values from individual columns
                $id = $row['id'];
                $food = $row['food'];
                $price =$row['price'];
                $qty = $row['qty'];
                $total = $row['total'];
                $order_date = $row['order_date'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];
                ?>

                <tr> 
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $food; ?></td>
                    <td><?php echo $price; ?></td>
                    <td><?php echo $qty; ?></td>
                    <td><?php echo $total; ?></td>
                    <td><?php echo $order_date; ?></td>
                    <td>
                        <?php 
                            if($status=="Ordered")
                            {
                                echo "<label>$status</label>";
                            }
                            elseif($status=="On Delivery")
                            {
                                echo "<label style ='color: orange;'>$status</label>";
                            } 
                            elseif($status=="Delivered")
                            {
                                echo "<label style ='color: green;'>$status</label>";
                            } 
                            elseif($status=="Cancelled")
                            {
                                echo "<label style ='color: red;'>$status</label>";
                            } 
                        ?>
                    </td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $customer_contact; ?></td>
                    <td><?php echo $customer_email; ?></td>
                    <td><?php echo $customer_address; ?></td>
                    <td>
                        <a href="update-order.php?id=<?php echo $id; ?>" class="btn-primary">Update Order</a> 
                    </td>
                </tr> 

            <?php
            }
        }
        else
        {
            //Order not added in the database
            echo "<tr><td colspan='12' class='error'> Order not added Yet.</td></tr>";
        }
    ?>

</table>
    </div>
</div>
<?php include('partials/footer.php'); ?>
