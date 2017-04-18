<!--PHP for Account Summary page -->
<?php
include_once "includes/database.php";
include_once "include/functions.php";
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
	$qryUserTransactions = "SELECT Transactions.ProductID, ProductName, ISBN, Description, Price, TransactionID, DeliveryType, Quantity, LineItemTotal, GrandTotal, `Timestamp`, `Status` FROM Products LEFT JOIN Transactions ON Products.ProductID=Transactions.ProductID WHERE CustomerID={$_SESSION['id']} ORDER BY Transactions.TransactionID DESC LIMIT 10";
	$qryPaymentInformation = "SELECT BillingID, NameOnCard, CardNumber, CardExpirationMonth, CardExpirationYear, BillingAddress1, BillingAddress2, City, State, ZipCode From Billing Where CustomerID={$_SESSION['id']}";
    //Querying
    $GLOBALS['account_summary_info'] = mysqli_query($link, $qryAccSummary);
	$GLOBALS['transactions_info'] = mysqli_query($link, $qryUserTransactions);
	$GLOBALS['payment_info'] = mysqli_query($link, $qryPaymentInformation);
}
function conditionAddress($add2) {
    //Small conditional for formatting purposes
    if ($add2 == "") {
        return "";
    } else {
        return "{$add2}<br>";
    }
}
function fillAccountSummary() {
	$row = mysqli_fetch_assoc($GLOBALS['account_summary_info']);
	$num_rows = mysqli_num_rows($GLOBALS['account_summary_info']);
    $Address2 = conditionAddress($row['Address2']); //if address 2 doesnt exist dont't break line
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
			<br>{$Address2}
			{$row['City']}, {$row['State']}, {$row['ZipCode']}
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
    				<div class="col-md-4"><span style="font-weight:bold;">#OrderID:</span><br>{$row['TransactionID']}</div>
                    <div class="col-md-4"><span style="font-weight:bold;">Delivery Method:</span><br>{$row['DeliveryType']}</div>
					<div class="col-md-4"><span style="font-weight:bold;">Date Ordered:</span><br>{$row['Timestamp']}</div>
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
					<div class="col-md-9" style="font-weight:bold">{$row['ProductName']}</div>
				</div>
    			<div class="row">
    				<div class="col-md-2"><a href="productpage.php?id={$row['ProductID']}"><img src="image/{$row['ISBN']}.jpg" alt="Insert Image here" width="100" height="100"/></a></div>
    				<div class="col-md-10">
    					<div class="row">
    						<div class ="col-md-2"><p><span style="font-weight:bold;">Price</span><br>$ {$row['Price']}</p></div>
    						<div class="col-md-2"> <p><span style="font-weight:bold;">Quantity</span><br>x{$row['Quantity']}</p></div>
    						<div class="col-md-2"> <p><span style="font-weight:bold;">Total</span><br>$ {$row['LineItemTotal']}</p></div>
    						<div class ="col-md-2"><p><span style="font-weight:bold;">Status</span><br>{$row['Status']}</p></div>
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
                    <div class ='col-md-12' style='text-align:right;font-weight:bold;'><p>Grand Total:$ {$row['GrandTotal']}</p></div>
                </div>
             </div>";
    	echo '</div>'; //closes panel
	}
    if ($num_rows == 0) {
        echo '<p>No Recent Transactions could be found</p>';
    }
}
?>
<script type="text/javascript">
function edit(item) {
    //Change the id of the selected button so that it can be seen in post
    var sub = document.getElementById("payment_" + item);
    sub.name ="payment";
    sub.id = "payment";
    //call submit on the form with the selected button
    document.getElementById("form_" + item).submit();

};
</script>
<?php
function fillPaymentInfo() {
	$num_rows = mysqli_num_rows($GLOBALS['payment_info']);
	for ($i = 0; $i < $num_rows; $i++) {
    	$row = mysqli_fetch_assoc($GLOBALS['payment_info']);
    	$cn = decrypt($row['CardNumber'], {$_SESSION['id']});
    	$size = strlen($cn);
    	$four_digits = str_split($cn, $size - 4);
        $BAddress2 = conditionAddress($row['BillingAddress2']);
    	$html = <<<EOD
    	<div class="panel panel-default">
    		<div class="panel-heading">
    			<div class="row">
    				<div class="col-md-4">{$row['NameOnCard']}</div>
    				<div class="col-md-6">Card ending in {$four_digits[1]}</div>
    				<div class="col-md-2">Expiration Date: {$row['CardExpirationMonth']}/{$row['CardExpirationYear']}</div>
    			</div>
    		</div>
    		<div class="panel-body">
    			Billing Address:
    			<br>{$row['BillingAddress1']}
    			<br>{$BAddress2}
    			{$row['City']}, {$row['State']}, {$row['ZipCode']}
				<form id="form_{$row['BillingID']}" action="delete_payment.php" method="POST">
                    <input type="hidden" id="payment_{$row['BillingID']}" value="{$row['BillingID']}"/>
                </form>
                <form id="form_{$row['BillingID']}" action="edit_payment.php" method="POST">
                    <input type="hidden" id="payment_{$row['BillingID']}" value="{$row['BillingID']}"/>
                </form>
				<button onClick="delete({$row['BillingID']})" type="button" class="btn btn-primary btn-md pull-right">Delete</button>
                <button onClick="edit({$row['BillingID']})" type="button" class="btn btn-primary btn-md pull-right">Edit</button>
            </div>
    	</div>
EOD;
        echo $html;
    }

    if ($num_rows == 0) {
        echo '<p>No payment information was found in our records.</p>';
    }

    echo '<a href="edit_payment.php"><button type="button" class="btn btn-primary btn-md pull-right">Add</button></a>';

}

?> 