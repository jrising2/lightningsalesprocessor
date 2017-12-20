<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <header>
            <!-- Header Bar Start -->
            <div id="topHeaderRow">
                <nav class="navbar navbar-inverse " role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <p class="navbar-text">Welcome to <strong>Book Store</strong></p>
                    </div>

                    <div class="collapse navbar-collapse navbar-ex1-collapse pull-right">
                        <ul class="nav navbar-nav">
                            <?php
                            if(isset($_SESSION['id'])){
                                echo "<li><a href='account.php'><span class='glyphicon glyphicon-user'></span> ".$_SESSION['fname']."</a></li>";
                                echo "<li><a href='php/logout.php'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
                            } else {
                                echo "<li><a href='login.php'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
                            }
                            ?>
                            <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Header Bar End -->


            <div class="row">
                <div class="col-md-4">
                    <h1>Book Store</h1>
                </div>
                <div class="navbar-collapse pull-right">
                    <form class="form-inline" role="search">
                        <div class="input-group">
                            <label class="sr-only" for="search">Search</label>
                            <input type="text" class="form-control" placeholder="Search" name="search">
                            <span class="input-group-btn">
	          <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Main Navigation Start -->
            <div id="mainNavigationRow">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <ul class="nav navbar-nav">
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'){echo 'class="active"';} ?> ><a href="index.php">Home</a></li>
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'about.php'){echo 'class="active"';} ?> ><a href="about.php">About Us</a></li>
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'catalog.php'){echo 'class="active"';} ?> ><a href="catalog.php">Catalog</a></li>
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'customer_service.php'){echo 'class="active"';} ?> ><a href="#">Customer Service</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Main Navigation End -->

        </header>