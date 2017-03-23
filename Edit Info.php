<?php
include_once "includes/database.php";

//this form still needs a lot of error checking/validation
global $link;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$add1 = $_POST['add1'];
$add2 = $_POST['add2'];
$state = $_POST['state'];
$city = $_POST['city'];
$zip = $_POST['zip'];

//may have some redundancy checks if information is unchanged on commit (right now database isnt updated to represent phone and country)
$updatecustomer = "UPDATE Customers SET FirstName= {$fname}, LastName={$lname}, Email={$email}, Address1={$add1}, Address2={$add2}, State={$state}, City={$city}, ZipCode={$zip} WHERE CustomerID= {$_SESSION['id']}";
mysqli_query($link, $updatecustomer);
header("Location: ./account.php");
exit();
//unsuccesful commit some validation errors (will add validation later)

?>