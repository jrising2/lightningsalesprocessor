<?php
include_once "../includes/database.php";
include_once "../includes/functions.php";
session_start();

$email = mysqli_real_escape_string($link, $_POST['email']);

if ($_POST['email']=='') {
    error('One or more required fields were left blank.\\n'.
          'Please fill them in and try again.');
}

$sql = "SELECT * FROM Customers WHERE Email = '$email'";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_assoc($result);

if (!$result) {	
    error('A database error occurred');
}

if (mysqli_num_rows($result) == 0) {
  error("Your email is incorrect");	
}

$newpass = substr(md5(time()),0,6); // Generate random six character password
$pass = md5($newpass); // Hash generated password

$update = "UPDATE Customers SET Password = '$pass'
	WHERE Email = '$email'";

/*
// Uncomment this section to recieve real email with new password.
if (mysqli_query($link, $update)) {
    $msg = "Your new password:\n'$newpass'\nYou should change your password after you login";
    if(mail($email,"Book Store Password Reset",$msg)){
        echo "<script>
        alert('Email has been sent with your new password');
        window.location.href='../index.php';
        </script>";
    } else {
        error('Password reset failed. Please try again.');
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}
*/

// For testing with fake email or if you don't want to recieve email. Delete or comment this section if you want to receive real email.
if (mysqli_query($link, $update)) {
    $msg = "Password reset successfull!\\nYour new password is $newpass\\nYou should change your password after you login";
    echo "<script>
	alert('$msg');
	window.location.href='../index.php';
	</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

mysqli_close($link);

?>