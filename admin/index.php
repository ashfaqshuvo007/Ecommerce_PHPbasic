<?php session_start();?>

<?php
require_once '../partials/header.php';

require_once '../vendor/autoload.php';

if(isset($_SESSION['id'],$_SESSION['username']))
{
    header('Location: dashboard.php');
}

if (isset($_POST['login'])) {
	$user = trim(strtolower($_POST['username']));
	$pass = trim($_POST['password']);
	$errors = [];
	$msgs = [];

	//Validate USer's input
	if (strlen($user) < 6) {
		$errors[] = "Username msut be at least 6 characters";
	}
	if (strlen($pass) < 6) {
		$errors[] = "Password msut be at least 6 characters";
	}
	//If Validtion is success we will insert into database
	if (empty($errors)) {

		$query = $con->prepare("SELECT id, username,email,password FROM admins WHERE username = :username");

		//SHOWING THE VALUES TO PLACEHLDERS IN QUERY.
		$query->bindValue('username', strtolower($user));
		//EXECUTING THE QUERY
		$query->execute();
		$data = $query->fetch();

		if ($query->rowCount() == 1 && password_verify($pass, $data['password']) == true) {
			$_SESSION['id'] = (int) $data['id'];
			$_SESSION['username'] = $user;
			header('Location: dashboard.php');
		}

		$errors[] = "Invalid Uername or Password.";
	}
}
?>



<!-- Page Content -->
<div class="container">
    <div class="row">

        <div class=" col-md-offset-4 col-sm-4 col-md-offset-4">

            <?php if (!empty($errors)) {?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $v_error) {?>
                <p><?php echo $v_error; ?></p>
                <?php }?>
            </div>
            <?php }?>

            <?php if (!empty($msgs)) {?>
            <div class="alert alert-success">
                <?php foreach ($msgs as $v_msg) {?>
                <p><?php echo $v_msg; ?></p>
                <?php }?>
            </div>
            <?php }?>



            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <button href="login.php" type="submit" name="login" class="btn btn-success">Login</button>
                    <a href="register.php" class="btn btn-danger">Register</a>
                    &nbsp;
                    <a href="forgot_password.php">forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Page Content END -->

<?php require_once '../partials/footer.php';?>