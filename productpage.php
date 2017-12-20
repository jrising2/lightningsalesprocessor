<?php
include_once "includes/header.php";
include_once "includes/database.php";
include_once "includes/functions.php";

$id = $_GET['id'];
$product = productQuery($id);
?>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style>*{font-family: 'Roboto';}.inline{display:inline;}.price{color:forestgreen;margin-left: 1em;font-size: 1.45em;</style>
</head>

        <!-- Main Body Start -->
        <div class="row">
            <div class="col-md-4"><img class="img-responsive" src=" <?php displayImage($id); ?> " ></div>
            <div class="col-md-8">
                <div class="row"><h1 class="inline"> <?php displayTitle($id); ?> </h1><p class="price inline"><?php displayPrice($id); ?></p></div>
                <div class="row">
                    <form method="post" action="php/add.php?id=<?php echo $id; ?>">
                    <?php
                    if($product['Stock']<1){
                        echo "<h3 style='color:red'>Out of stock</h3>";
                    } else {
                        echo "<input type='text' name='quantity' value='1' size='2' />";
                        echo "<input type='submit' value='Add To Cart' class='btn btn-success btn-sm' />";
                    }
                    ?>
                    </form>
                    <hr>
                    <p>
                        <?php if(empty($product['Description'])){echo 'No description available.';}else{echo $product['Description'];} ?>
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
                    <tr><td>ISBN</td><td><?php echo $product['ISBN']; ?></td></tr>
                    <tr><td>Genre</td><td><?php if(empty($product['Genre'])){ echo 'N/A'; }else{ echo $product['Genre']; }  ?></td></tr>
                    <tr><td>Authors</td><td><?php if(empty($product['Author'])){ echo 'N/A'; }else{ echo $product['Author']; } ?></td></tr>
<!--                    <tr><td>Pages</td><td>500</td></tr>-->
                </table>
            </div>
            <div class="col-md-6">
                <h2>Purchase Options</h2>
                <table class="table table-bordered table-condensed table-responsive">
                    <tr>
                        <th>Option</th>
                        <th>Stock</th>
                        <th>Price</th>
                    </tr>
                    <tr><td>New</td><td><?php echo $product['Stock'] ?></td><td>$<?php echo $product['Price']; ?></td></tr>
                    <tr><td>Used</td><td>N/A</td><td>N/A</td></tr>
                    <tr><td>Digital</td><td>N/A</td><td>N/A</td></tr>
                </table>
            </div>
        </div>
        <hr>
        <!-- Main Body End -->

<?php
include_once "includes/footer.php";
?>