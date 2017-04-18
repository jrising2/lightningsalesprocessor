<?php
ini_set('display_errors',1);
require_once('php/order_funcs.php');
include "./includes/employee_header.php";

$employeeID = $_SESSION['eid'];
if(isset($_SESSION['stauts'])) $_POST['status'] = $_SESSION['status'];
if(isset($_GET['page'])){$currentPage = $_GET['page'];}else{$currentPage = 1;}

if(isset($_POST['status'])){
    if($_POST != "All"){
        $currentStatus = $_POST['status'];
        $_SESSION['status'] = $currentStatus;
    }
}else{
    if(!isset($_SESSION['status'])) $_SESSION['status'] = "All";
    $currentStatus = $_SESSION['status'];
}


?>


<!-- Main Body Start, uses similar implementation to checkout and transaction history -->
<body>
<div class="container">
    <div class="row">
        <!--Account page modes -->
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked" id="AccTabs">
                <li class="active"><a data-toggle="pill" href="#InProgress">All Orders</a></li>
                <li><a data-toggle="pill" href="#NewOrders">Employee Orders</a></li>
            </ul>
        </div>

        <div class="col-md-9">
            <div class="tab-content">

                <!-- Account Summary tab in the account page -->
                <div id="InProgress" class="tab-pane fade in active">
                    <h2>All Orders</h2>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-inline" action="orders.php" method="post">
                                    <div class="form-group"><label for="status">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="Open">Open</option>
                                            <option value="Assigned">Assigned</option>
                                            <option value="Closed">Closed</option>
                                            <option value="All">All</option>
                                        </select>
                                    </div>
                                    <div class="form-group"><label for="productid">ProductID</label>
                                        <input name="productID" type="number" class="form-control" id="productid">
                                    </div>
                                    <button type="submit" class="btn btn-default">Search</button>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?php displayPage($currentPage, $currentStatus); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <ul class="pagination pagination-lg">
                                    <?php pageNumbers($currentStatus); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Past/Current Transactions/Orders in the account page-->
                <div id="NewOrders" class="tab-pane fade">
                    <h2>Employee Orders</h2>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<!-- Main Body End -->

<!-- Footer Start -->
<?php include('includes/footer_empty.php'); ?>
