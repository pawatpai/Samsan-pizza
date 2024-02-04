
<?php
include('partials/menu.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch food data
    $sql2 = "SELECT * FROM tbl_food WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row2 = mysqli_fetch_assoc($result);
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    } else {
        header('location: manage-food.php');
        exit();
    }
} else {
    header('location: manage-food.php');
    exit();
}

if (isset($_POST['submit'])) {
    // Get all the details from the form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // Upload the image if selected
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Get the details of the selected image
        $image_name = $_FILES['image']['name'];

        // Image is available
        // Upload the image
        // 1. Rename the image
        $ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $image_name = "Food-Name-" . rand(0000, 9999) . "." . $ext;

        // 2. Upload the image
        $src_path = $_FILES['image']['tmp_name'];
        $dest_path = "../images/food/" . $image_name;
        $upload = move_uploaded_file($src_path, $dest_path);

        if (!$upload) {
            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
            header('location: manage-food.php');
            die();
        }

        // Remove the current image if a new image is uploaded and the current image exists
        if ($current_image != "") {
            $remove_path = "../images/food/" . $current_image;
            $remove = unlink($remove_path);

            if (!$remove) {
                $_SESSION["remove-failed"] = "<div class='error'>Failed to remove the current image.</div>";
                header('location: manage-food.php');
                die();
            }
        }
    } else {
        $image_name = $current_image; // Set the default value as blank
    }

    // Update the food in the database
    $sql3 = "UPDATE tbl_food SET  
        title = '$title',
        description = '$description',
        price = $price,
        image_name = '$image_name',
        category_id = $category,
        featured = '$featured',
        active = '$active'
        WHERE id = $id";

    $res3 = mysqli_query($conn, $sql3);

    if ($res3) {
        $_SESSION['update'] = "<div class='success'>Food Updated successfully.</div>";
        header('location: manage-food.php');
    } else {
        $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
        header('location: manage-food.php');
    }
}
?>
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
        <h1>Update Food</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type ="number" name="price" value="<?php echo $price ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image</td>
                    <td><img src="../images/food/<?php echo $current_image; ?>" alt="Current Image" class="img-preview" style="width: 150px;"></td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                            // Create PHP code to display categories from Database
                            // 1. Create SQL to get all active categories from the database
                            $sql = "SELECT * FROM tbl_category WHERE active='YES'";

                            // Execute query
                            $res = mysqli_query($conn, $sql);

                            // Count Rows to check whether we have categories or not
                            $count = mysqli_num_rows($res);

                            // If count is greater than zero, we have categories, else we do not have categories
                            if ($count > 0) {
                                // We have categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    // Get the details of categories
                                    $category_title = $row["title"];
                                    $category_id = $row["id"];
                                    ?>

                                    <option <?php if($current_category==$category_id) {echo "selected";}?>
                                        value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                    <?php
                                }
                            } else {
                                // We do not have categories
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php echo ($featured == 'Yes') ? 'checked' : ''; ?>>Yes
                        <input type="radio" name="featured" value="No" <?php echo ($featured == 'No') ? 'checked' : ''; ?>>No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td><input type="radio" name="active" value="Yes" <?php echo ($active == 'Yes') ? 'checked' : ''; ?>>Yes
                        <input type="radio" name="active" value="No" <?php echo ($active == 'No') ? 'checked' : ''; ?>>No</td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-primary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
