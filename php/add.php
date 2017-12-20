<?php
include_once "../includes/database.php";
session_start();

$id = $_GET['id'];
$exist = 0;

$sql = "SELECT * FROM products WHERE
        ProductID = '$id'"; 
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);

$itemArray = array(
  "pid"=>$row['ProductID'], 
  "pname"=>$row['Product Name'], 
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

header("Location: ../productpage.php?id=$id");
?>