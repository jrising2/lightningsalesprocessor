<?php
include_once "includes/header.php";
include_once "includes/database.php";

//Check if the person is logged in before allowing page access
if (isset($_SESSION['id']) == false) {
	header("Location: login.php");
}

global $link;

$qryAccountInfo = "SELECT FirstName, LastName, Address1, Address2, City, State, ZipCode, Email FROM Customers WHERE CustomerID={$_SESSION['id']}";
$account_info = mysqli_query($link, $qryAccountInfo);
$row = mysqli_fetch_assoc($account_info);

$ERROR;
if (isset($_GET['error'])) {
    $ERROR = $_GET['error'];
}

if ($ERROR == "1"){
    echo  '<div class="alert alert-danger" role="alert">
            <strong>Error: </strong>Illegal Characters in field: First Name.
        </div>';
}else if ($ERROR == "2") {
     echo  '<div class="alert alert-warning" role="alert">
            <strong>Error: </strong>Illegal Characters in field: Last Name.
        </div>';
} else if ($ERROR =="3"){
    echo '<div class="alert alert-danger" role="alert">
            <strong>Error: </strong>Invalid email address entered.
        </div>';
} else if ($ERROR == "4"){
      echo '<div class="alert alert-warning" role="alert">
            <strong>Error: </strong>Invalid Address Entered.
        </div>';
} else if ($ERROR == "5"){
    echo '<div class="alert alert-danger" role="alert">
                <strong>System Error: </strong> Error occured while attemping to commit changes.
        </div>';
}
?>
        <div class="col-md-11">
            <h2>Edit Account Information</h2>
            <form role="form" action="edit_info_process.php" method="POST">
                <div class="form-group tight-form-group">
                    <div class="row">
                        <label for="fname" class="col-md-2 col-form-label">First Name</label>
                        <div class="col-md-4">
                            <?php
                            echo '<input class="form-control" type="text" value="' .$row['FirstName'] . '" name="fname">';
                            ?>
                        </div>
                        <label for="lname" class="col-md-2 col-form-label">Last Name</label>
                        <div class="col-md-4">
                            <?php
                            echo '<input class="form-control" type="text" value="' . $row['LastName'] .'" name="lname">';
                            ?>
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-4">
                                <?php
                                echo '<input class="form-control" type="text" value="' . $row['Email'] . '" name="email">';
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="phone" class="col-md-2 col-form-label">Phone Number</label>
                            <div class="col-md-4">
                                <?php
                                echo '<input class="form-control" type="text" value="' . $row['PhoneNumber'] . '" name="phone">';
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="add1" class="col-md-2 col-form-label">Address Line 1</label>
                            <div class="col-md-4">
                            <?php
                            echo '<input class="form-control" type="text" value="' . $row['Address1'] . '" name="add1">';
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:20px">
                    <div class="form-group tight-form-group">
                        <label for="add2" class="col-md-2 col-form-label">Address Line 2</label>
                        <div class="col-md-4">
                            <?php
                            echo '<input class="form-control" type="text" value="' . $row['Address2'] . '" name="add2">';
                            ?>
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:20px;padding-bottom:20px">
                    <div class="form-group tight-form-group">
                        <label for="city" class="col-md-2 col-form-label">City</label>
                        <div class="col-md-2">
                            <?php
                            echo '<input class="form-control" type="text" value="' . $row['City'] . '" name="city">';
                            ?>
                        </div>
                        <label for="state" class="col-md-2 col-form-label">State</label>
                        <div class="col-md-2">
                            <select type="text" class="form-control" name="state">
                                <?php
                                    $st = array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming");
									for ($i = 0; $i < 50; $i++) {
                                        if (strtolower($st[$i]) == strtolower($row['State'])) {
                                            echo "<option value=" . $st[$i] . " selected>" . $st[$i] . "</option>";
                                        } else {
                                            echo "<option value=" . $st[$i] . ">" . $st[$i] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <label for="zip" class="col-md-2 col-form-label">Zip Code</label>
                        <div class="col-md-2">
                            <?php
                            echo '<input class="form-control" type="text" value="' . $row['ZipCode'] . '" name="zip">';
                            ?>
                        </div>
                    </div>
                </div>
                <div align="right"><button type="submit" class="btn btn-primary btn-block" style="width:150px">Confirm Changes</button></div>
            </div>
        </form>
    </div>
    <div class="col-md-1"></div>

<?php
include_once "includes/footer.php"
?>
