<?php
	include "includes/database.php";
	global $link;
	$bid = $_POST['payment_delete'];
	$qryDeleteTransactions = "DELETE FROM Transactions WHERE BillingID={$bid}";
    if(mysqli_query($link, $qryDeleteTransactions)) {
	}else {
		//some unsuccesful code
		 header("Location: account.php?error=1");
	}
    $qryDeletePayment = "DELETE FROM Billing WHERE BillingID={$bid}";
	if(mysqli_query($link, $qryDeletePayment)) {
	}else {
		//some unsuccesful code
		 header("Location: account.php?error=1");
	}
	header("Location: account.php");	
?>