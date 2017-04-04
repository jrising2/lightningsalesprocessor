<?php

include_once "includes/database.php";
session_start();

global $link;
$qry = "SELECT Password FROM Customers WHERE CustomerID= {$_SESSION['id']}";
$result = mysqli_query($link, $qry);
$row = mysqli_fetch_assoc($result);
$currentpass = $_POST['currentpass'];
$newpass = $_POST['newpass'];
$newpass2 = $_POST['newpass2'];
$dbpass = $row['Password'];

//Test to see if the passwords are matching
if ($dbpass == $currentpass) {
    if ($newpass == $newpass2) {
        //succesfull password change
        $changepass = "UPDATE Customers SET Password = {$newpass} WHERE CustomerID= {$_SESSION['id']}";
        mysqli_query($link, $changepass);
        header("Location: ./account.php");
    } else {
        //unsuccesful password change
        header("Location: Change Pass Page.php");
        $message = "The passwords did not match!";
        echo "<script type='text/javascript'>alert('$message');</script>";
        exit();
        //for now just redirects back to change password page
        //later may regenerate the code for the change password page with some sort of bolded indication instead of a javascript message
    }
}else {
     header("Location: Change Pass Page.php");
     $message = "The passwords did not match!";
     echo "<script type='text/javascript'>alert('$message');</script>";
     exit();
}



?>