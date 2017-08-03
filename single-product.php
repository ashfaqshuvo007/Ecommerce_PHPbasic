<?php
require_once 'partials/header.php';
require_once 'connection.php';
?>

<div class="container">

    <div class="row">
        <?php require_once 'partials/sidebar.php'; ?>

        <?php
        $query = $con->prepare('SELECT * FROM `products` WHERE `id` = :id ');
        $query->bindValue('id', $_GET['id'], PDO::PARAM_INT);
        $query->execute();
        $product = $query->fetch();
        ?>
        <div class="col-md-9">
            <div class="thumbnail">
                <img class="img-responsive" src="uploads/product/<?php echo $product['product_photo']; ?>" alt="camera">
                <div class="caption-full">
                    <h4 class="pull-right">$ <?php echo $product['product_price']; ?></h4>
                    <h4><a href="#"><?php echo $product['product_name']; ?></a>
                    </h4>                   
                    <p><?php echo $product['product_details']; ?></p>
                    <a href="cart.php?id=<?php echo $product['id']; ?>" class="btn btn-success">Add to Cart</a>
                </div>

            </div>


        </div>

    </div>

</div>
<!-- /.container -->


<?php require_once 'partials/footer.php'; ?>