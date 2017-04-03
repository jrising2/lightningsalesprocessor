<?php
include_once "../includes/database.php";
include_once "../includes/functions.php";
session_start();

$uid = isset($_POST['email']) ? $_POST['email'] : $_SESSION['email'];
$pwd = isset($_POST['pass']) ? $_POST['pass'] : $_SESSION['pass'];
$pwd = md5($pwd);

$sql = "SELECT * FROM Customers WHERE
        Email = '$uid' AND Password = '$pwd'"; // search for matching email and password
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);
$_SESSION['id'] = $row['CustomerID']; // save customer info into session variables
$_SESSION['fname'] = $row['FirstName'];
$_SESSION['lname'] = $row['LastName'];
$_SESSION['email'] = $row['Email'];
$_SESSION['add1'] = $row['Address1'];
$_SESSION['add2'] = $row['Address2'];
$_SESSION['city'] = $row['City'];
$_SESSION['state'] = $row['State'];
$_SESSION['zip'] = $row['ZipCode'];
if (isset($_SESSION['id'])){
	header("Location: ../account.php"); // redirect after successful login
}

// no matching data was found
if (mysqli_num_rows($result) == 0) {
  unset($_SESSION['id']);
  unset($_SESSION['id']);
  error("Your email or password is incorrect");	
	exit;
}
?>