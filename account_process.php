<!--PHP for Account Summary page -->
<?php
include_once "includes/database.php";
include_once "includes/functions.php";
if (session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}

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
	$qryUserTransactions = "SELECT GROUP_CONCAT(Transactions.ProductID), GROUP_CONCAT(ProductName), GROUP_CONCAT(ISBN), GROUP_CONCAT(Description), GROUP_CONCAT(Price), GROUP_CONCAT(TransactionID), DeliveryType, GROUP_CONCAT(Quantity), GROUP_CONCAT(LineItemTotal), GrandTotal, `Timestamp`, `Status` FROM Transactions LEFT JOIN Products ON Transactions.ProductID=Products.ProductID WHERE CustomerID={$_SESSION['id']} GROUP BY TransactionID DESC LIMIT 5";
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
	$rows = mysqli_fetch_all($GLOBALS['transactions_info'], MYSQLI_BOTH);
	for ($i = 0; $i < $num_rows; $i++) {
		$row = $rows[$i];
		$transaction_ids = explode(",", $row['GROUP_CONCAT(TransactionID)']);
        //Print out the panel header for a single order
        $html = <<<EOD
    	<div class="panel panel-default">
    		<div class="panel-heading">
    			<div class="row">
    				<div class="col-md-4"><span style="font-weight:bold;">#OrderID:</span><br>{$transaction_ids[0]}</div>
                    <div class="col-md-4"><span style="font-weight:bold;">Delivery Method:</span><br>{$row['DeliveryType']}</div>
					<div class="col-md-4"><span style="font-weight:bold;">Date Ordered:</span><br>{$row['Timestamp']}</div>
    			</div>
    		</div>
EOD;
        echo $html;

        //Print out all the items in a single transaction
		$num_items = count($transaction_ids);
		$product_ids = explode(",", $row['GROUP_CONCAT(Transactions.ProductID)']);
		$product_names = explode(",", $row['GROUP_CONCAT(ProductName)']);
		$isbns = explode(",", $row['GROUP_CONCAT(ISBN)']);
		$prices = explode(",", $row['GROUP_CONCAT(Price)']);
		$quantities = explode(",", $row['GROUP_CONCAT(Quantity)']);
		$line_totals = explode(",", $row['GROUP_CONCAT(LineItemTotal)']);
		$descriptions = explode(",", $row['GROUP_CONCAT(Description)']);
    	for ($j = 0; $j < $num_items; $j++) {
    		$html = <<<EOD
            <div class="panel-body">
				<div class="row">
					<div class="col-md-9" style="font-weight:bold">{$product_names[$j]}</div>
				</div>
    			<div class="row">
    				<div class="col-md-2"><a href="productpage.php?id={$product_ids[$j]}"><img src="image/{$isbns[$j]}.jpg" alt="Insert Image here" width="100" height="100"/></a></div>
    				<div class="col-md-10">
    					<div class="row">
    						<div class ="col-md-2"><p><span style="font-weight:bold;">Price</span><br>$ {$prices[$j]}</p></div>
    						<div class="col-md-2"> <p><span style="font-weight:bold;">Quantity</span><br>x{$quantities[$j]}</p></div>
    						<div class="col-md-2"> <p><span style="font-weight:bold;">Total</span><br>$ {$line_totals[$j]}</p></div>
    						<div class ="col-md-2"><p><span style="font-weight:bold;">Status</span><br>{$row['Status']}</p></div>
    					</div>
    					<div class="row">
    						<div class="col-md-8"> <pre>{$descriptions[$j]}</pre></div>
    					</div>
    				</div>
    			</div>
    		</div>
EOD;
            echo ($html);
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
	console.log("something happens")
    //Change the id of the selected button so that it can be seen in post
    var sub = document.getElementById("payment_edit_" + item);
    sub.name ="payment_edit";
    sub.id = "payment_edit";
    //call submit on the form with the selected button
    document.getElementById("form_edit_" + item).submit();

};
function delete_it(item) {
	var txt;
	var r = confirm("Continue with the delete");
	if (r == true) {
		//Change the id of the selected button so that it can be seen in post
		var del = document.getElementById("payment_delete_" + item);
		del.name ="payment_delete";
		del.id = "payment_delete";
		//call submit on the form with the selected button
		document.getElementById("form_delete_" + item).submit();
	} else {
		
	}
}
</script>
<?php
function fillPaymentInfo() {
	$num_rows = mysqli_num_rows($GLOBALS['payment_info']);
	for ($i = 0; $i < $num_rows; $i++) {
    	$row = mysqli_fetch_assoc($GLOBALS['payment_info']);
    	$cn = decrypt($row['CardNumber'], $_SESSION['id']);
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
				<form id="form_edit_{$row['BillingID']}" action="edit_payment.php" method="POST">
                    <input type="hidden" id="payment_edit_{$row['BillingID']}" value="{$row['BillingID']}"/>
                </form>
                <form id="form_delete_{$row['BillingID']}" action="delete_payment.php" method="POST">
                    <input type="hidden" id="payment_delete_{$row['BillingID']}" value="{$row['BillingID']}"/>
                </form>
				<div class="btn-group pull-right">
					<button onClick="delete_it({$row['BillingID']})" type="button" class="btn btn-primary">Delete</button>
					<button onClick="edit({$row['BillingID']})" type="button" class="btn btn-primary">Edit</button>
				</div>
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