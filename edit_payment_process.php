<?php
include_once "includes/database.php";

//this form still needs a lot of error checking/validation
global $link;
$nameoncard = $link->real_escape_string($_POST['nameoncard']);
$cardnum = $link->real_escape_string($_POST['cardnumber']);
$month = $link->real_escape_string($_POST['month']);
$year = $link->real_escape_string($_POST['year']);
$add1 = $link->real_escape_string($_POST['add1']);
$add2 = $link->real_escape_string($_POST['add2']);
$state = $link->real_escape_string($_POST['state']);
$city = $link->real_escape_string($_POST['city']);
$zip = $link->real_escape_string($_POST['zip']);
$bid = $_POST['bid'];

//validate all the edits here //May or may not fix validation due to time constraints

$_SESSION['id'] = 1;
echo $bid;

if ($bid == "") {
    $addbilling = "INSERT INTO Billing(CustomerID, NameOnCard, CardNumber, CardExpirationMonth, CardExpirationYear, BillingAddress1, BillingAddress2, State, City, ZipCode) VALUES({$_SESSION['id']},'{$nameoncard}', '{$cardnum}', {$month}, {$year}, '{$add1}', '{$add2}', '{$state}', '{$city}', '{$zip}')";
    echo $addbilling;
    if (mysqli_query($link, $addbilling)) {
        //successful entry
        header("Location: account.php");
    } else {
        //do some code for unsuccessful entry
        //header("Location: edit_payment.php?payment={$bid}&error=1");
    }
}else {
    $updatebilling = "UPDATE Billing SET NameOnCard='{$nameoncard}', CardNumber='{$cardnum}', CardExpirationMonth={$month}, CardExpirationYear={$year}, BillingAddress1='{$add1}', BillingAddress2='{$add2}', State='{$state}', City='{$city}', ZipCode='{$zip}' WHERE BillingID={$bid}";
    echo $updatebilling;
    if (mysqli_query($link, $updatebilling)) {
        //successful entry
        header("Location: account.php");
    } else {
        //do some code for unsuccessful entry
        header("Location: edit_payment.php?payment={$bid}&error=2");
    }
}

//unsuccesful commit some validation errors (will add validation later)

?>