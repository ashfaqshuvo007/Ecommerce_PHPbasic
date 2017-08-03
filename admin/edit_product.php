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

//fetching product data to edit from DB
$query_p = $con->prepare('SELECT * FROM `products` WHERE `id` = :id ');
$query_p->bindValue('id', $_GET['id'], PDO::PARAM_INT);
$query_p->execute();
$product = $query_p->fetch();

if (isset($_POST['edit_product'])) {
    $product_name = trim($_POST['product_name']);
    //$category_id = trim($_POST['category_id']);
    $product_details = trim($_POST['product_details']);
    $product_price = trim($_POST['product_price']);
    $available_quantity = trim($_POST['available_quantity']);
    $product_photo = $product['product_photo'];
    $errors = [];
    $msgs = [];

    //Validate
    if (strlen($product_name) < 3) {
        $errors[] = "Product name cannot be less than 3 characters.";
    }

    if (strlen($product_details) < 30) {
        $errors[] = "Product name cannot be less than 30 characters.";
    }
    if (empty($product_price)) {
        $errors[] = "Product price cannot be empty.";
    }
    if (empty($available_quantity)) {
        $errors[] = "You have to add quantity.";
    }

    if (!empty($_FILES['product_photo']['tmp_name'])) {
        //File upload
        $product_photo = time() . $_FILES['product_photo']['name'];
        $destination = '../uploads/product/' . $product_photo;

//        //Code for Image Resize.     
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
//        

        move_uploaded_file($_FILES['product_photo']['tmp_name'], $destination);
    }

    if (empty($errors)) {
        //if succesful insert database.
        $query = $con->prepare("UPDATE `products` SET `product_name` = :product_name , `product_photo` = :product_photo ,`product_price` =  :product_price , `product_details` = :product_details , `available_quantity` = :available_quantity WHERE `id` = :id");

        //SHOWING THE VALUES TO PLACEHLDERS IN QUERY.
        //$query->bindValue('category_id', $category_id);
        $query->bindValue('product_name', $product_name);
        $query->bindValue('product_photo', $product_photo);
        $query->bindValue('product_details', $product_details);
        $query->bindValue('product_price', $product_price);
        $query->bindValue('available_quantity', $available_quantity);
        $query->bindValue('id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();

        if ($query->rowCount() === 1) {
            $msgs[] = 'Product updated successfully.';

            //TO show updated Values
            $query_p = $con->prepare('SELECT * FROM `products` WHERE `id` = :id ');
            $query_p->bindValue('id', $_GET['id'], PDO::PARAM_INT);
            $query_p->execute();
            $product = $query_p->fetch();
        } else {
            $msgs[] = 'Product update was unsuccessful.';
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
            <h2>Edit Product</h2>

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
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" id="product_name"class="form-control" value="<?php echo $product['product_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="product_photo">Product Photo</label>
                    <img src="../uploads/product/<?php echo $product['product_photo']; ?>" alt="pro_image" width="150" >
                    <br><br>
                    <input type="file" name="product_photo" id="product_photo" class="form-control">
                </div>
                <!--                <div class="form-group">
                                    <label for="category_name">Category</label>
                                    <select name="category_id" class="form-control">
                                        <option>Select</option>
                <?php //foreach ($categories as $v_category) { ?>
                <option value="<?php //echo $v_category['id']; ?>"><?php// echo $v_category['category_name']; ?></option>
                <?php// } ?>
                                    </select>                   
                                </div>-->
                <div class="form-group">
                    <label for="product_details">Product Details</label>
                    <textarea name="product_details" class="form-control"><?php echo $product['product_details']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="product_price">Product Price(in tk.)</label>
                    <input type="number" name="product_price" id="product_price" class="form-control" value="<?php echo $product['product_price']; ?>">
                </div>
                <div class="form-group">
                    <label for="available_quantity">Available Quantity</label>
                    <input type="number" name="available_quantity" id="available_quantity" class="form-control" value="<?php echo $product['available_quantity']; ?>">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success" name="edit_product">Edit Product</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php'; ?>