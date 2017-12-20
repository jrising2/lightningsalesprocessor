<?php
include_once "../includes/database.php";
include_once "../includes/functions.php";
session_start();

$fname = mysqli_real_escape_string($link, $_POST['fname']);
$lname = mysqli_real_escape_string($link, $_POST['lname']);
$email = mysqli_real_escape_string($link, $_POST['email']);
$pass = md5($_POST['pass']);

$a = $fname;
$b = $lname;

// optional fields at register
//$add1 = mysqli_real_escape_string($link, $_POST['address1']);
//$add2 = mysqli_real_escape_string($link, $_POST['address2']);
//$city = mysqli_real_escape_string($link, $_POST['city']);
//$state = mysqli_real_escape_string($link, $_POST['state']);
//$zip = mysqli_real_escape_string($link, $_POST['zip']);

/* this code not working for some reason
if ($_POST['fname']=='' or $_POST['lname']==''
  or $_POST['email']=='' or $_POST['pass']=='' or $_POST['passrp']=='') {
    error('One or more required fields were left blank.\\n'.
          'Please fill them in and try again.');
}
*/

if ($_POST['pass'] != $_POST['passrp']){
	error('Password did not match. Please try again.');
}

$sql = "SELECT * FROM Customers WHERE Email = '$email'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);

if (!$result) {	
    error('A database error occurred');
}

if ($row['Email']==$email) {
    echo "var dump:<br>";
    var_dump($row);
    error('A user already exists with that email');
}

$sql = "INSERT INTO Customers (FirstName,LastName,Email,Password)
	VALUES ('$fname','$lname','$email','$pass')";

if (mysqli_query($link, $sql)) {
  echo "<script>
  alert('You have been successfully registered!');
  window.location.href='../index.php';
  </script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

mysqli_close($link);

?>