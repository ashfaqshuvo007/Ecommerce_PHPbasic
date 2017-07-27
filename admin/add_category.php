<?php session_start();?>
<?php
if (empty($_SESSION) || empty($_SESSION['id']) || empty($_SESSION['username'])) {
	header('Location: index.php');
}
if (isset($_POST['category'])) {
	$category_name = trim($_POST['category_name']);
	$errors = [];
	$msgs = [];
	//Validate
	if (strlen($category_name) < 3) {
		$errors[] = "Category name cannot be less than 3 characters.";
	}

	if (!empty($_FILES['category_photo'])) {
		//File upload

	}

	if (empty($errors)) {
		# co
	}
	//if succesful insert database
}

?>

<?php
require_once 'adminheader.php';

?>
<!-- Page Content -->
<div class="container">
    <div class="row">
		<?php require_once 'admin_sidebar.php';?>

        <div class=" col-sm-8">
           <h2>Add Category</h2>

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

         <form action="add_category.php" method="post" enctype="multipart/form-data">
         	<div class="form-group">
         		<label for="category_name">Category Name</label>
         		<input type="text" name="category_name" class="form-control" required="">
         	</div>
         	<div class="form-group">
         		<label for="category_photo">Category Photo</label>
         		<input type="file" name="category_photo" class="form-control">
         	</div>
			<div class="form-group">
         		<button type="submit" class="btn btn-success" name="category">Add Category</button>
         	</div>
         </form>


        </div>
    </div>
</div>


<!-- /Page Content END -->

<?php require_once '../partials/footer.php';?>