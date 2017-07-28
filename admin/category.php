<?php 
session_start();
require_once '../connection.php';
require_once '../vendor/autoload.php';
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
	header('Location: index.php');
}

$query = $con->prepare('SELECT id, category_name, category_photo FROM `categories` ');
$query->execute();
$data = $query->fetchAll();
?>
<?php
require_once 'adminheader.php';

?>
<!-- Page Content -->
<div class="container">
    <div class="row">
		<?php require_once 'admin_sidebar.php';?>

        <div class=" col-sm-8">

           <div class="well">
           		<a href="add_category.php" class="btn btn-success">Add Categories</a>
           </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Category Name</td>
                        <td>Category Photo</td>
                        <td>Action</td>                   
                    </tr> 
                </thead>
                <tbody>
                    <?php foreach($data as $v_category) {?>
                    <tr>
                        <td><?php echo $v_category['id'];?></td>
                        <td><?php echo $v_category['category_name'];?></td>
                        <td><img src="../uploads/category/<?php echo $v_category['category_photo'];?>" alt="cat_image" width="100"></td>
                        <td><a class="label label-info" href="edit_category.php?id=<?php echo $v_category['id'];?>">Edit</a></td>
                    </tr>
                    <?php }?>
                </tbody>
                
            </table>

        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php';?>