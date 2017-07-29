<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';

if (empty($_GET['token']) || !isset($_GET['token'])) {
    header('Location: index.php');
}

$msgs[] = 'Your token is invalid.';
$show_form = false;

$query = $con->prepare('SELECT id FROM `admins` WHERE `reset_token` = :token');
$query->bindValue('token', trim($_GET['token']));
$query->execute();

if ($query->rowCount() === 1) {
    $show_form = true;
}

if (isset($_POST['reset'])) {
    $password = trim($_POST['password']);
    $errors = [];

    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }

    if (empty($errors)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $query = $con->prepare('UPDATE `admins` SET `password` = :password WHERE `reset_token` = :reset_token');
        $query->bindValue('password', $password);
        $query->bindValue('reset_token', trim($_GET['token']));
        $query->execute();

        if ($query->rowCount() === 1) {
            $msgs[] = 'Your password is changed.';
            $show_form = false;
            $query = $connection->prepare('UPDATE `admins` SET `reset_token` = NULL WHERE `reset_token` = :reset_token');
            $query->bindValue('reset_token', trim($_GET['token']));
            $query->execute();
        }
    }
}

require_once 'adminheader.php';
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-md-offset-4">
            <?php if ($show_form === true) { ?>
                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) { ?>
                            <p><?php echo $error; ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-info" type="submit" name="reset">Reset Password</button>
                    </div>
                </form>
            <?php } else { ?>
                <div class="alert alert-info">
                    <p><?php echo $message; ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
