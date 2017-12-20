<?php
$directory = getRootDirectory();
ini_set('include_path', $directory);

include "config/database.php";
$GLOBALS['dbhost'] = $dbhost;
$GLOBALS['dbuser'] = $dbuser;
$GLOBALS['dbpass'] = $dbpass;
$GLOBALS['dbname'] = $dbname;

// Opens a connection to the database, sends out a query and closes the connection
function queryDB($select,$table,$where,$limit=20){
    $link = new mysqli($GLOBALS['dbhost'],$GLOBALS['dbuser'],$GLOBALS['dbpass'],$GLOBALS['dbname']);
    $query = "SELECT ".$select." FROM ".$table." WHERE ".$where." LIMIT ".$limit;
    $result = $link->query($query);
    $link->close();

    if(isset($result->connect_errno)){
        return NULL;
    }else{
        return $result;
    }
}

function modifyTransaction($transID,$column,$value){
    $link = new mysqli($GLOBALS['dbhost'],$GLOBALS['dbuser'],$GLOBALS['dbpass'],$GLOBALS['dbname']);
    $query = "UPDATE Transactions SET ".$column." = ".$value." WHERE TransactionID = ".$transID;
    $result = $link->query($query);
    $link->close();

    if(!$result){
        echo 'Error modifying transaction';
    }
}

// Grabs a job for a given employee. Sets the employeeID in the Database
function getNextJob($employeeID){
    // Find all the transactions that haven't been assigned and grab the first row into an array
    $availableTransactions = queryDB("TransactionID","Transactions","isnull(EmployeeID) GROUP BY TransactionID");
    if($availableTransactions){
        $transRow = $availableTransactions->fetch_assoc();
        modifyTransaction($transRow["TransactionID"],"EmployeeID",$employeeID);
        modifyTransaction($transRow["TransactionID"],"Status","'Assigned'");

        // Use that TransactionID to grab all the information for that transaction, then return all that info.
        $job = queryDB("*","Transactions","TransactionID = ".$transRow["TransactionID"]);
        return $job;
    }else{
        return FALSE;
    }
}

function allAvailableJobs(){
    $available = queryDB("TransactionID,CustomerID,Status,DeliveryType,GrandTotal","Transactions","isnull(EmployeeID) GROUP BY TransactionID,CustomerID,Status,DeliveryType,GrandTotal");
    $rows = array();
    while($row = $available->fetch_array()){
        $rows[] = $row;
    }
    return $rows;
}

function getCurrentJob($employeeID){
    $assigned = queryDB("*","Transactions","EmployeeID=".$employeeID." AND Status = 'Assigned'");
    return $assigned;
}

function getJobHistory($employeeID){
    $history = queryDB("TransactionID,CustomerID,Status,DeliveryType,GrandTotal","Transactions","EmployeeID = ".$employeeID." AND Status = 'Closed' GROUP BY TransactionID,CustomerID,Status,DeliveryType,GrandTotal");
    $rows = array();
    while($row = $history->fetch_array()){
        $rows[] = $row;
    }
    return $rows;
}

function getStatus($transID){
    $select = '<select id="status" name="status">';
    $current = queryDB("Status","Transactions","TransactionID=".$transID." GROUP BY Status");
    $status = $current->fetch_assoc();

    if($status['Status'] == 'Open'){
        $select = $select.'<option value="open" selected>Open</option>
                    <option value="assigned">Assigned</option>
                    <option value="closed">Closed</option>
                    </select>';
    }else if($status['Status'] == 'Assigned'){
        $select = $select.'<option value="open" selected>Open</option>
                    <option value="assigned" selected>Assigned</option>
                    <option value="closed">Closed</option>
                    </select>';
    }else{
        $select = $select.'<option value="open">Open</option>
                    <option value="assigned">Assigned</option>
                    <option value="closed" selected>Closed</option>
                    </select>';
    }

    echo $select;
}

function getTotalQuant($resultObject){
    $rows = $resultObject->fetch_all();

    $total = 0;
    foreach($rows as $singleRow){
        print_r($singleRow);
        $total += $singleRow[3];
    }
    return $total;
}

function getRootDirectory(){
    $directory = __DIR__;
    $pos = strpos($directory,"/emp/php");
    $result = substr_replace($directory,"",$pos,8);
    return $result;
}

function printAllInformation($transactionID){
    if(!isset($transactionID)) return false; // Exits function if there is no transactionID

    $transaction = queryDB("*","Transactions","TransactionID = ".$transactionID['TransactionID']);
    $customerID = $transaction->fetch_assoc()['CustomerID'];
    $customer = queryDB("*","Customers","CustomerID = ".$customerID);
    $customer = $customer->fetch_assoc();
    if(isset($customer['Address2']) && !empty($customer['Address2'])){
        $customer['Address2'] = $customer['Address2'].'<br>';
    }

    $result = '<div class="row bs-callout bs-callout-info" style="border-color: darkgreen;">'.
              '<div class="col-sm-3"><p><strong>First Name</strong><br>'.$customer['FirstName'].'</p></div>'.
              '<div class="col-sm-3"><p><strong>Last Name</strong><br>'.$customer['LastName'].'</p></div>'.
              '<div class="col-sm-3"><p><strong>Email</strong><br>'.$customer['Email'].'</p></div>'.
              '<div class="col-sm-3"><p><strong>Address</strong><br>'.$customer['Address1'].'<br>'.$customer['Address2'].$customer['City'].', '.$customer['State'].'<br>'.$customer['ZipCode'].'</p></div>'.
              '</div>';

    echo $result;
    echo '<div class="row bs-callout bs-callout-info" style="border-color: black;">';

    foreach($transaction as $singleTrans){
        $productInfo = queryDB("ProductID, ProductName, Genre, ISBN, Description","Products","ProductID = ".$singleTrans['ProductID']);
        $productInfo = $productInfo->fetch_assoc();
        $printout = <<<EOD
            <div class="row" style="margin-top: 1em;">
				<div class="col-md-2"><a href="Link to Product in image"><img src="../image/{$productInfo['ISBN']}.jpg" alt="Insert Image here" width="100" height="100"/></a></div>
				<div class="col-md-10">
					<div class="row">
					    <div class ="col-md-5"><p><strong>Book Name</strong><br>{$productInfo['ProductName']}</p></div>
					    <div class ="col-md-3"><p><strong>ISBN</strong><br>{$productInfo['ISBN']}</p></div>
						<div class="col-md-2"> <p><strong>Quantity</strong><br>{$singleTrans['Quantity']}</p></div>
						<div class ="col-md-2"><p><strong>Line Total</strong><br>$ {$singleTrans['LineItemTotal']}</p></div>
					</div>
					<div class="row">
						<div class="col-md-12"> <pre>{$productInfo['Description']}</pre></div>
					</div>
				</div>
			</div> 
EOD;
        echo $printout;
    }

    echo '</div>';
}