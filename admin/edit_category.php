<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';

// import the Intervention Image Manager Class
//use Intervention\Image\ImageManagerStatic as Image;

?>
<?php
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
}
// TO show the last user input.
$query = $con->prepare('SELECT category_name, category_photo FROM `categories` WHERE id = :id ');
$query->bindValue('id', $_GET['id'], PDO::PARAM_INT);
$query->execute();
$data = $query->fetch();

if (isset($_POST['category'])) {
    $category_name = trim($_POST['category_name']);
    $category_photo = $data['category_photo'];
    $errors = [];
    $msgs = [];
    //Validate
    if (strlen($category_name) < 3) {
        $errors[] = "Category name cannot be less than 3 characters.";
    }

    if (!empty($_FILES['category_photo']['tmp_name'])) {
        //File upload
        $category_photo = time() . $_FILES['category_photo']['name'];
        $destination = '../uploads/category/' . $category_photo;
//Code for Image Resize.     
//        $image = Image::make($_FILES['category_photo']['tmp_name'])
//                ->resize(250,250)
//                ->save();
//       
//        // create instance
//        $image->make($_FILES['category_photo']['tmp_name']);
//        // resize image to fixed size
//        $image->resize(250, 250);
//        //To auto save the image in location after resize
//        $image->save($destination);
//        //To delete the previous file
//        
//        unlink('../uploads/category/'. $data['category_photo']);
//  

        move_uploaded_file($_FILES['category_photo']['tmp_name'], $destination);
    }

    if (empty($errors)) {
        //if succesful insert database.
        $query = $con->prepare("UPDATE `categories` SET `category_name` = :category_name , `category_photo` = :category_photo WHERE `id` = :id ");

        //SHOWING THE VALUES TO PLACEHLDERS IN QUERY.
        $query->bindValue('category_name', $category_name);
        $query->bindValue('category_photo', $category_photo);
        $query->bindValue('id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();


        if ($query->rowCount() === 1) {
            $msgs[] = 'Category updated successfully.';

            // TO show the last user input.
            $query = $con->prepare('SELECT category_name, category_photo FROM `categories` WHERE id = :id ');
            $query->bindValue('id', $_GET['id'], PDO::PARAM_INT);
            $query->execute();
            $data = $query->fetch();
        }
    }
}
?>

<?php
require_once 'adminheader.php';
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php require_once 'admin_sidebar.php'; ?>

        <div class=" col-sm-8">
            <h2>Edit Category</h2>

            <?php if (!empty($errors)) { ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $v_error) { ?>
                        <p><?php echo $v_error; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!empty($msgs)) { ?>
                <div class="alert alert-success">
                    <?php foreach ($msgs as $v_msg) { ?>
                        <p><?php echo $v_msg; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" name="category_name" class="form-control" required="" value="<?php echo $data['category_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="category_photo">Category Photo</label>&nbsp;
                    <img src="../uploads/category/<?php echo $data['category_photo']; ?>" alt="cat_image" width="100">
                    <br><br>
                    <input type="file" name="category_photo" class="form-control">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-success" name="category">Edit Category</button>
                </div>
            </form>


        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php
require_once '../partials/footer.php';
