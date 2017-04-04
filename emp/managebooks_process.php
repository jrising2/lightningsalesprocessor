<?php
require("includes/database.php");

//Edits a record or adds a record to the database
function edit_add() {
    global $link;
    $pid = $link->real_escape_string($_POST['prodid']);
    $pname = $link->real_escape_string($_POST['title']);
    $isbn = $link->real_escape_string($_POST['isbn']);
    $stock = $link->real_escape_string($_POST['stock']);

    if (($_POST['prodid'] == "") || ($pid == "")) {
        header("Location: managebooks.php?product=&error=4");
    }

    $qry;
    //check if the product exist in the database already
    $result = mysqli_query($link, "SELECT ProductID FROM Products WHERE ProductID={$pid}");
    echo mysqli_num_rows($result);
    if(mysqli_num_rows($result) > 0) {
        $qry = "UPDATE Products SET ProductID = {$pid}, ProductName = '{$pname}', ISBN = '{$isbn}', Stock = {$stock} WHERE ProductID={$pid}";
    }else {
        $qry = "INSERT INTO Products(ProductID, ProductName, ISBN, Stock) VALUES ({$pid}, '{$pname}', '{$isbn}', {$stock})";
    }
    echo $qry;
    //execute either an update or an insert depending on above result
    if (mysqli_query($link, $qry)) {
        //successful insert
        if (mysqli_num_rows($result) > 0) {
            //succesful update
            header("Location: managebooks.php?product={$pid}&redirect_success=1");
        }else {
            //succesful insert
            header("Location: managebooks.php?product={$pid}&redirect_success=2");
        }
    }  else {
        //do some code for unsuccessful insert
        header("Location: managebooks.php?product={$pid}&error=1");
    }
}
function uploadImage() {
    /*global $link;
    $pid= $link->real_escape_string($_POST['prodid']);
    $localpath = $_POST['upload'];
    $remotepath = "/htdocs/image/" . $file;

    // set up basic connection
    $conn_id = ftp_connect("ftp.epizy.com");

    // login with username and password
    $login_result = ftp_login($conn_id, "epiz_19723230", "icebreaker");

    // upload a file
    if (ftp_put($conn_id, $remotepath, $localpath, FTP_ASCII)) {
        header("Location: managebooks.php?product={$pid}&redirect_success=1");
    } else {
        header("Location: managebooks.php?product={$pid}&error=5");
    }

    // close the connection
    ftp_close($conn_id);*/
}
//allow the user to enter an id and select a product
function id_lookup() {
    global $link;
    $temp = $link->real_escape_string($_POST['editbookid']);
    header("Location: managebooks.php?product={$temp}");
}
//Deletes the currently selected product from the database
function confirm_delete() {
    global $link;
    //if true no product was selected when the delete button was pressed
    $id = $_POST['confirm_delete'];
    if ($id == "") header("Location: managebooks.php?product=&error=2");
    //Because of the foreign key constraint we have to delete all transactions with said product ID before deleting the product
    //So we should probably remove the option to delete and have something like a boolean active/inactive products
    $qry = "DELETE FROM Transactions WHERE ProductID={$id}";
    if(mysqli_query($link, $qry)) {
       //if success transactions with the product id were deleted
    } else {
        //if failure either the records didnt exist or an error deleting them.
    }

    //Delete the product from the database
    if (mysqli_query($link, "DELETE FROM Products WHERE ProductID={$id}")) {
         //successful delete
         header("Location: managebooks.php?product=&redirect_success=3");
    }else {
        //do some code for unsuccessful delete
        header("Location: managebooks.php?product={$pid}&error=3");
   }
}

if (isset($_GET['edit_add'])) {
    edit_add();
    uploadImage();
} else if (isset($_GET['id_lookup'])) {
    id_lookup();
} else if (isset($_GET['get_to_delete'])) {
    get_to_delete();
} else if (isset($_GET['confirm_delete'])) {
    confirm_delete();
}
?>

