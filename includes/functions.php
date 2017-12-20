<?php

$dblink = mysqli_connect('sql212.epizy.com', 'epiz_19723230', 'icebreaker', 'epiz_19723230_lightnsalesproc') or die ("Connection to database could not be established");

function customerQuery($cid){
    global $dblink;
    $sql = "SELECT * FROM Customers WHERE CustomerID = $cid";
    $result = mysqli_query($dblink,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function billingQuery($bid){
    global $dblink;
    $sql = "SELECT * FROM Billing WHERE BillingID = $bid";
    $result = mysqli_query($dblink,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function customerCards($cid){
    global $dblink;
    $sql = "SELECT * FROM Billing WHERE CustomerID = $cid";
    $result = mysqli_query($dblink,$sql);
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function productQuery($pid){
    global $dblink;
    $sql = "SELECT * FROM Products WHERE ProductID = $pid";
    $result = mysqli_query($dblink,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function displayTitle($pid){
    $row = productQuery($pid);
    echo $row['ProductName'];
}

function displayImage($pid){
    $row = productQuery($pid);
    echo "image/".$row['ISBN'].".jpg";
}

function displayPrice($pid){
    $row = productQuery($pid);
    echo "$".$row['Price'];
}

function error($msg) {
    echo "
    <html>
    <head>
    <script language='JavaScript'>
    
        alert('$msg');
        history.back();
    
    </script>
    </head>
    <body>
    </body>
    </html>
    ";
    exit;
}

function updateStock($pid,$quantity){
    $query = productQuery($pid);
    $stock = $query['Stock'] - $quantity;
    global $dblink;
    $newStock = 
    $sql = "UPDATE Products SET Stock = '$stock' WHERE ProductID = '$pid'";
    $result = mysqli_query($dblink,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row;
}

function encrypt($data,$cid){
    $method = "aes-128-cbc";
    $key = substr(md5($cid),0,16);
    $iv = substr(md5($cid),-16);
    $encryption = openssl_encrypt($data, $method, $key, 0, $iv);
    return $encryption;
}

function decrypt($data,$cid){
    $method = "aes-128-cbc";
    $key = substr(md5($cid),0,16);
    $iv = substr(md5($cid),-16);
    $decryption = openssl_decrypt($data, $method, $key, 0, $iv);
    return $decryption;
}

function checkCardExist($cid){
    $row = customerCards($cid);
    if($row==false){
        error("You must add a credit card to your acccount to place on online order");
    }
}

function checkShippingExist($cid){
    $row = customerQuery($cid);
    if($_POST["delivery"]=="Shipping" && ($row["Address1"]=="" || $row["City"]=="" || $row["State"]=="" || $row["ZipCode"]=="")){
        error("You must add a shipping address to your account to place a shipping order");
    }
}

function maxpid(){
    global $dblink;
    $sql = "SELECT MAX(ProductID) AS max FROM Products";
    $result = mysqli_query($dblink,$sql);
    $row = mysqli_fetch_assoc($result);
    return $row["max"];
}

?>