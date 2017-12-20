<?php
include_once "includes/header.php";
include_once "account_process.php";
loadInformation();
//Check if the person is logged in before allowing page access
if (isset($_SESSION['id']) == false) {
	header("Location: login.php");
}
$ERROR = "";
if(isset($_GET['error'])) $ERROR = $_GET['error'];
if ($ERROR == "1"){
    echo  '<div class="alert alert-danger" role="alert">
            <strong>System Error: </strong>Error deleting your payment information.
        </div>';
}
?>

<!-- Main Body Start -->

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
						<a href="edit_info.php"><button type="button" class="btn btn-primary btn-md pull-right">Edit</button></a>
						<a href="change_pass.php">Change password</a>
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
                        <?php
                        fillPaymentInfo();
                        ?>
					</div>
					
					<div id="Admininstrative=" class="tab-pane fade">
						
					</div>
				</div>
			</div>
			
		</div>
	</div>

<?php
include_once "includes/footer.php";
?>
