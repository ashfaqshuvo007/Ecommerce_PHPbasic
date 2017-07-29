<?php session_start(); ?>

<?php
require_once '../partials/header.php';

if (isset($_POST['reset'])) {
    $email = strtolower(trim($_POST['email']));
    $errors = [];
    $msgs = [];

    //Validate USer's input
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $errors[] = "Email address must be valid";
    }
    //If Validtion is success we will insert into database
    if (empty($errors)) {

        $query = $con->prepare("SELECT id, username FROM admins WHERE email = :email");

        //SHOWING THE VALUES TO PLACEHLDERS IN QUERY.
        $query->bindValue('email', $email);

        //EXECUTING THE QUERY
        $query->execute();
        $data = $query->fetch(); //fetching Only one row from DB.
        //Cheking to see if the user exists in DB.
        if ($query->rowCount() == 1) {
            // If a user with this email is found then send email to the user
            /*
             * 
             * $reset_token = sha1($email . $username . time() . $_SERVER['REMOTE_ADDR']);
               $query = $con->prepare("UPDATE `admins` SET `reset_token` = :reset_token WHERE `email` = :email AND 'active' = 1 ");
             * $query->bindValue('reset_token',$reset_token);
             * $query->bindValue('email',$email);
             * $query->execute();
             * $mail = new PHPMailer;

              $mail->isSMTP();
              $mail->SMTPDebug = 2;
              $mail->Debugoutput = 'html';
              $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
              $mail->SMTPAuth = true;                               // Enable SMTP authentication
              $mail->Username = "treasurer.ieee.eusb@gmail.com";                 // SMTP username
              $mail->Password = ",./;'[]";                           // SMTP password
              $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
              $mail->Port =  587;                                  // TCP port to connect to

              $mail->setFrom('no-reply@example.com', 'Ashfaq_ecommerce');
              $mail->addAddress($email,$data['username']);     // Add a recipient
              $mail->isHTML();                                  // Set email format to HTML

              $mail->Subject = 'Reset Password Link';
              $mail->Body    = '
              <p>Hello '. $data['username'] .'</p>
              <p>
              <a href="http://localhost/php_ecommerceMe/admin/activate.php?token=' . $reset_token . ' ">Click to activate</a>
              </p>
              ';

              $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

              if(!$mail->send()) {
              $errors[] = 'Message could not be sent.';
              $errors[] = 'Mailer Error: ' . $mail->ErrorInfo;
              } else {
              $msgs[] = 'Message has been sent';
              }
             */
        }
        //OR else ask to enter another valid email.
        $errors[] = "No user found with this email address.";
    }
}
?>



<!-- Page Content -->
<div class="container">
    <div class="row">

        <div class=" col-md-offset-4 col-sm-4 col-md-offset-4">

            <?php if (!empty($errors)) { ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $v_error) { ?>
                        <p><?php echo $v_error; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (!empty($msgs)) { ?>
                <div class="alert alert-success">
                    <?php foreach ($msgs as $v_msg) { ?>
                        <p><?php echo $v_msg; ?></p>
                    <?php } ?>
                </div>
            <?php } ?>



            <form action="" method="post">             
                <div class="form-group">
                    <label for="email">Recovery Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <button href="login.php" type="submit" name="reset" class="btn btn-info">Reset Password</button>
                    <a href="index.php" class="btn btn-success">Back</a>
                    &nbsp;
                    <a href="forgot_password.php">forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /Page Content END -->

<?php require_once '../partials/footer.php'; ?>