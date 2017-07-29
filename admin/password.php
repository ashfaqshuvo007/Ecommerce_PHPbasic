<?php
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';

if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
    header('Location: index.php');
}

if (isset($_POST['change'])) {
    $old_password = trim($_POST['old_password']);
    $new_password = trim($_POST['new_password']);
    $errors = [];

    if (strlen($old_password) < 6 || strlen($new_password) < 6) {
        $errors[] = 'Password must be at least 6 chars.';
    }

    if (empty($errors)) {
        $query = $con->prepare('SELECT `password` FROM `admins` WHERE `username` = :username');
        $query->bindValue('username', $_SESSION['username']);
        $query->execute();
        $data = $query->fetch();

        if (password_verify($old_password, $data['password'])) {
            $query = $con->prepare('UPDATE `admins` SET `password` = :new_password WHERE `username` = :username');
            $query->bindValue('new_password', password_hash($new_password, PASSWORD_BCRYPT));
            $query->bindValue('username', $_SESSION['username']);
            $query->execute();

            $messages[] = 'Password changed.';
        } else {
            $errors[] = 'Current password is not correct.';
        }
    }
}

require_once 'adminheader.php';
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <?php require_once 'admin_sidebar.php'; ?>

        <div class="col-md-4">
            <?php if (!empty($errors)) { ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error) { ?>
                        <p><?php echo $error; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!empty($msgs)) { ?>
                <div class="alert alert-success">
                    <?php foreach ($msgs as $message) { ?>
                        <p><?php echo $message; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="old_password">Current Password</label>
                    <input type="password" name="old_password" id="old_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <button class="btn btn-info" type="submit" name="change">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../partials/footer.php'; ?>
