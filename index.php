<?php
require_once 'partials/header.php';
require_once 'connection.php';

session_start();

$query = $con->prepare('SELECT * FROM `products`');
$query->execute();
$products = $query->fetchAll();
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php require_once 'partials/sidebar.php'; ?>

        <div class="col-md-9">
             <?php if(isset($_SESSION['msg'])) {?>
            <div class="alert alert-success">               
                <p><?php echo $_SESSION['msg'] ;?></p>                 
            </div>            
            <?php unset($_SESSION['msg']);}?>

            <?php require_once 'partials/carousal.php'; ?>

            <div class="row">
                <?php foreach ($products as $v_product) { ?>
                    <div class="col-sm-4 col-lg-4 col-md-4">

                        <div class="thumbnail">
                            <img src="uploads/product/<?php echo $v_product['product_photo']; ?>" alt="product_image">
                            <div class="caption">
                                <h4 class="pull-right">$ <?php echo $v_product['product_price']; ?></h4>
                                <h4>
                                    <a href="single-product.php?id=<?php echo $v_product['id']; ?>"><?php echo $v_product['product_name']; ?></a>
                                </h4>
                                <p><?php echo $v_product['product_details']; ?></p>
                            </div>
                        </div>

                    </div>
                <?php } ?>

            </div>

        </div>

    </div>

</div>
<!-- /.container -->

<?php require_once 'partials/footer.php'; ?>