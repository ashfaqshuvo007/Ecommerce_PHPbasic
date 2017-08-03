<?php
require_once 'partials/header.php';
require_once 'connection.php';

session_start();

//If there isn't any value set in the cart array
// i.e. no product is being added by user. First we set it to be empty

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}



//To catch which product and how many have been added by customer.
// for the logged in user we check if user is logged in or not
if (isset($_GET['id'])) {
    if (array_key_exists((int) trim($_GET['id']), $_SESSION['cart'])) {
        //if there is an order generated through a product id 
        //How many time the product has been added to cart.
        $_SESSION['cart'][(int) trim($_GET['id'])] ++;
    } else {
        //if no key is set ie. no product is added then pass id for first time 
        // pass id =1.
        $_SESSION['cart'][(int) trim($_GET['id'])] = 1;
    }
}
// If clear cart action is called.
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    unset($_SESSION['cart']);
}
?>

<div class="container">
    <div class="row">
        <?php require_once 'partials/sidebar.php'; ?>      

        <div class="col-md-9">
            <div class="row">
                <?php if (!empty($_SESSION['cart'])) { ?>
                    <form action="checkout.php" method="post">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Qty.</th>
                                    <th>Unit Price</th>
                                </tr>

                            </thead>

                            <?php foreach (array_unique($_SESSION['cart']) as $pro_id => $qty) { ?>
                                <?php
                                $query = $con->prepare('SELECT * FROM `products` WHERE `id` = :id ');
                                $query->bindValue('id', $pro_id, PDO::PARAM_INT);
                                $query->execute();
                                $product = $query->fetch();
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $product['product_name']; ?></td>
                                        <td><input type="number" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $qty; ?>"></td>
                                        <td><?php echo $product['product_price']; ?></td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                        <button class="btn btn-info pull-right">Proceed to Checkout</button>
                    </form> 
                    <a href="cart.php?action=clear" class="btn btn-danger">Clear Cart</a>
                <?php } else { ?>
                    <div class="alet alert-info">
                        No product added to shopping cart.
                    </div>              
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->


<?php require_once 'partials/footer.php'; ?>