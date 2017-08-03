
<?php

    $query = $con->prepare('SELECT * FROM `categories`');
    $query->execute();
    $categories = $query->fetchAll();



?>





<div class="col-md-3">
    <p class="lead">Categories</p>
    <div class="list-group">
        <?php foreach ($categories as $v_category) { ?>
        <a href="single_category.php?id=<?php echo $v_category['id'];?>" class="list-group-item"><?php echo $v_category['category_name'];?></a>       
        <?php }?>
    </div>
</div>