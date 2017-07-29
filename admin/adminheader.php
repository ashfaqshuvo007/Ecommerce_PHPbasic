<?php require_once '../connection.php';?>
<?php require_once '../vendor/autoload.php';?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Ecommerce-PHP_basic</title>

        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../css/app.css" rel="stylesheet">


    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Ecommerce</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="category.php">Category</a>
                        </li>
                        <li>
                            <a href="product.php">Products</a>
                        </li>
                        <li>
                            <a href="order.php">Orders</a>
                        </li>
                        <li>
                            <a href="User.php">Users</a>
                        </li>
                        <li>
                            <a href="Admin.php">Admins</a>
                        </li>

                    </ul>
                    <div class="pull-right" style="padding:14px; color:#fff;">
                    <i class="glyphicon glyphicon-user"></i>
                           <?php echo $_SESSION['username']; ?>

                    </div>



                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
