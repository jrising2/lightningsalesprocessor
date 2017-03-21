<?php
include_once "database.php";
$account_info;

function loadFormInformation() {
    global $link;
    $qryAccountInfo = "SELECT FirstName, LastName, Address1, Address2, City, State, ZipCode, Email FROM customers WHERE CustomerID=1";
    $GLOBALS['account_info'] = mysqli_query($link, $qryAccountInfo);
}

function createEditForm() {
    $row = mysqli_fetch_assoc($GLOBALS['account_info']);
    $html = <<<EOF
        <div class="col-md-11">
            <h2>Edit Account Information</h2>
            <form role="form" action="EditInfo.php">
                <div class="form-group tight-form-group">
                    <div class="row">
                        <label for="fname" class="col-md-2 col-form-label">First Name</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="{$row['FirstName']}" id="fname">
                        </div>
                        <label for="lname" class="col-md-2 col-form-label">Last Name</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="{$row['LastName']}" id="lname">
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="email" class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{$row['Email']}" id="email">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="phone" class="col-md-2 col-form-label">Phone Number</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{$row['PhoneNumber']}" id="phone">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <div class="form-group tight-form-group">
                            <label for="add1" class="col-md-2 col-form-label">Address Line 1</label>
                            <div class="col-md-4">
                            <input class="form-control" type="text" value="{$row['Address1']}" id="add1">
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:20px">
                    <div class="form-group tight-form-group">
                        <label for="add2" class="col-md-2 col-form-label">Address Line 2</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" value="{$row['Address2']}" id="add2">
                        </div>
                    </div>
                </div>

                <div class="row" style="padding-top:20px">
                    <div class="form-group tight-form-group">
                        <label for="state" class="col-md-2 col-form-label">State</label>
                        <div class="col-md-1">
                            <select type="text" class="form-control" id="State">

                            </select>
                        </div>
                        <label for="city" class="col-md-2 col-form-label">City</label>
                        <div class="col-md-2">
                            <input class="form-control" type="text" value="{$row['City']}" id="city">
                        </div>
                        <label for="zip" class="col-md-2 col-form-label">Zip Code</label>
                        <div class="col-md-2">
                            <input class="form-control" type="text" value="{$row['ZipCode']}" id="zip">
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
EOF;
    echo($html);
}


?>