<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
}

//Fetching Order Details.
$query_order = $con->prepare('SELECT * FROM `orders` WHERE `id` = :id');
$query_order->bindValue('id', trim($_GET['id']), PDO::PARAM_INT);
$query_order->execute();
$order = $query_order->fetch();


//Fetching product details
$query_product= $con->prepare('SELECT `product_id`, `quantity` FROM `ordered_products` WHERE `order_id` = :id');
$query_product->bindValue('id', trim($_GET['id']), PDO::PARAM_INT);
$query_product->execute();
$products = $query_product->fetchAll();


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
                            <h3>Order ID: <?php echo $order['id'] ;?></h3>
                            <p>Total Amount:  <b>BDT <?php echo $order['total_amount'] ;?></b></p>
                            <p>Shipping Address: <b><?php echo $order['shipping_address'] ;?></b></p>
                        </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product Qty.</th>                 
                    </tr> 
                </thead>
                <tbody>
                    <?php foreach ($products as $product) { ?>

                        <?php
                        $stmnt = $con->prepare('SELECT `product_name` FROM `products` WHERE `id` = :id');
                        $stmnt->bindValue('id', trim($product['product_id']), PDO::PARAM_INT);
                        $stmnt->execute();
                        $pro = $stmnt->fetch();
                        ?> 
                        <tr>
                            <td><?php echo $product['product_id']; ?></td>
                            <td><?php echo $pro['product_name']; ?></td>
                            <td><?php echo $product['quantity']; ?></td>                    
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php'; ?>