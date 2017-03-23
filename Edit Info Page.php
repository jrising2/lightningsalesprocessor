<?php
include_once "includes/header.php";
include_once "includes/database.php";
session_start();
global $link;
$qryAccountInfo = "SELECT FirstName, LastName, Address1, Address2, City, State, ZipCode, Email FROM customers WHERE CustomerID=" . $_SESSION['id'];
$account_info = mysqli_query($link, $qryAccountInfo);
$row = mysqli_fetch_assoc($account_info);
?>
        <div class="col-md-11">
            <h2>Edit Account Information</h2>
            <form role="form" action="Edit Info.php" method="POST">
                <div class="form-group tight-form-group">
                    <div class="row">
                        <label for="fname" class="col-md-2 col-form-label">First Name</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="<?php echo($row['FirstName']); ?>" name="fname">
                        </div>
                        <label for="lname" class="col-md-2 col-form-label">Last Name</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="<?php echo($row['LastName']);?>" name="lname">
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="<?php echo($row['Email']);?>" name="email">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="phone" class="col-md-2 col-form-label">Phone Number</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="<?php echo($row['PhoneNumber']);?>" name="phone">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="add1" class="col-md-2 col-form-label">Address Line 1</label>
                            <div class="col-md-4">
                            <input class="form-control" type="text" value="<?php echo($row['Address1']);?>" name="add1">
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:20px">
                    <div class="form-group tight-form-group">
                        <label for="add2" class="col-md-2 col-form-label">Address Line 2</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="<?php echo($row['Address2']);?>" name="add2">
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:20px">
                    <div class="form-group tight-form-group">
                        <label for="state" class="col-md-2 col-form-label">State</label>
                        <div class="col-md-1">
                            <select type="text" class="form-control" id="state">

                            </select>
                        </div>
                        <label for="city" class="col-md-2 col-form-label">City</label>
                        <div class="col-md-2">
                            <input class="form-control" type="text" value="<?php echo($row['City'])?>" id="city">
                        </div>
                        <label for="zip" class="col-md-2 col-form-label">Zip Code</label>
                        <div class="col-md-2">
                            <input class="form-control" type="text" value="<?php echo($row['ZipCode'])?>" id="zip">
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:20px;padding-bottom:20px">
                    <div class="form-group tight-form-group">
                        <label for="country" class="col-md-2 col-form-label">Country</label>
                        <div class="col-md-4">
                            <select type="text" class="form-control" id="country">

                            </select>
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
