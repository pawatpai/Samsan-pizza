
<?php
include('partials/menu.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch category data
    $sql = "SELECT * FROM tbl_category WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $current_image = $row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        header('location: manage-category.php');
        exit();
    }
} else {
    header('location: manage-category.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update category data
    $title = $_POST['title'];

    // Handle file upload
    if (!empty($_FILES['image']['name'])) {
        $new_image = $_FILES['image']['name'];
        $temp_image = $_FILES['image']['tmp_name'];
        $upload_path = "../images/category/" . $new_image;

        if (move_uploaded_file($temp_image, $upload_path)) {
            $current_image = $new_image;
        } else {
            echo "File upload failed. Error: " . $_FILES['image']['error'];
            exit();
        }
    }

    $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
    $active = isset($_POST['active']) ? $_POST['active'] : "No";

    // Update database
    $sql = "UPDATE tbl_category SET title=?, image_name=?, featured=?, active=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $current_image, $featured, $active, $id);

    if(mysqli_stmt_execute($stmt)) {
        header('location: manage-category.php');
        exit();
    } else {
        echo "Update failed: " . mysqli_error($conn);
        exit();
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
<!-- HTML form -->

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title; ?>"></td>
                </tr>
                <tr>
                    <td>Current Image</td>
                    <td><img src="../images/category/<?php echo $current_image; ?>" alt="Current Image" class="img-preview" style="width: 150px;"></td>
                </tr>
                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td><input type="radio" name="featured" value="Yes" <?php echo ($featured == 'Yes') ? 'checked' : ''; ?>>Yes
                        <input type="radio" name="featured" value="No" <?php echo ($featured == 'No') ? 'checked' : ''; ?>>No</td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td><input type="radio" name="active" value="Yes" <?php echo ($active == 'Yes') ? 'checked' : ''; ?>>Yes
                        <input type="radio" name="active" value="No" <?php echo ($active == 'No') ? 'checked' : ''; ?>>No</td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="Update Category" class="btn-primary"></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>
