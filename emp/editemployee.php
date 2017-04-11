<?php 
include('includes/employee_header.php'); 
require_once('config/database.php');
?>

	<!-- Changes I will be working on:
		- How passwords are stored? Might be fine?
		- Prevent refreshes from adding info again.
		- Making the edit & delete employees sections a little neater.
		- Making sure only employees with the proper role(s) have access.
		- Add error messages when appropriate.
		- Verify that when id/role # are input, that they are ints.
		- Also, minor changes to various things.
	-->
	
	<div class="row">
		<div class="col-md-12">
			<h3>Add Employee</h3>
			<hr />
		</div>
	</div>
		
	<?php
		// Prepared statements for adding, editing, and deleting to prevent sql injections.
		// Can always change to mysqli_real_escape_string, but I wanted to try something different.
		
		// ADD EMPLOYEE
		if(isset($_POST['btnAdd'])){
			$Pass = md5($_POST['Password']);
			$sql = "INSERT INTO Employees (FirstName, LastName, Role, Password) VALUES (?,?,?,?)";
			$stmt = mysqli_prepare($link, $sql);
			$stmt->bind_param("ssss", $_POST['FirstName'], $_POST['LastName'], $_POST['Role'], $Pass);
			$stmt->execute();
			$stmt->close();
		}
		
		// EDIT EMPLOYEE
		if(isset($_POST['btnSubmitEdit'])){
			$Pass = md5($_POST['Password']);
			$stmt = $link->prepare("UPDATE Employees SET FirstName = ?, LastName = ?, Role = ?, Password = ? WHERE EmployeeID = ?");
			$stmt->bind_param("sssss", $_POST['FirstName'], $_POST['LastName'], $_POST['Role'], $Pass, $_POST['EmployeeID']);
			$stmt->execute();
			$stmt->close();
		}
		
		// DELETE EMPLOYEE
		if(isset($_POST['btnConfirmDel'])){
			$stmt = $link->prepare("DELETE FROM Employees WHERE EmployeeID = ?");
			$stmt->bind_param('i', $_POST['confirmdel']);
			$stmt->execute(); 	
			$stmt->close();
		}
	?>
	
	<!-- Add Employee Form -->
	<form method="post"> 
		<div class="row">

		<!-- First name field -->
			<div class="col-md-3">
				<div class="form-group">
					<label for="fname">First Name:</label>
					
					<input type="text" class="form-control" name="FirstName" style="width:263px">
				</div>
			</div>
				
		<!-- Last name field -->
			<div class="col-md-3">
				<div class="form-group">
					<label for="lname">Last Name:</label>
					<input type="text" class="form-control" name="LastName" style="width:263px">
				</div>
			</div>
			
		<!-- Role field -->
			<div class="col-md-3">
				<div class="form-group">
					<label for="role">Role:</label>
					<input type="text" class="form-control" name="Role" style="width:263px">
				</div>
			</div>
				
		<!-- Password field -->
			<div class="col-md-3">
				<div class="form-group">
					<label>Password:</label>
					<input type="password" class="form-control" name="Password" style="width:263px">
				</div>
			</div>
			
		<!-- Add Employee Button -->
			<div class="row" style="padding-right:15px">
				<div class="col-md-12" style="text-align:right">
					<button type="submit" class="btn btn-default" name="btnAdd" action="editemployee.php" style="width:121px">Add Employee</button>
				</div>
			</div>
		</div>
	</form>
	<!-- End Of Form -->
		
	<hr />

	<div class="row">
		<!-- EDIT EMPLOYEE FORM -->
		<div class="col-md-6">
			<h3>Edit Employee</h3>
			<hr />
			<label>Employee ID:</label>
			<form class="form-inline" method="post">
				<div class="form-group"> 
					<input type="text" class="form-control" name="editemp" style="width:138px">		
				</div>
				<button type="submit" class="btn btn-default" name="btnEmpIDEdit" action="editemployee.php" style="width:121px">Edit Employee</button>
			</form>
			<?php
				if(isset($_POST['btnEmpIDEdit'])){
					$check = $link->real_escape_string($_POST['editemp']);
					$sql = $link->query("SELECT EmployeeID, FirstName, LastName, Role, Password FROM Employees WHERE EmployeeID LIKE '%$check%'");
						
					if($sql->num_rows > 0){
						$row = $sql->fetch_assoc();	
						$First = $row['FirstName'];
						$Last = $row['LastName'];
						$Role = $row['Role'];
			?>
		
			<form class="form-inline" action="editemployee.php" method="post">
				<div class="form-group"><br />
					<label>Employee ID:</label><br />
					<input type="text" class="form-control" name="EmployeeID" value="<?php echo $check; ?>" readonly><br /><br />
				
					<label>First Name:</label><br />
					<input type="text" class="form-control" name="FirstName" value="<?php echo $First; ?>"><br /><br />
								
					<label>Last Name:</label><br />
					<input type="text" class="form-control" name="LastName" value="<?php echo $Last; ?>"><br /><br />
							
					<label>Role:</label><br />
					<input type="text" class="form-control" name="Role" value="<?php echo $Role; ?>"><br /><br />
							
					<label>Password:</label><br />
					<input type="password" class="form-control" name="Password"><br /><br />
					
					<button type="submit" class="btn btn-default" name="btnSubmitEdit" style="width:121px">Confirm Edit</button>
				</div>
			</form>
			
			<?php
					}else{
						echo "No results were found.";
					}
				}
			?>
		</div>
				
		<!-- DELETE EMPLOYEE FORM -->
		<div class="col-md-6">
			<h3>Delete Employee</h3>
			<hr />
			<label for="delempid">Employee ID:</label>
			<form class="form-inline" action="editemployee.php" method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="del" style="width:138px">
				</div>
				<button type="submit" class="btn btn-default" name="btnVerifyDel" style="width:121px">Verify Delete</button>
			</form>
			<?php 
				if(isset($_POST['btnVerifyDel'])){
					$check = $link->real_escape_string($_POST['del']);
					$sql = $link->query("SELECT EmployeeID, FirstName, LastName, RoleName  
						FROM Employees INNER JOIN Role ON Employees.Role = Role.RoleID 
						WHERE EmployeeID LIKE '%$check%'");
		
					if($sql->num_rows > 0){
						echo '<br /><label>Is this the employee you want to delete?:</label><br />';
						
						$row = $sql->fetch_assoc();	
						$ID = $row['EmployeeID'];
						$First = $row['FirstName'];
						$Last = $row['LastName'];
						$Role = $row['RoleName'];
							
						echo "Employee ID: $ID <br />";
						echo "Name: $First $Last<br />";
						echo "Role: $Role <br /></br>";
						
						echo '<label>Please re-enter the employee id:</label>';
			?>
		
			<form class="form-inline" action="editemployee.php" method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="confirmdel" style="width:138px">
				</div>
				<button type="submit" class="btn btn-default" name="btnConfirmDel" style="width:121px">Confirm Delete</button>
			</form>
			
			<?php
					}else{
						echo "No results were found.";
					}
				}
			?>
		</div>
	</div>
		
	<hr />
	<br />

<?php include('includes/footer_empty.php'); ?>
