<?php
include_once "includes/header.php";
include_once "includes/database.php";
include_once "includes/functions.php";
//date_default_timezone_set()
//Check if the person is logged in before allowing page access
if (isset($_SESSION['id']) == false) {
    header("Location: login.php");
}

global $link;
//gets error if one occurs
$card = "";
if (isset($_POST['payment_edit'])) $card = $_POST['payment_edit'];

$row = null;
if ($card != "") {
    $qryAccountInfo = "SELECT NameOnCard, CardNumber, CardExpirationMonth, CardExpirationYear, BillingAddress1, BillingAddress2, City, State, ZipCode FROM Billing WHERE BillingID={$card}";
    $account_info = mysqli_query($link, $qryAccountInfo);
    $row = mysqli_fetch_assoc($account_info);
}

$ERROR = "";
if (isset($_POST['error'])) {
    $ERROR = $_POST['error'];
}

if ($ERROR == "1"){
    echo  '<div class="alert alert-danger" role="alert">
            <strong>System Error: </strong>Error adding your payment information.
        </div>';
}else if ($ERROR == "2") {
     echo  '<div class="alert alert-danger" role="alert">
            <strong>System Error: </strong>Error updating your payment information.
        </div>';
}
?>
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <?php
            if ($card == "") {
                echo '<h2>Add Payment Information</h2>';
            }else {
                echo '<h2>Edit Payment Information</h2>';
            }
            ?>
            <form role="form" action="php/edit_payment_process.php" method="POST">
                <div class="form-group tight-form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="nameoncard" class="col-form-label">Name on card:</label>
                            <?php
                            if ($card == "") {
                                echo '<input class="form-control" type="text" name="nameoncard">';
                            }else{
                                echo '<input class="form-control" type="text" value="' .$row['NameOnCard'] . '" name="nameoncard">';
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <label for="cardnumber" class="col-form-label">Card Number:</label>
                            <?php
                            if ($card == "") {
                                echo '<input class="form-control" type="text" name="cardnumber">';
                            }else {
								$cn = decrypt($row['CardNumber'], $_SESSION['id']);
                                echo '<input class="form-control" type="text" value="' . $cn .'" name="cardnumber">';
                            }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <label for="month" class="col-form-label">Expiration Date:</label>
                            <div class="row">
                                <div class="col-md-6">
                                <select type="text" class="form-control" name="month" style="width:70px;">
                                <?php
                                    $st = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
                                    if ($card == "") {
                                        for ($i = 0; $i < 12; $i++) {
                                            echo "<option value=" . $st[$i] . ">" . $st[$i] . "</option>";
                                        }
                                    }else {
                                        for ($i = 0; $i < 12; $i++) {
                                            if ($st[$i] == $row['CardExpirationMonth']) {
                                                echo "<option value=" . $st[$i] . " selected>" . $st[$i] . "</option>";
                                            } else {
                                                echo "<option value=" . $st[$i] . ">" . $st[$i] . "</option>";
                                            }
                                        }
                                    }
                                ?>
                                </select>
                                </div>
                                <div class="col-md-6">
                                    <select type="text" class="form-control" name="year" style="width:150px;">
                                    <?php
                                        $year = intval(date("Y"));
                                        if ($card == "") {
                                            for ($i = 0; $i < 21; $i++) {
                                                echo "<option value=" . ($year + $i) . ">" . ($year + $i) . "</option>";
                                            }
                                        }else {
                                            for ($i = 0; $i < 21; $i++) {
                                                if (($year + $i) == intval($row['CardExpirationYear'])) {
                                                    echo "<option value=" . ($year + $i) . " selected>" . ($year + $i) . "</option>";
                                                } else {
                                                    echo "<option value=" . ($year + $i) . ">" . ($year + $i) . "</option>";
                                                }
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>

                                </div>

                            </div>
                        </div>
                    </div><!-- End of form group consisting of nameoncard card info, card number, expiration date-->

                    <!-- Form group consisting of billing address line 1 and 2-->
                    <div class="form-group tight-form-group">
                        <div class="row" style="">
                            <div class="col-md-4">
                            <label for="add1" class="col-form-label">Billing Address Line 1</label>
                            <?php
                            if ($card == "") {
                                echo '<input class="form-control" type="text" name="add1">';
                            }else {
                                echo '<input class="form-control" type="text" value="' . $row['BillingAddress1'] . '" name="add1">';
                            }
                            ?>
                            </div>
                        </div>

                        <div class="row" style="padding-top:15px;">
                                <div class="col-md-4">
                                    <label for="add2" class="col-form-label">Billing Address Line 2</label>
                                    <?php
                                    if ($card == "") {
                                        echo '<input class="form-control" type="text" name="add2">';
                                    }else {
                                        echo '<input class="form-control" type="text" value="' . $row['BillingAddress2'] . '" name="add2">';
                                    }
                                    ?>
                                </div>
                        </div>
                    </div>

                    <!--Form group consisting of city, state, zip-->
                    <div class="form-group tight-form-group">
                        <div class="row" style="padding-top:20px;padding-bottom:20px">
                            <div class="col-md-3">
                                <label for="city" class="col-form-label">City</label>
                                <?php
                                if ($card == "") {
                                    echo '<input class="form-control" type="text" name="city">';
                                }else{
                                    echo '<input class="form-control" type="text" value="' . $row['City'] . '" name="city">';
                                }
                                ?>
                            </div>
                            <div class="col-md-3">
                                <label for="state" class="col-form-label">State</label>
                                <select type="text" class="form-control" name="state">
                                    <?php
                                    $st = array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming");
                                    if ($card == "") {
                                        for ($i = 0; $i < 50; $i++) {
                                            echo "<option value=" . $st[$i] . ">" . $st[$i] . "</option>";
                                        }
                                    }else{
                                        for ($i = 0; $i < 50; $i++) {
                                            if (strtolower($st[$i]) == strtolower($row['State'])) {
                                                echo "<option value='" . $st[$i] . "' selected>" . $st[$i] . "</option>";
                                            } else {
                                                echo "<option value='" . $st[$i] . "'>" . $st[$i] . "</option>";
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="zip" class="col-form-label">Zip Code</label>
                                <?php
                                if ($card == "") {
                                    echo '<input class="form-control" type="text" name="zip">';
                                }else {
                                    echo '<input class="form-control" type="text" value="' . $row['ZipCode'] . '" name="zip">';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        echo "<input type='hidden' name='bid' value='{$card}'>";
                    ?>
					<?php
					if ($card == "") {
						echo '<div align="right"><button type="submit" class="btn btn-primary btn-block" style="width:150px">Confirm</button></div>';
					}else {
						echo '<div align="right"><button type="submit" class="btn btn-primary btn-block" style="width:150px">Confirm Changes</button></div>';
					}
					?>
        </form>
    </div>
    <div class="col-md-2"></div>

<?php
include_once "includes/footer.php"
?>