<!--PHP for Account Summary page -->
<?php
include_once "includes/database.php";
session_start();

//global variables
$account_summary_info;
$transactions_info;
$payment_info;
$successful_query = false;

//Loads information for all tabs in the Account PAge
function loadInformation() {
    global $link;
	//Queries to be called
	$qryAccSummary = "SELECT FirstName, LastName, Address1, Address2, City, State, ZipCode, Email FROM Customers WHERE CustomerID={$_SESSION['id']}";
	$qryUserTransactions = "SELECT 'Product Name', Description, Price, TransactionID, `Timestamp`, `Status` FROM Products LEFT JOIN Transactions ON Products.ProductID=Transactions.ProductID WHERE CustomerID={$_SESSION['id']} ORDER BY Transactions.Timestamp DESC LIMIT 10";
	//$qryPaymentInformation = "";

    //Querying
    $GLOBALS['account_summary_info'] = mysqli_query($link, $qryAccSummary);
	$GLOBALS['transactions_info'] = mysqli_query($link, $qryUserTransactions);
	//$GLOBALS['$payment_info'] = mysqli_query($link, $qryPaymentInformation);
}
function conditionAddress($Address2) {
    //Small conditional for formatting purposes
    if ($Address2 == "") {
        return "";
    } else {
        return "{$row['Address']}<br>";
    }
}
function fillAccountSummary() {
	$row = mysqli_fetch_assoc($GLOBALS['account_summary_info']);
	$num_rows = mysqli_num_rows($GLOBALS['account_summary_info']);
    $Address2 = conditionAddress($row['Address']);
	$html = <<<EOD
    <table class="table table-bordered">
	<tbody>
		<tr>
			<th scope="row">Name</th>
			<td>{$row['FirstName']} {$row['LastName']}</td>
		</tr>
		<tr>
			<th scope="row">Email</th>
			<td>{$row['Email']}</td>
		</tr>
		<tr>
			<th scope="row">Phone Number</th>
			<td>{$row['PhoneNumber']}</td>
		</tr>
		<tr>
			<th scope="row">Shipping Address</th>
		<td>
			{$row['Address1']}
			<br>{${$Address2}}
			{$row['State']}, {$row['City']}, {$row['ZipCode']}
			<br>Insert Country
		</td>
		</tr>
	</tbody>
	</table>
EOD;
        echo($html);
}

function fillTransactions() {
    $num_rows = mysqli_num_rows($GLOBALS['transactions_info']);
	for ($i = 0; $i < $num_rows; $i++) {
	$row = mysqli_fetch_assoc($GLOBALS['transactions_info']);
	$html = <<<EOD
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-6"><style="font-weight:bold">{$row['Product Name']}</style></div>
				<div class="col-md-6 text-right">#OrderID: {$row['TransactionID']}<br>{$row['Timestamp']}</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2"><a href="Link to Product in image"><img src="placeholder.jpg" alt="Insert Image here" width="100" height="100"/></a></div>
				<div class="col-md-10">
					<div class="row">
						<div class ="col-md-2"><p>Price<br>$ {$row['Price']}</p></div>
						<div class="col-md-2"> <p>Quantity<br>xX</p></div>
						<div class="col-md-2"> <p>Total<br>$X.XX</p></div>
						<div class ="col-md-2"><p>Status<br>{$row['Status']}</p></div>
					</div>
					<div class="row">
						<div class="col-md-12"> <pre>{$row['Description']}</pre></div>
					</div>
				</div>
			</div>
		</div>
	</div>
EOD;
        echo($html);
	}
    if ($num_rows == 0) {
        echo '<p>No Recent Transactions could be found</p>';
    }
}

function fillPaymentInfo() {
	$num_rows = mysqli_num_rows($GLOBALS['transactions_info']);
	//for ($i = 0; $i < $num_rows; $i++) {
	//$row = mysqli_fetch_assoc($GLOBALS['transactions_info']);
	$html = <<<EOD
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-4">Name on the card</div>
				<div class="col-md-6">Card Number</div>
				<div class="col-md-2">Expiration Date</div>
			</div>
		</div>
		<div class="panel-body">
			Billing Address Name
			<br>Billing Address Line 1
			<br>Billing Address Line 2
			<br>State, City, ZIP
			<br>Country
			<br>Phone number (XXX-XXX-XXXX)
		</div>
	</div>
EOD;
   if ($num_rows == 0) {
        echo '<p>No payment information was found in our records.</p>';
    }
}

?> 