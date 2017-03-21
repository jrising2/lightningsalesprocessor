<?php

include_once "config/database.php";
$account_info;

function loadFormInformation() {
    global $link;
    //Will probably do more here like redundant information checks but for now a simple isnert
    $qryAccountInfo = "INSERT INTO Customers (FirstName,LastName,Address1,Address2,City,State,ZipCode,Email) VALUES () WHERE CustomerID=" . $_SESSION['id'];
    $GLOBALS['account_info'] = mysqli_query($link, $qryAccountInfo);
}

?>