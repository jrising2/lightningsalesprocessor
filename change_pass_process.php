<?php

include_once "includes/database.php";
session_start();

global $link;
$qry = "SELECT Password FROM Customers WHERE CustomerID= {$_SESSION['id']}";
$result = mysqli_query($link, $qry);
$row = mysqli_fetch_assoc($result);
$currentpass = md5($_POST['currentpass']);
$newpass = $_POST['newpass'];
$newpass2 = $_POST['newpass2'];
$dbpass = $row['Password'];

//Test to see if the passwords are matching
if ($dbpass == $currentpass) {
    if ($newpass == $newpass2) {
        //succesfull password change
        $updatepass = $link->real_escape_string($newpass);
<<<<<<< HEAD
        $updatepass = md5($updatepass); // hash password
        $changepass = "UPDATE Customers SET Password = '{$updatepass}' WHERE CustomerID= {$_SESSION['id']}";
=======
        $changepass = "UPDATE Customers SET Password = '{$updatepass}' WHERE CustomerID={$_SESSION['id']}";
>>>>>>> origin/master
        mysqli_query($link, $changepass);
        header("Location: account.php");
    } else {
        //unsuccesful password change
        header("Location: change_pass.php?error=1");
        //for now just redirects back to change password page
        //later may regenerate the code for the change password page with some sort of bolded indication instead of a javascript message
    }
}else {
     header("Location: change_pass.php?error=1");
}



?>