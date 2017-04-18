<?php
include_once "includes/database.php";
include_once "includes/validation.php";
session_start();

//this form still needs a lot of error checking/validation
global $link;
$fname = $link->real_escape_string($_POST['fname']);
$lname = $link->real_escape_string($_POST['lname']);
$email = $link->real_escape_string($_POST['email']);
$add1 = $link->real_escape_string($_POST['add1']);
$add2 = $link->real_escape_string($_POST['add2']);
$state = $_POST['state'];
$city = $link->real_escape_string($_POST['city']);
$zip = $link->real_escape_string($_POST['zip']);

if (validateName($fname) == false) {
    header("Location: edit_info.php?error=1"); //illegal characters in first name
    exit();
}
if (validateName($lname) == false) {
    header("Location: edit_info.php?error=2"); //illegal characters in last name
    exit();
}
if (validateEmail($email) == false) {
    header("Location: edit_info.php?error=3"); //invalid email
    exit();
}
if (validateAddress($add1, $add2, $city, $state, $zip) == false) {
    header("Location: edit_info.php?error=4");  //invalid address
    exit();
}

//may have some redundancy checks if information is unchanged on commit (right now database isnt updated to represent phone and country)
$updatecustomer = "UPDATE Customers SET FirstName='{$fname}', LastName='{$lname}', Email='{$email}', Address1='{$add1}', Address2='{$add2}', State='{$state}', City='{$city}', ZipCode='{$zip}' WHERE CustomerID={$_SESSION['id']}";
if (mysqli_query($link, $updatecustomer)) {
    //successful entry
    header("Location: account.php");
    exit();
}  else {
    //do some code for unsuccessful entry
    echo $updatecustomer;
    //echo $updatecustomer;
    header("Location: edit_info.php?error=5");
    exit();
}


//unsuccesful commit some validation errors (will add validation later)

?>