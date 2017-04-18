<?php
include "../includes/database.php";
session_start();
global $link;
?>

<h3>Setup Filter Options:</h3>
<div class="row" style="padding-top:15px">
    <div class="col-md-5">
		<p style="font-weight:bold" id="prompt"></p>
		<div class="form-check">
			<label class="form-check-label">
			<input class="form-check-input" type="checkbox" value="general_manager">
			General Manager
			</label>
		</div>
		<div class="form-check">
			<label class="form-check-label">
				<input class="form-check-input" type="checkbox" value="product_manager">
				Product Manager
			</label>
		</div>
		<div class="form-check">
			<label class="form-check-label">
				<input class="form-check-input" type="checkbox" value="book_seller">
				Book Seller
			</label>
		</div>
    </div>



</div>