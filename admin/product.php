<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
}

$query = $con->prepare('SELECT id,category_id, product_name, product_photo, product_price, available_quantity FROM `products` ');
$query->execute();
$data = $query->fetchAll();
?>
<?php
require_once 'adminheader.php';
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php require_once 'admin_sidebar.php'; ?>

        <div class=" col-sm-8">

            <div class="well">
                <a href="add_product.php" class="btn btn-success">Add Products</a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Product Name</td>
                        <td>Category Name</td>
                        <td>Product Price</td>
                        <td>Available Quantity</td>
                        <td>Product Photo</td>
                        <td>Action</td>                   
                    </tr> 
                </thead>
                <tbody>
                    <?php foreach ($data as $products) { ?>

                        <?php
                        $stmnt = $con->prepare('SELECT `category_name` FROM `categories` WHERE `id` = :id');
                        $stmnt->bindValue('id', $products['category_id'], PDO::PARAM_INT);
                        $stmnt->execute();
                        $category = $stmnt->fetch();
                        ?>
                        <tr>
                            <td><?php echo $products['id']; ?></td>
                            <td><?php echo $products['product_name']; ?></td>
                            <td><?php echo $category['category_name']; ?></td>
                            <td><?php echo $products['product_price']; ?></td>
                            <td><?php echo $products['available_quantity']; ?></td>
                            <td><img src="../uploads/product/<?php echo $products['product_photo']; ?>" alt="pro_image" width="150" ></td>
                            <td><a class="label label-info" href="edit_product.php?id=<?php echo $products['id']; ?>">Edit</a></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php'; ?>