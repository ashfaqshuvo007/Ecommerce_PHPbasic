<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';

//if (empty($_GET['token']) || !isset($_GET['token'])) {
//    header('Location: index.php');
//}
//
//$msgs[] = 'Your token is invalid.';
//
//$query = $connection->prepare('UPDATE `admins` SET `active` = 1 WHERE `activation_token` = :token');
//$query->bindValue('token', trim($_GET['token']));
//$query->execute();
//if ($query->rowCount() === 1) {
//    $msgs[] = 'Your account is activated.';
//    $query = $connection->prepare('UPDATE `admins` SET `activation_token` = NULL WHERE `activation_token` = :token');
//    $query->bindValue('token', trim($_GET['token']));
//    $query->execute();
//}

require_once 'adminheader.php';
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <div class="alert alert-success">
                <?php echo $msgs; ?>
            </div>
            <a href="index.php" class="btn btn-block btn-success">You can login now!</a>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
