<?php 
include('includes/employee_header.php'); 
require_once('config/database.php');
?>

	<!-- Changes I will be working on:
		- How password are done.
			- http://php.net/manual/en/function.openssl-encrypt.php
		- Making sure only employees with the proper role(s) have access.
		- Get role names from a query for the small note under edit role
		
		On hold / better left for last:
		- Prevent refreshes from adding info again.
	-->
		
	<div class="row">
		<div class="col-md-12">
			<h3>Add Employee</h3>
			<hr />
		</div>
	</div>

	<?php 
		$error = "";
		$isValid = true;
		
		function check($input){
			$input = trim($input);
			return $input;
		}
	
		if(isset($_POST['btnSubmitEdit']) || isset($_POST['btnAdd'])){			
			$fname = check($_POST['FirstName']);
			$lname = check($_POST['LastName']);
			$role = check($_POST['Role']);
					
			// Checks that each field is not empty, and checks if it matches the field requirements.
			if(empty($_POST['FirstName']) || !preg_match("/^[a-zA-Z]*$/", $fname)){
				$error .= "<br />First name is a required field and only letters are allowed.";
				$isValid = false;
			}
			if(empty($_POST['LastName']) || !preg_match("/^[a-zA-Z]*$/", $lname)){
				$error .= "<br />Last name is a required field and only letters are allowed.";
				$isValid = false;
			}
			if(empty($_POST['Role']) || !preg_match("/^[1-3]*$/", $role)){
				$error .= "<br />Role is a required field, and only accepts a number pertaining to a role. (1-3)";
				$isValid = false;
			}
			if(empty($_POST['Password'])){
				$error .= "<br />Password is a required field.";
				$isValid = false;
			}
					
			if($isValid){
				if(isset($_POST['btnAdd'])){
					$Pass = md5($_POST['Password']);
					$sql = "INSERT INTO Employees (FirstName, LastName, Role, Password) VALUES (?,?,?,?)";
					$stmt = mysqli_prepare($link, $sql);
					$stmt->bind_param("ssss", $_POST['FirstName'], $_POST['LastName'], $_POST['Role'], $Pass);
					$stmt->execute();
					$stmt->close();
				}else if(isset($_POST['btnSubmitEdit'])){
					$Pass = md5($_POST['Password']);
					$stmt = $link->prepare("UPDATE Employees SET FirstName = ?, LastName = ?, Role = ?, Password = ? WHERE EmployeeID = ?");
					$stmt->bind_param("sssss", $_POST['FirstName'], $_POST['LastName'], $_POST['Role'], $Pass, $_POST['EmployeeID']);
					$stmt->execute();
					$stmt->close();
				}
			}			
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
					<?php 
						if(isset($_POST['btnAdd'])){
							if($isValid){
								echo "<br />Success! Employee has been added.";
							}else{
								echo "<font color='red'><strong><br />Employee has not been added.<br />$error</strong></font>";
							}
						}
					?>
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
				<button type="submit" class="btn btn-default" name="btnEmpIDEdit" style="width:121px">Edit Employee</button>
			</form>
			<?php
				if(isset($_POST['btnEmpIDEdit'])){
					$check = $link->real_escape_string($_POST['editemp']);
					$sql = $link->query("SELECT EmployeeID, FirstName, LastName, Role, Password 
						FROM Employees 
						WHERE EmployeeID LIKE '$check'");
						
					if($sql->num_rows > 0){
						$row = $sql->fetch_assoc();	
						$First = $row['FirstName'];
						$Last = $row['LastName'];
						$Role = $row['Role'];
						$Pass = $row['Password'];
			?>
		
			<form class="form-inline" method="post">
				<div class="form-group"><br />
					<label>Employee ID:</label><br />
					<input type="text" class="form-control" style="width:525px" name="EmployeeID" value="<?php echo $check; ?>" readonly><br /><br />
					
					<label>First Name:</label><br />
					<input type="text" class="form-control" style="width:525px" name="FirstName" value="<?php echo $First; ?>"><br />
					<small class="form-text text-muted">Please enter the employee's first name.</small><br /><br />
					
					<label>Last Name:</label><br />
					<input type="text" class="form-control" style="width:525px" name="LastName" value="<?php echo $Last; ?>"><br />
					<small class="form-text text-muted">Please enter the employee's last name.</small><br /><br />
							
					<label>Role:</label><br />
					<input type="text" class="form-control" style="width:525px" name="Role" value="<?php echo $Role; ?>"><br />
					<small class="form-text text-muted">1 = General Manager, 2 = Product Manager, 3 = Bookseller</small><br /><br />
							
					<label>Password:</label><br />
					<input type="password" class="form-control" style="width:525px" name="Password"><br />
					<small class="form-text text-muted">Please enter a password for the employee.</small><br /><br />	
					
					<button type="submit" class="btn btn-default" name="btnSubmitEdit" style="width:121px">Confirm Edit</button>
					<br />
				</div>
			</form>
			
			<?php
					}else{
						echo "<br />No results that match <strong>$check</strong> were found.";
					}
				}	

				if(isset($_POST['btnSubmitEdit'])){
					$check = $_POST['EmployeeID'];
					if($isValid){
						echo "<br />Success! Employee $check has been edited.";
					}else{
						$editerror = "<br />Employee #$check has not been edited.";
						echo "<font color='red'><strong>$editerror<br />$error</strong></font>";
					}
				}
			?>		
		</div>
		
		<!-- DELETE EMPLOYEE FORM -->
		<div class="col-md-6">
			<h3>Delete Employee</h3>
			<hr />
			<label for="delempid">Employee ID:</label>
			<form class="form-inline" method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="verifydel" style="width:138px">
				</div>
				<button type="submit" class="btn btn-default" name="btnVerifyDel" style="width:121px">Verify Delete</button>
			</form>
			<?php 
				if(isset($_POST['btnVerifyDel'])){
					$check = $link->real_escape_string($_POST['verifydel']);
					$sql = $link->query("SELECT EmployeeID, FirstName, LastName, RoleName  
						FROM Employees INNER JOIN Role ON Employees.Role = Role.RoleID 
						WHERE EmployeeID LIKE '$check'");
		
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
				
						echo '<label>Please verify that the above information is correct:</label>';
			?>
		
			<form class="form-inline" method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="confirmdel" value="<?php echo $ID; ?>" readonly style="width:138px">
				</div>
				<button type="submit" class="btn btn-default" name="btnConfirmDel" style="width:121px">Confirm Delete</button>
			</form>
			
			<?php
					}else{
						echo "<br />No results that match <strong>$check</strong> were found.";
					}
				}
			?>
		</div>
	</div>

	<hr />
	<br />
<?php include('includes/footer_empty.php'); ?>
