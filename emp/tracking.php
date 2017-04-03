<?php
include_once "includes/employee_header.php";
?>

<!-- Main Body Start -->

    <div class="container">
        <div class="row">
            <!--Account page modes -->
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked" id="AccTabs">
                    <li class="active"><a data-toggle="pill" href="#InProgress">My Orders</a></li>
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
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class ="col-md-2"><p>CustomerID<br>#00000000000000</p></div>
                                        <div class="col-md-2"> <p>Shipping Address<br/p>XXXXXXXXXXXXXXXX City State Zip</div>
                                        <div class ="col-md-2"><p>Condition<br>New/Used/Digital</p></div>
                                        <div class="col-md-2"> <p>Status<br>In Queue/In Progress/Completed</p></div>
                                        <div class="col-md-2"> <p>EmployeeID<br>#0000000000000</p></div>
                                        <div class="col-md-2 text-right"><br><a href="Accept Order">Remove</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Past/Current Transactions/Orders in the account page-->
                    <div id="NewOrders" class="tab-pane fade">
                        <h2>Orders</h2>
                        <button type="button">Get Next Job</button>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class ="col-md-2"><p>CustomerID<br>#00000000000000</p></div>
                                        <div class="col-md-2"> <p>Shipping Address<br/p>XXXXXXXXXXXXXXXX City State Zip</div>
                                        <div class ="col-md-2"><p>Condition<br>New/Used/Digital</p></div>
                                        <div class="col-md-2"> <p>Status<br>In Queue/In Progress/Completed</p></div>
                                        <div class="col-md-2"> <p>EmployeeID<br>#0000000000000</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="History" class="tab-pane fade">
                        <h2>Order History</h2>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class ="col-md-2"><p>CustomerID<br>#00000000000000</p></div>
                                        <div class="col-md-2"> <p>Shipping Address<br/p>XXXXXXXXXXXXXXXX City State Zip</div>
                                        <div class ="col-md-2"><p>Condition<br>New/Used/Digital</p></div>
                                        <div class="col-md-2"> <p>Status<br>In Queue/In Progress/Completed</p></div>
                                        <div class="col-md-2"> <p>EmployeeID<br>#0000000000000</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<!-- Main Body End -->

<?php
include_once "includes/footer_empty.php";
?>