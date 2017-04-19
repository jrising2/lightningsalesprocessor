<?php
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
                <li <?php if(!isset($_GET['id'])) echo 'class="active"'; ?>><a data-toggle="pill" href="#AllOrders">All Orders</a></li>
                <li><a data-toggle="pill" href="#EmpOrders">Employee Orders</a></li>
                <li <?php if(isset($_GET['id'])) echo 'class="active"'; ?>><a data-toggle="pill" href="#OrderInfo">Order Information</a></li>
            </ul>
        </div>

        <div class="col-md-9">
            <div class="tab-content">

                <!-- A list of all the orders -->
                <div id="AllOrders" class="tab-pane fade in <?php if(!isset($_GET['id'])) echo 'active'; ?>">
                    <h2>List of <?php echo $currentStatus; ?> Orders</h2>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-inline" action="orders.php" method="post">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control" required>
                                                    <option value="" disabled selected>Select status</option>
                                                    <option value="Open">Open</option>
                                                    <option value="Assigned">Assigned</option>
                                                    <option value="Closed">Closed</option>
                                                    <option value="All">All</option>
                                                </select>
                                                <button type="submit" class="btn btn-default">Search</button>
                                            </div>
                                        </div>

                                        <div class="panel-body">
                                            <?php displayPage($currentPage, $currentStatus); ?>
                                        </div>
                                    </div>
                                </form>
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

                <!-- List of the employees and the orders they currently are assigned -->
                <div id="EmpOrders" class="tab-pane fade">
                    <h2>Employee Orders</h2>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php displayEmployeeOrders(); ?>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="OrderInfo" class="tab-pane fade <?php if(isset($_GET['id'])) echo 'in active'; ?>">
                    <h2>Order Information</h2>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if(!isset($_GET['id'])) {
                                    echo 'No order has been selected';
                                }else{
                                    printAllInformation($_GET['id']);
                                }
                                 ?>
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
