<?php
include_once "includes/database.php";

//this form still needs a lot of error checking/validation
global $link;
$fname = $link->real_escape_string($_POST['fname']);
$lname = $link->real_escape_string($_POST['lname']);
$email = $link->real_escape_string($_POST['email']);
$add1 = $link->real_escape_string($_POST['add1']);
$add2 = $link->real_escape_string($_POST['add2']);
$state = $link->real_escape_string($_POST['state']);
$city = $link->real_escape_string($_POST['city']);
$zip = $link->real_escape_string($_POST['zip']);
//$phone = $POST['phone'];
//$country = $POST['country'];

//validate all the edits here
$nameValidation = '[\d\s!@#$%^&*()_-+={}\[\]\|\\;:\'"<>,.?/`~]*'; //Negative matcher for not being digit, whitespace, or special characters
if (preg_match($fname, $nameValidation) == true) {
    header("Location: Edit Info Page.php"); //invalid fname return to edit page
}
if (preg_match($lname, $nameValidation) == true) {
    header("Location: Edit Info Page.php"); //invalid lname return to edit page
}
$emailValidation = '[A-Za-z0-9]+@{1}[A-Za-z]{2,}.?[A-Za-z]*'; //assuming only english domains
if (filter_var($email, FILTER_VALIDATE_EMAIL) != true) {
    header("Location: Edit Info Page.php"); //invalid email return to edit page
}
//to validate address will probably request from the google api


//may have some redundancy checks if information is unchanged on commit (right now database isnt updated to represent phone and country)
$updatecustomer = "UPDATE customers SET FirstName = '{$fname}', LastName = '{$lname}', Email = '{$email}', Address1 = '{$add1}', Address2 = '{$add2}', State = '{$state}', City = '{$city}', ZipCode = '{$zip}' WHERE CustomerID={$_SESSION['id']}";
if (mysqli_query($link, $updatecustomer)) {
    //successful entry
    header("Location: account.php");
}  else {
    //do some code for unsuccessful entry
}


//unsuccesful commit some validation errors (will add validation later)

?>