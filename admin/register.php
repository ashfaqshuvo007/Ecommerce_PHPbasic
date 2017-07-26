<?php
require_once '../partials/header.php';

//Catching values submitted by user
if(isset($_POST['register']))
{
    $user   = trim($_POST['username']);
    $email  = trim($_POST['email']);
    $pass   = trim($_POST['password']);
    $errors = [];
    $msgs    = [];
    
    
    //Validate USer's input
    if(strlen($user) < 6)
    {
        $errors[] = "Username msut be at least 6 characters";
    }
    if(filter_var($email, FILTER_VALIDATE_EMAIL) == false)
    {
        $errors[]= "Email address must be valid";
    }   
    if(strlen($pass) < 6)
    {
        $errors[] = "Password msut be at least 6 characters";
    }
    //If Validtion is success we will insert into database
    if(empty($errors))
    {
        //PASSWORD ENCRYPTING USING BUILT-IN HASHING  ALGO 
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        // GENERATES RANDOM ENCRYPTED STRING 
        $activation_token = (sha1($email).time().$_SERVER['REMOTE_ADDR']);
        //MAKING THE QUERY USING PREPARE TO AVOID SQL INJECTION
        $query = $con->prepare("INSERT INTO admins(username,email,password,activation_token)"
                . " VALUES(:username,:email,:password,:activation_token)");
        
        //SHOWING THE VALUES TO PLACEHLDERS IN QUERY.
        $query->bindValue('username',strtolower($user));
        $query->bindValue('email',$email);
        $query->bindValue('password',$pass);
        $query->bindValue('activation_token',$activation_token);
        
        //EXECUTING THE QUERY
        $query->execute();
        
        $msgs[] = "Registration Successfully Done..";
    }
    
    //email the user
    
    
    //Show message to user
}

?>
<!-- Page Content -->
<div class="container">
    <div class="row">

        <div class=" col-md-offset-4 col-sm-4 col-md-offset-4">
            <?php if(!empty($errors)) {?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $v_error) {?>
                <p><?php echo $v_error ;?></p>  
                <?php }?>
            </div>            
            <?php }?>
            
            <?php if(!empty($msgs)) {?>
            <div class="alert alert-success">
                <?php foreach($msgs as $v_msg) {?>
                <p><?php echo $v_msg ;?></p>  
                <?php }?>
            </div>            
            <?php }?>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit" name="register">Register</button>
                    <a href="index.php" class="btn btn-danger">Login</a>                   
                </div>
            </form>
        </div>
    </div>      
</div>
<!-- /Page Content END -->

<?php require_once '../partials/footer.php'; ?>