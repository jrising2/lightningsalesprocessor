<?php
include_once "../../includes/database.php";
include_once "../../includes/functions.php";
session_start();

$uid = isset($_POST['eid']) ? mysqli_real_escape_string($link, $_POST['eid']) : $_SESSION['eid'];
$pwd = isset($_POST['epass']) ? $_POST['epass'] : $_SESSION['epass'];
$pwd = md5($pwd);

$sql = "SELECT * FROM Employees WHERE
        EmployeeID = '$uid' AND Password = '$pwd'"; // search for matching email and password
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);
$_SESSION['eid'] = $row['EmployeeID']; // save customer info into session variables
$_SESSION['efname'] = $row['FirstName'];
$_SESSION['elname'] = $row['LastName'];
$_SESSION['role'] = $row['Role'];
if (isset($_SESSION['eid'])){
	header("Location: ../tracking.php"); // redirect after successful login
}

// no matching data was found
if (mysqli_num_rows($result) == 0) {
  unset($_SESSION['eid']);
  unset($_SESSION['efname']);
  unset($_SESSION['elname']);
  unset($_SESSION['role']);
  error("Your ID or password is incorrect");
	exit;
}
?>