<?php
include_once "../includes/database.php";
include_once "../includes/functions.php";
session_start();

// Check for login status
if (!isset($_SESSION["id"])){
  error('You must be logged in to checkout');
}

// Manual increment of TransactionID
$sql = "SELECT MAX(TransactionID) AS max FROM Transactions";
$result = mysqli_query($link,$sql);
if (!$result) { 
    error('A database read error occurred');
}
$row = mysqli_fetch_assoc($result);

$maxtid = $row["max"]; // Find max value of TransactionID
$newtid = $maxtid + 1; // Increment above value by 1 and assign the value to $newtid

$cid = $_SESSION["id"]; // CustomerID

// Create Transaction Data
if(isset($_SESSION["cart"])){
  foreach ($_SESSION["cart"] as $item){ // Each product creates a row in Transactions table with same TransactionID
    $pid = $item["pid"];
    $quantity = $item["quantity"];
    $price = $item["price"];
    $total = $price * $quantity;
    $sql = "INSERT INTO Transactions (TransactionID,ProductID,CustomerID,Quantity)
      VALUES ('$newtid','$pid','$cid','$quantity')";
    if (!mysqli_query($link, $sql)){
      error('A database write error occurred');
    }
  }
}

mysqli_close($link);
unset($_SESSION["cart"]); // Empty cart

// Redirect to homepage after successful purchase
echo "<script>
alert('Your purchase order was processed successfully');
window.location.href='../index.php';
</script>";

?>