<?php 
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
	header('Location: index.php');
}

$query = $con->prepare('SELECT * FROM `users` ');
$query->execute();
$users = $query->fetchAll();
?>
<?php
require_once 'adminheader.php';

?>
<!-- Page Content -->
<div class="container">
    <div class="row">
		<?php require_once 'admin_sidebar.php';?>

        <div class=" col-sm-8">

<!--           <div class="well">
           		<a href="add_category.php" class="btn btn-success">Add Categories</a>
           </div>-->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Full Name</td>
                        <td>Email</td>
                        <td>Phone Number</td>                   
                    </tr> 
                </thead>
                <tbody>
                    <?php foreach($users as $user) {?>
                    <tr>
                        <td><?php echo $user['id'];?></td>
                        <td><?php echo $user['fullname'];?></td>
                       <td><?php echo $user['email'];?></td>
                        <td><?php echo $user['phone_number'];?></td>
                    </tr>
                    <?php }?>
                </tbody>
                
            </table>

        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php';?>
