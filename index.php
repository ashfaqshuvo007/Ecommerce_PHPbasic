<?php
require_once 'partials/header.php';
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <?php require_once 'partials/sidebar.php'; ?>

        <div class="col-md-9">

            <?php require_once 'partials/carousal.php'; ?>

            <div class="row">
                
                <div class="col-sm-4 col-lg-4 col-md-4">
                    <div class="thumbnail">
                        <img src="http://placehold.it/320x150" alt="product_image">
                        <div class="caption">
                            <h4 class="pull-right">$64.99</h4>
                            <h4><a href="single-product.php">Product Title</a>
                            </h4>
                            <p>Product Description</p>
                        </div>

                    </div>
                </div>
                
                
            </div>

        </div>

    </div>

</div>
<!-- /.container -->

<?php require_once 'partials/footer.php'; ?>