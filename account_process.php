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
	$qryUserTransactions = "SELECT ProductName, ISBN, Description, Price, TransactionID, Quantity, Status, LineItemTotal, GrandTotal, `Timestamp`, `Status` FROM Products LEFT JOIN Transactions ON Products.ProductID=Transactions.ProductID WHERE CustomerID={$_SESSION['id']} ORDER BY Transactions.TransactionID DESC LIMIT 10";
	$qryPaymentInformation = "SELECT TransactionID, NameOnCard, CardNumber, CardExpirationMonth, CardExpirationYear, BillingAddress1, BillingAddress2, City, State, Zip From Billing Where CustomerID={$_SESSION['id']}";

    //Querying
    $GLOBALS['account_summary_info'] = mysqli_query($link, $qryAccSummary);
	$GLOBALS['transactions_info'] = mysqli_query($link, $qryUserTransactions);
	$GLOBALS['payment_info'] = mysqli_query($link, $qryPaymentInformation);
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
			<br>{$row['State']}, {$row['City']}, {$row['ZipCode']}
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
        //Print out the panel header for a single order
        $html = <<<EOD
    	<div class="panel panel-default">
    		<div class="panel-heading">
    			<div class="row">
    				<div class="col-md-9"><style="font-weight:bold">{$row['ProductName']}</style></div>
    				<div class="col-md-3 text-right">#OrderID: {$row['TransactionID']}<br>{$row['Timestamp']}</div>
    			</div>
    		</div>
EOD;
        echo $html;
    	$previousID = $row['TransactionID'];
    	$currentID = $row['TransactionID'];
        //Print out all the items in a single transaction
    	while ($previousID == $currentID) {
    		$html = <<<EOD
            <div class="panel-body">
    			<div class="row">
    				<div class="col-md-2"><a href="Link to Product in image"><img src="image/{$row['ISBN']}.jpg" alt="Insert Image here" width="100" height="100"/></a></div>
    				<div class="col-md-10">
    					<div class="row">
    						<div class ="col-md-2"><p>Price<br>$ {$row['Price']}</p></div>
    						<div class="col-md-2"> <p>Quantity<br>x{$row['Quantity']}</p></div>
    						<div class="col-md-2"> <p>Total<br>$ {$row['LineItemTotal']}</p></div>
    						<div class ="col-md-2"><p>Status<br>{$row['Status']}</p></div>
    					</div>
    					<div class="row">
    						<div class="col-md-8"> <pre>{$row['Description']}</pre></div>
    					</div>
    				</div>
    			</div>
    		</div>
EOD;
            echo ($html);
            $i++;
            if ($i == $num_rows) break;
    	    $previousID = $currentID;
    	    $row = mysqli_fetch_assoc($GLOBALS['transactions_info']);
    	    $currentID = $row['TransactionID'];
    	}
        //final echo for grand total
        echo "<div class='panel-body'>
                <div class='row'>
                    <div class ='col-md-12' style='text-align:right;'><p>Grand Total:$ {$row['GrandTotal']}</p></div>
                </div>
             </div>";
    	echo '</div>'; //closes panel
	}
    if ($num_rows == 0) {
        echo '<p>No Recent Transactions could be found</p>';
    }
}

function fillPaymentInfo() {
	$num_rows = mysqli_num_rows($GLOBALS['payment_info']);
	for ($i = 0; $i < $num_rows; $i++) {
    	$row = mysqli_fetch_assoc($GLOBALS['payment_info']);
    	$cn = $row['CardNumber'];
    	$size = strlen($cn);
    	$four_digits = str_split($cn, $size - 4);

    	$html = <<<EOD
    	<div class="panel panel-default">
    		<div class="panel-heading">
    			<div class="row">
    				<div class="col-md-4">{$row['NameOnCard']}</div>
    				<div class="col-md-6">{$four_digits}</div>
    				<div class="col-md-2">{$row['CardExpirationMonth']}/{$row['CardExpirationYear']}</div>
    			</div>
    		</div>
    		<div class="panel-body">
    			Billing Address:
    			<br>{$row['BillingAddress1']}
    			<br>{$row['BillingAddress2']}
    			<br>{$row['City']}, {$row['State']}, {$row['ZipCode']}
    		</div>
    	</div>
EOD;
        echo $html;
    }

    if ($num_rows == 0) {
        echo '<p>No payment information was found in our records.</p>';
    }
}

?> 