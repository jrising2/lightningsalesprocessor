<?php
ini_set('display_errors',1);
include "./includes/employee_header.php";
include_once "php/emp_home.php";

$employeeID = $_SESSION['eid'];

// Checks to see if there is a new job being seeked

$currentJob = getCurrentJob($employeeID);

if(isset($_GET['getjob']) && $currentJob->num_rows == 0){
    $jobs = getNextJob($employeeID);
    if($jobs != FALSE){
        $newjob = $jobs->fetch_assoc();
    }else{
        $newjob = getCurrentJob($employeeID)->fetch_assoc();
    }
    header('Location: tracking.php');
}else{ // Otherwise check to see what any current assignments are.
    if($currentJob){
        $newjob = $currentJob->fetch_assoc();
    }
}

if(isset($_POST['status'])){
    modifyTransaction($newjob['TransactionID'],"Status","'".$_POST['status']."'");

    if($_POST['status'] == 'open'){
        modifyTransaction($newjob["TransactionID"],"EmployeeID",'NULL');
    }
    header("Refresh:0");
}
?>


<!-- Main Body Start, uses similar implementation to checkout and transaction history -->
<body>
    <div class="container">
        <div class="row">
            <!--Account page modes -->
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked" id="AccTabs">
                    <li class="active"><a data-toggle="pill" href="#InProgress">My Order</a></li>
                    <li><a data-toggle="pill" href="#NewOrders">New Orders</a></li>
                    <li><a data-toggle="pill" href="#History">History</a></li>
                </ul>
            </div>
            
            <div class="col-md-9">
                <div class="tab-content">

                    <!-- Account Summary tab in the account page -->
                    <div id="InProgress" class="tab-pane fade in active">
                        <h2>My Orders</h2>

                        <div class="panel-body">
                            <div class="row">
                                <form action="tracking.php" method="post">
                                <?php if(isset($newjob)){ ?>
                                <div class="row bs-callout bs-callout-warning">
                                    <div class="col-md-2">
                                        <p><strong>TransID</strong>
                                            <br><?php echo $newjob['TransactionID'] ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>CustomerID</strong><br><?php echo $newjob['CustomerID']; ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>Method</strong>
                                            <br><?php echo $newjob['DeliveryType']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>Status</strong>
                                            <br><?php getStatus($newjob['TransactionID']); //echo $newjob['Status']; ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <p><strong>Total</strong>
                                            <br>$<?php echo $newjob['GrandTotal'] ?>
                                        </p>
                                    </div>
                                    <div class="col-md-2 form-inline">
                                        <button type="submit" class="btn btn-danger">Change</button><br>
                                        <a class="btn btn-primary" href="#">More Info</a>
                                    </div>
                                </div>
                                <?php }else{echo 'No job is currently assigned.';} ?>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Past/Current Transactions/Orders in the account page-->
                    <div id="NewOrders" class="tab-pane fade">
                        <h2>Orders</h2>
                        <a href="tracking.php?getjob=1" class="btn btn-primary">Get Next Job</a>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <?php $allrows = allAvailableJobs(); foreach($allrows as $singlejob){ ?>
                                    <div class="row bs-callout bs-callout-success">
                                        <div class="col-md-2">
                                            <p><strong>TransID</strong>
                                                <br><?php echo $singlejob['TransactionID']; ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>CustomerID</strong><br><?php echo $singlejob['CustomerID']; ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Method</strong>
                                                <br><?php echo $singlejob['DeliveryType']; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Status</strong>
                                                <br><?php echo $singlejob['Status']; ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Total</strong>
                                                <br>$<?php echo $singlejob['GrandTotal']; ?>
                                            </p>
                                        </div>
<!--                                        <div class="col-md-2 form-inline">-->
<!--                                            <a class="btn btn-danger" href="#">Change</a><br>-->
<!--                                            <a class="btn btn-primary" href="#">More Info</a>-->
<!--                                        </div>-->
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="History" class="tab-pane fade">
                        <h2>Order History</h2>
                        <div class="panel-body">
                            <?php $jobHistory = getJobHistory($employeeID); foreach($jobHistory as $singlejob){ ?>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row bs-callout bs-callout-danger">
                                        <div class="col-md-2">
                                            <p><strong>TransID</strong>
                                                <br><?php echo $singlejob['TransactionID']; ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>CustomerID</strong><br><?php echo $singlejob['CustomerID']; ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Method</strong>
                                                <br><?php echo $singlejob['DeliveryType']; ?>
                                            </p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Status</strong>
                                                <br><?php echo $singlejob['Status']; ?></p>
                                        </div>
                                        <div class="col-md-2">
                                            <p><strong>Total</strong>
                                                <br>$<?php echo $singlejob['GrandTotal']; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
        <!-- Main Body End -->

        <!-- Footer Start -->
        <hr>
        <footer>
            <div class="row">
                <div class="col-md-3">
                    <h4><span class="glyphicon glyphicon-info-sign"></span> About Us</h4>
                    <ul class="nav nav-stacked">
                        <li><a href="#">About Book Store</a></li>
                        <li><a href="#">Investor Relations</a></li>
                        <li><a href="#">Careers at Book Store</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4><span class="glyphicon glyphicon-earphone"></span> Customer Service</h4>
                    <ul class="nav nav-stacked">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">In-Store Pickup</a></li>
                        <li><a href="#">Shipping</a></li>
                        <li><a href="#">Terms and Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4><span class="glyphicon glyphicon-link"></span> Links</h4>
                    <ul class="nav nav-stacked">
                        <li><a href="#">Kent State University</a></li>
                        <li><a href="#">Barnes And Noble</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4><span class="glyphicon glyphicon-envelope"></span> Contact us</h4>
                    <form role="form">
                        <div class="form-group tight-form-group">
                            <label class="sr-only" for="name">Name</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter name ...">
                        </div>
                        <div class="form-group tight-form-group">
                            <label class="sr-only" for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter email ...">
                        </div>
                        <div class="form-group tight-form-group">
                            <label class="sr-only" for="email">Email</label>
                            <textarea class="form-control" rows="3" placeholder="Enter message ..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </form>
                </div>
            </div>
        </footer>
        <!-- Footer End -->

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </div>
</body>

</html>
