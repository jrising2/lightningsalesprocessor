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

