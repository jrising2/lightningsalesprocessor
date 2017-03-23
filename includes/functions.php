<?php

function productQuery($pid){
    $link = mysqli_connect('sql212.epizy.com', 'epiz_19723230', 'icebreaker', 'epiz_19723230_lightnsalesproc') 
        or die("Connection to database could not be established");
    $sql = "SELECT * FROM Products WHERE ProductID = $pid";
    $result = mysqli_query($link,$sql);
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

?>