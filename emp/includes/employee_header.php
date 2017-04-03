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
                <nav class="navbar navbar-inverse " role="navigation" style="background-color: darkblue">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <p class="navbar-text" style="color: white"><strong>Book Store </strong>Sales Management System</p>
                    </div>

                    <div class="collapse navbar-collapse navbar-ex1-collapse pull-right">
                        <ul class="nav navbar-nav">
                            <?php
                            if(isset($_SESSION['eid'])){
                                echo "<li><a href='tracking.php' style='color: white'><span class='glyphicon glyphicon-user'></span> ".$_SESSION['efname']."</a></li>";
                                echo "<li><a href='php/logout.php' style='color: white'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>";
                            } else {
                                echo "<li><a href='index.php' style='color: white'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Header Bar End -->

            <h1>Book Store Sales Management System</h1>

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
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'tracking.php'){echo 'class="active"';} ?> ><a href="tracking.php">Tracking</a></li>
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'orders.php'){echo 'class="active"';} ?> ><a href="orders.php">Orders</a></li>
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'inventory.php'){echo 'class="active"';} ?> ><a href="inventory.php">Inventory</a></li>
                            <li <?php if (basename($_SERVER['PHP_SELF']) == 'printables.php'){echo 'class="active"';} ?> ><a href="printables.php">Generate Printables</a></li>
                    </div>
                </nav>
            </div>
            <!-- Main Navigation End -->

        </header>