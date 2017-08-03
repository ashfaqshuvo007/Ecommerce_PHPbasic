<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
}

$query = $con->prepare('SELECT * FROM `orders` ');
$query->execute();
$orders = $query->fetchAll();
?>
<?php
require_once 'adminheader.php';
?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php require_once 'admin_sidebar.php'; ?>

        <div class=" col-sm-8">

<!--            <div class="well">
                <a href="add_product.php" class="btn btn-success">Add Products</a>
            </div>-->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>User</td>
                        <td>Total Amount</td>
                        <td>Shipping Address</td>
                        <td>Action</td>                
                    </tr> 
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>

                        <?php
                        $stmnt = $con->prepare('SELECT `fullname` FROM `users` WHERE `id` = :id');
                        $stmnt->bindValue('id', $order['user_id'], PDO::PARAM_INT);
                        $stmnt->execute();
                        $user = $stmnt->fetch();
                        ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            
                            <td><?php echo $user['fullname']; ?></td>
                            <td><?php echo $order['total_amount']; ?></td>
                            <td><?php echo $order['shipping_address']; ?></td>
                            
                            <td><a class="label label-info" href="single_order.php?id=<?php echo $order['id']; ?>">Details</a></td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>

        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php'; ?>