<?php
require_once 'partials/header.php';
require_once 'connection.php';
session_start();


//Only when Proceed to check button is clicked from Cart
if (!isset($_POST) && empty($_POST)) {
    header('Location: cart.php');
}


if (isset($_POST['quantity'])) {
    //Updating the order infromation for specific product in session.
    foreach ($_POST['quantity'] as $pro_id => $qty) {
        $_SESSION['cart'][$pro_id] = $qty;
    }
}

//INSERTION to DB.
if (isset($_POST['order'])) {

    //TO check if visiting user or new user
    if($_POST['order']) {
        //Check
        $query_chkuser = $con->prepare('SELECT `id` FROM `users` WHERE `email` = :email  OR `phone_number` =  :phone_number');
        $query_chkuser->bindValue('email', trim($_POST['email']));
        $query_chkuser->bindValue('phone_number', trim($_POST['phone_number']));
        $query_chkuser->execute();
        //fetching only the id of the user
        $chkuser = $query_chkuser->fetch();
        if($query_chkuser->rowCount() === 1){
            //putting the id into user_id.
            $user_id = $chkuser['id'];
        }
        
    } else {
        //Insert USER
        $query_user = $con->prepare('INSERT into `users` (`fullname`, `email`,`phone_number`) VALUES (:fullname, :email, :phone_number)');
        $query_user->bindValue('fullname', trim($_POST['fullname']));
        $query_user->bindValue('email', trim($_POST['email']));
        $query_user->bindValue('phone_number', trim($_POST['phone_number']));
        $query_user->execute();

        //GEtting the user ID from the order
        $user_id = $con->lastInsertId();
    }

    //Insert ORder
    $order_query = $con->prepare('INSERT INTO `orders` (`user_id`, `shipping_address`, `total_amount`, `status`, `payment_method`) VALUES (:user_id, :shipping_address, :total_amount, :status, :payment_method)');
    $order_query->bindValue('user_id', $user_id);
    $order_query->bindValue('shipping_address', trim($_POST['shipping_address']));
    $order_query->bindValue('total_amount', trim($_POST['total_amount']));
    $order_query->bindValue('status', 'pending');
    $order_query->bindValue('payment_method', trim($_POST['payment_method']));
    $order_query->execute();
    //GEtting the order ID 
    $order_id = $con->lastInsertId();

    //Inserting Into ordered Products
    foreach ($_SESSION['cart'] as $pro_id => $qty) {
        $query = $con->prepare('INSERT INTO `ordered_products` (`order_id`, `product_id`, `quantity`) VALUES (:order_id, :product_id, :quantity)');
        $query->bindValue('order_id', (int) $order_id);
        $query->bindValue('product_id', $pro_id);
        $query->bindValue('quantity', $qty);
        $query->execute();
    }

    unset($_SESSION['cart']);
    $_SESSION['msg'] = 'Order Placed Successfully.';
    header('Location: index.php');
}
?>

<div class="container">
    <div class="row">
        <?php require_once 'partials/sidebar.php'; ?>      

        <div class="col-md-9">
            <div class="row">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Qty.</th>
                            <th>Unit Price(BDT)</th>
                            <th>Calculated Price(BDT)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $grand_total = 0; ?>
                        <?php foreach ($_SESSION['cart'] as $pro_id => $qty) { ?>
                            <?php
                            $query = $con->prepare('SELECT * FROM `products` WHERE `id` = :id ');
                            $query->bindValue('id', $pro_id, PDO::PARAM_INT);
                            $query->execute();
                            $product = $query->fetch();

                            $product_total = $qty * $product['product_price'];
                            $grand_total += $product_total;
                            ?>
                            <tr>
                                <td><?php echo $product['product_name']; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $product['product_price']; ?></td>
                                <td><?php echo $product_total; ?></td>
                            </tr>

                        <?php } ?>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><b>Total Amount :</b></td>
                            <td><b>BDT <?php echo $grand_total; ?></b></td> 
                        </tr>
                    </tfoot>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <form action="" method="post"> 
                    <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $grand_total; ?>">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Contact Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label for="shipping_address">Shipping Address</label>
                        <textarea name="shipping_address" id="shipping_address" required="" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method : </label>
                        <input type="radio" name="payment_method" id="payment_method" value="cod" checked=""> Cash On Delivery
                    </div>
                    <div class="form-group">
                        <button class="btn btn-info" type="submit" name="order">Click to Order</button>                          
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /.container -->


<?php require_once 'partials/footer.php'; ?>

