<?php

include('tracking_funcs.php');

// A simple function to get the maximum number of roders with the given status. Used to calculate paginations.
function getMaxOrders($status = "Open"){
    if($status != "All"){
        $transactionNumbers = queryDB("TransactionID, Status","Transactions","Status = '".$status."' GROUP BY TransactionID",500);
    }else{
        $transactionNumbers = queryDB("TransactionID","Transactions","TRUE GROUP BY TransactionID",500);

    }
    return $transactionNumbers->num_rows;
}

// Outputs a row of a table with various order information.
function displayOrder($transID){
    $orderData = queryDB("*","Transactions","TransactionID = ".$transID);
    $orderData = $orderData->fetch_assoc();
    $row = '<tr><td><a href=orders.php?id='.$orderData['TransactionID'].'>'.$orderData['TransactionID'].'</a>'.
           '</td><td>'.$orderData['CustomerID'].
           '</td><td>'.$orderData['Status'].
           '</td><td>'.$orderData['DeliveryType'].'</td></tr>';

    echo $row;
}

// Displays the current page of orders in the main tab of orders.php
function displayPage($pageNumber, $stat = "Open", $displayCount = 20){
    $pageNumber = $pageNumber - 1;
    $startNumber = $pageNumber * $displayCount;
    $endNumber = ($pageNumber+1) * $displayCount;

    if($stat == "All"){
        $orders = queryDB("TransactionID","Transactions","TRUE GROUP BY TransactionID",$startNumber.','.$endNumber);
    }else{
        $orders = queryDB("TransactionID","Transactions","Status = '".$stat."' GROUP BY TransactionID",$startNumber.','.$endNumber);
    }

    echo '<table class="table table-condensed">';
    echo '<tr><th>TransactionID</th><th>CustomerID</th><th>Status</th><th>Delivery Type</th></tr>';
    foreach($orders as $singleorder){
        displayOrder($singleorder['TransactionID']);
    }
    echo '</table>';
}

// Displays the pagination at the bottom
function pageNumbers($status = "Open", $displayCount = 20){
    $max = getMaxOrders($status);
    $numberOfPages = ceil($max / $displayCount);
    if(isset($_GET['page'])){
        $currentPage = $_GET['page'];
    }else{
        $currentPage = 1;
    }

    for($i = 1; $i <= $numberOfPages; $i++){
        if($i >= 9) return true;
        if($i == $currentPage){
            echo '<li class="active"><a href="orders.php?page='.$i.'">'.$i.'</a></li>';
        }else{
            echo '<li><a href="orders.php?page='.$i.'">'.$i.'</a></li>';
        }
    }
}

// Displays the entire table with the employees and their current orders
function displayEmployeeOrders(){
    $employees = queryDB("EmployeeID, FirstName, LastName","Employees","TRUE");
    echo '<table class="table table-condensed">';
    echo '<tr><th>Employee</th><th>Current State</th><th>Current Order</th></tr>';

    foreach($employees as $currentEmployee){
        $currentOrder = queryDB("TransactionID, EmployeeID, Status","Transactions","Status = 'Assigned' AND EmployeeID = ".$currentEmployee['EmployeeID']);
        // If there was a result in the currentOrder query, then the employee must have an order otherwise display them as open
        if($currentOrder->num_rows){
            $currentOrder = $currentOrder->fetch_assoc();
            $row = '<tr><td>'.$currentEmployee['FirstName'].' '.$currentEmployee['LastName'].
                '</td><td>'.'Assigned'.
                '</td><td><a href="orders.php?id='.$currentOrder['TransactionID'].'">'.$currentOrder['TransactionID'].'</a>'.'</td></tr>';
        }else{
            $row = '<tr><td>'.$currentEmployee['FirstName'].' '.$currentEmployee['LastName'].
                '</td><td>'.'Open'.
                '</td><td></td></tr>';
        }
        echo $row;
    }
    echo '</table>';
}
