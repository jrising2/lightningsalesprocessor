<?php
include_once "includes/database.php";
include_once "includes/validation.php";
include_once "includes/functions.php";
session_start();

//this form still needs a lot of error checking/validation
global $link;
$nameoncard = $link->real_escape_string($_POST['nameoncard']);
$cardnum = encrypt($_POST['cardnumber'], $_SESSION['id']);
$month = $link->real_escape_string($_POST['month']);
$year = $link->real_escape_string($_POST['year']);
$add1 = $link->real_escape_string($_POST['add1']);
$add2 = $link->real_escape_string($_POST['add2']);
$state = $_POST['state'];
$city = $link->real_escape_string($_POST['city']);
$zip = $link->real_escape_string($_POST['zip']);
$bid = $_POST['bid'];

echo '<form id="return" action="edit_payment.php?" method="POST">
        <input type="hidden" id="payment" value="{$bid}"/>
        <input type="hidden" id="error" value="" />
    </form>';

if ($bid == "") {
    $addbilling = "INSERT INTO Billing(CustomerID, NameOnCard, CardNumber, CardExpirationMonth, CardExpirationYear, BillingAddress1, BillingAddress2, State, City, ZipCode) VALUES({$_SESSION['id']},'{$nameoncard}', '{$cardnum}', {$month}, {$year}, '{$add1}', '{$add2}', '{$state}', '{$city}', '{$zip}')";
    echo $addbilling;
	if (mysqli_query($link, $addbilling)) {
        //successful entry
        header("Location: account.php");
    } else {
        //do some code for unsuccessful entry
		echo "wtf";
    }
}else {
    $updatebilling = "UPDATE Billing SET NameOnCard='{$nameoncard}', CardNumber='{$cardnum}', CardExpirationMonth={$month}, CardExpirationYear={$year}, BillingAddress1='{$add1}', BillingAddress2='{$add2}', State='{$state}', City='{$city}', ZipCode='{$zip}' WHERE BillingID={$bid}";
    if (mysqli_query($link, $updatebilling)) {
        //successful entry
        header("Location: account.php");
    } else {
        //do some code for unsuccessful entry
    }
}
?>