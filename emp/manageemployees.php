<?php 
include('includes/employee_header.php'); 	
require_once('config/database.php');
?>
	
	<!-- Changes I will be working on:
    - Making sure only employees with the proper role(s) have access.
		- Get the edit form to work
			- Redirect to editemployee page and fill out employee id input field.
		- Verify that when id/role # are input, that they are ints.
		- Other than that, I think this page is good?
	-->
			
<div id="employeeTable" class="row">
	<!-- Display employees ---------- -->
	<div class="col-md-9">
		<h3>Employees</h3>
		<div class="row" style="padding-left:15px">
			<table class="table table-condensed" style="width:800px">
				<tr>
					<th>ID</th>
					<th>Employee</th>
					<th>Role</th>
					<th>Edit Stock</th>
					<th>Edit Customers</th>	
					<th>Edit Employees</th>
				</tr>
				<?php
					$query = "SELECT EmployeeID, FirstName, LastName, Role, RoleName FROM Employees INNER JOIN Role ON Employees.Role = Role.RoleID";
					$result = mysqli_query($link, $query);

					while($row = mysqli_fetch_array($result)){
						$EmployeeID = $row['EmployeeID'];
						$FName = $row['FirstName'];
						$LName = $row['LastName'];
						$RoleName = $row['RoleName'];
						$Role = $row['Role'];
						
						echo "<tr>";
						echo "<td> $EmployeeID </td>";
						echo "<td> $FName $LName </td>";
						echo "<td> $RoleName </td>";
			
						if($Role == "1"){
							echo "<td> Yes </td>";
							echo "<td> Yes </td>";
							echo "<td> Yes </td>";
						}else if($Role == "2"){
							echo "<td> Yes </td>";
							echo "<td> Yes </td>";
							echo "<td> No </td>";
						}else if($Role == "3"){
							echo "<td> No </td>";
							echo "<td> No </td>";
							echo "<td> No </td>";
						}else{
							echo "<td> No </td>";
							echo "<td> No </td>";
							echo "<td> No </td>";
						}
						echo "</tr>";
					}
				?>
			</table>
		</div>
	</div>
	
	<!-- Edit employee ---------- -->
	<div class="col-md-3" style="text-align:right">
		<div class="row" style="padding-right:15px">
			<h3 style="text-align:left">Edit Employee</h3>
		</div>
		<div class="row" style="padding-right:15px">
			<table class="table table-condensed" style="width:263px">
				<tr>
					<th>Employee ID:</th>
				</tr>
				<tr>
					<td style="border-top: none">
						<form class="form-inline" action="editemployee.php" method="post">
							<div class="form-group" style="text-align:left">
								<input type="text" class="form-control" id="manage_edit_emp" style="width:263px">
							</div><br /><br />
							<button type="submit" class="btn btn-default" align="right" id="manage_edit_submit">Submit</button>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>

<?php include('includes/footer_empty.php'); ?>
