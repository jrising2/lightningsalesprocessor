<?php
require_once('config/database.php');

if(isset($_GET["id"])){
    $productID = $_GET["id"];
    $query = "SELECT * FROM Products WHERE ProductID=\"".$productID."\"";
    $result = $link->query($query);
    $result = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>*{font-family: 'Roboto';}.inline{display:inline;}.price{color:forestgreen;margin-left: 1em;font-size: 1.45em;</style>
</head>

<body>
    <div class="container">

        <?php require("includes/header.php"); ?>

        <!-- Main Body Start -->
        <div class="row">
            <div class="col-md-4"><img class="img-responsive" src="image/<?php echo $result["ISBN"]; ?>.jpg"></div>
            <div class="col-md-8">
                <div class="row"><h1 class="inline"><?php echo $result["Product Name"]; ?></h1><p class="price inline">$<?php echo $result["Price"]; ?></p></div>
                <div class="row">
                    <a href="#" class="btn btn-success btn-sm">Add To Cart</a>
                    <a href="#" class="btn btn-primary btn-sm">Add To Wishlist</a>
                    <hr>
                    <p>
                        <?php echo $result["Description"]; ?>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <h2>Product Details</h2>
                <table class="table table-bordered table-condensed table-responsive">
                    <tr>
                        <th>Property</th>
                        <th>Detail</th>
                    </tr>
                    <tr><td>ISBN</td><td><?php echo $result["ISBN"]; ?></td></tr>
<!--                    <tr><td>Book Edition</td><td>1st Edition</td></tr>-->
<!--                    <tr><td>Authors</td><td>Hawon Woo, Rebecca Chase</td></tr>-->
<!--                    <tr><td>Pages</td><td>500</td></tr>-->
                </table>
            </div>
<!--            <div class="col-md-6">-->
<!--                <h2>Purchase Options</h2>-->
<!--                <table class="table table-bordered table-condensed table-responsive">-->
<!--                    <tr>-->
<!--                        <th>Option</th>-->
<!--                        <th>Quantity</th>-->
<!--                        <th>Price</th>-->
<!--                    </tr>-->
<!--                    <tr><td>New</td><td>10</td><td>$200</td></tr>-->
<!--                    <tr><td>Used</td><td>3</td><td>$100</td></tr>-->
<!--                    <tr><td>Digital</td><td>N/A</td><td>$100</td></tr>-->
<!--                </table>-->
<!--            </div>-->
        </div>
        <hr>
        <!-- Main Body End -->

        <?php require("includes/footer.php"); ?>

        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </div>
</body>

</html>