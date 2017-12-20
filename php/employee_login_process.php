<?php
include_once "database.php";
session_start();

$uid = isset($_POST['email']) ? $_POST['email'] : $_SESSION['email'];
$pwd = isset($_POST['pass']) ? $_POST['pass'] : $_SESSION['pass'];

$sql = "SELECT * FROM Employees WHERE
        EmployeeID = '$uid' AND EmployeeID = '$pwd'"; // search for matching email and password
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);
$_SESSION['id'] = $row['EmployeeID']; // save customer info into session variables
$_SESSION['fname'] = $row['FirstName'];
$_SESSION['lname'] = $row['LastName'];
$_SESSION['role'] = $row['Role'];
if (isset($_SESSION['id'])){
	header("Location: employee_account.php"); // redirect after successful login
}

// no matching data was found
if (mysqli_num_rows($result) == 0) {
  unset($_SESSION['id']);
  include_once "employee_header.html";
?>

  <!DOCTYPE html PUBLIC "-//W3C/DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title> Access Denied </title>
    <meta http-equiv="Content-Type"
      content="text/html; charset=iso-8859-1" />
  </head>
  <body>
  <h1> Access Denied </h1>
  <p>Your user ID or password is incorrect, or you are not a
     registered user on this site. 
     <a href="employee_login.php">Login</a> or 
     <a href="register.php">Register</a>.</p>
  </body>
  </html>

<?php
	include_once "footer.html";
	exit;
}
?>