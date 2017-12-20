<?php
include "../../includes/database.php";

//Edits a record or adds a record to the database
function edit_add() {
    global $link;
    $pid = $link->real_escape_string($_POST['prodid']);
    $pname = $link->real_escape_string($_POST['title']);
    $isbn = $link->real_escape_string($_POST['isbn']);
    $stock = $link->real_escape_string($_POST['stock']);

    if (($_POST['prodid'] == "") || ($pid == "")) {
        header("Location: ../managebooks.php?product=&error=4");
    }

    $qry;
    //check if the product exist in the database already
    $result = mysqli_query($link, "SELECT ProductID FROM Products WHERE ProductID={$pid}");
    if(mysqli_num_rows($result) > 0) {
        $qry = "UPDATE Products SET ProductName = '{$pname}', ISBN = '{$isbn}', Stock = {$stock} WHERE ProductID={$pid}";
    }else {
        $qry = "INSERT INTO Products(ProductName, ISBN, Stock) VALUES ('{$pname}', '{$isbn}', {$stock})";
    }
    //execute either an update or an insert depending on above result
    if (mysqli_query($link, $qry)) {
        //successful insert
        if (mysqli_num_rows($result) > 0) {
            //succesful update
            //move to next part where we upload the file to the server
        }else {
            //succesful insert
            header("Location: ../managebooks.php?product={$pid}&redirect_success=2");
        }
    }  else {
        //do some code for unsuccessful insert
        header("Location: ../managebooks.php?product={$pid}&error=1");
    }
}
function uploadImage() {
    global $link;
    //get some product information
    $pid= $link->real_escape_string($_POST['prodid']);
    $isbn = $link->real_escape_string($_POST['isbn']);
    if (($_FILES['userfile']['name'] != 0) && ($_FILES['userfile']['tmp_name'] != 0))	{
		
    }else {
        //if no file is specified leave method and update the rest
		header("Location: ../managebooks.php?product={$pid}&redirect_success=1");
		exit();
    }
    $localpath = $_FILES['userfile']['tmp_name']; //local file path
    $remotepath = "/htdocs/image/" . $isbn . ".jpg";

    // set up basic connection and login with username and password
    $conn_id = ftp_connect("ftp.epizy.com") or die ("could not connecet to $ftp_password");
    if(ftp_login($conn_id, "epiz_19723230", "icebreaker")) {
        // upload a file
        if (ftp_put($conn_id, $remotepath, $localpath, FTP_BINARY)) {
            ftp_close($conn_id);
            header("Location: ../managebooks.php?product={$pid}&redirect_success=1");
        } else {
            //error occured while uploading
            ftp_close($conn_id);
            header("Location: ../managebooks.php?product={$pid}&error=5");
        }
    } else {
        //system error failed to connect
        ftp_close($conn_id);
        header("Location: ../managebooks.php?product={$pid}&error=6");
    }
}

//allow the user to enter an id and select a product
function id_lookup() {
    global $link;
    $temp = $link->real_escape_string($_POST['editbookid']);
    header("Location: ../managebooks.php?product={$temp}");
}
//Deletes the currently selected product from the database
function confirm_delete() {
    global $link;
    //if true no product was selected when the delete button was pressed
    $id = $_POST['confirm_delete'];
    if ($id == "") header("Location: ../managebooks.php?product=&error=2");

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
         header("Location: ../managebooks.php?product=&redirect_success=3");
    }else {
        //do some code for unsuccessful delete
        header("Location: ../managebooks.php?product={$pid}&error=3");
   }
}

if (isset($_POST['edit_add'])) {
    edit_add();
    uploadImage();
} else if (isset($_POST['id_lookup'])) {
    id_lookup();
} else if (isset($_POST['get_to_delete'])) {
    get_to_delete();
} else if (isset($_POST['confirm_delete'])) {
    confirm_delete();
}
?>

