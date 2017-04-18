<?php

include('tracking_funcs.php');

function getMaxOrders($status = "Open"){
    if($status != "All"){
        $transactionNumbers = queryDB("TransactionID, Status","Transactions","Status = '".$status."' GROUP BY TransactionID",500);
    }else{
        $transactionNumbers = queryDB("TransactionID","Transactions","TRUE GROUP BY TransactionID",500);

    }
    return $transactionNumbers->num_rows;
//    $transactionNumbers = $transactionNumbers->fetch_all(MYSQLI_NUM);
//    $maxIndex = max(array_keys($transactionNumbers));
//    return $transactionNumbers[$maxIndex][0];
}

function displayOrder($transID){
    $orderData = queryDB("*","Transactions","TransactionID = ".$transID);
    $orderData = $orderData->fetch_assoc();
    $row = '<tr><td>'.$orderData['TransactionID'].
           '</td><td>'.$orderData['CustomerID'].
           '</td><td>'.$orderData['Status'].
           '</td><td>'.$orderData['DeliveryType'].'</td></tr>';

    echo $row;
}

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