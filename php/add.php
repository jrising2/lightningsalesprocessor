<?php
include_once "../includes/database.php";
include_once "../includes/functions.php";
session_start();

$id = $_GET['id'];
$exist = 0;

$sql = "SELECT * FROM Products WHERE
        ProductID = '$id'"; 
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);

if($_POST["quantity"] > $row["Stock"]){
  error("Your desired quantity is more than we have on stock.\\nPlease reduce quantity and try again.");
}

$itemArray = array(
  "pid"=>$row['ProductID'], 
  "pname"=>$row['ProductName'], 
  "isbn"=>$row['ISBN'], 
  "price"=>$row['Price'], 
  "quantity"=>$_POST['quantity']);

if(isset($_SESSION['cart'])){
  foreach($_SESSION["cart"] as $item){
    if($item["pid"] == $id){
      $exist = 1;
      $_SESSION['cart'][$id]["quantity"] += $_POST['quantity'];
    }
  }
  if($exist == 0){
    $_SESSION['cart'][$id] = $itemArray;
  }
} else {
  $_SESSION['cart'][$id] = $itemArray;
}

echo "<script>
alert('Item added to cart');
window.location.href='../productpage.php?id=$id';
</script>";
?>