<?php
include_once "Account.php";
loadInformation();
include_once "includes/header.php";
?>

<!-- Main Body Start -->

<body>
	<div class="container">
		<div class="row">
			<!--Account page modes -->
			<div class="col-md-3">
				<ul class="nav nav-pills nav-stacked" id="AccTabs">
					<li class="active"><a data-toggle="pill" href="#AccSummary">Account Summary</a></li>
					<li><a data-toggle="pill" href="#Transactions">Transactions History</a></li>
					<li><a data-toggle="pill" href="#PaymentInfo">Payment Information</a></li>
				</ul>
			</div>
			
			<div class="col-md-9">
				<div class="tab-content">

					<!-- Account Summary tab in the account page -->
					<div id="AccSummary" class="tab-pane fade in active">
						<h2>Account Summary</h2>
						<h3>Hello, Username</h3>
						<?php
                        fillAccountSummary();
                        ?>
						<a href="Edit Info Page.php"><button type="button" class="btn btn-primary btn-md pull-right">Edit</button></a>
						<a href="Change Pass Page.php">Change password</a>
					</div>
					
					<!-- Past/Current Transactions/Orders in the account page-->
					<div id="Transactions" class="tab-pane fade">
						<h2>Transactions</h2>
						<?php
                        fillTransactions();
                        ?>
					</div>
					
					<div id="PaymentInfo" class="tab-pane fade">
						<h2>Payment Information</h2>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-4">Name on the card</div>
									<div class="col-md-6">Card Number</div> 
									<div class="col-md-2">Expiration Date</div>
								</div>
							</div>
							<div class="panel-body">
								Billing Address Name
								<br>Billing Address Line 1
								<br>Billing Address Line 2
								<br>State, City, ZIP
								<br>Country
								<br>Phone number (XXX-XXX-XXXX)
							</div>
						</div>
						<button type="button" class="btn btn-primary btn-md pull-right">Edit</button>
					</div>
					
					</div id="Admininstrative=" class="tab-pane fade">
						
					</div>
				</div>
			</div>
			
		</div>
	</div>
</body>

<?
include_once "footer.php";
?>
