<?php include('includes/header.php'); ?>
	
	<div style="text-align:center">
		<form method="POST" action="catalog.php">
			<input type="text" name="search" style="width:500px" />
			<input type="submit" name="submit" value="Search" />
		</form>
	</div>
	<hr />

<?php
require_once('config/database.php');
if(isset($_POST['submit'])){
	$search = $link->real_escape_string($_POST['search']);
	$result = $link->query("SELECT ProductName, Genre, ISBN, Price FROM Products 
		WHERE ProductName LIKE '%$search%' OR ISBN LIKE '%$search%'");
	if($result->num_rows > 0){
		$rowCount = 0;
		$colCount = 0;
		echo '<div class="row" style="padding-left:125px">';
		while($rows = $result->fetch_assoc()){
			$ProductName = $rows['ProductName'];
			$Genre = $rows['Genre'];
			$ISBN = $rows['ISBN'];
            $Price = $rows['Price'];
			
			if($rowCount % 4 == 0){
				echo '<div class="row">';
				$colCount = 1;
			}
		
			echo "<div class='col-md-3' style='width:250px'><img src='image/$ISBN.jpg'><br><br>".
						"<strong>Name:</strong> $ProductName <br>".
						"<strong>Genre:</strong> $Genre <br>".
						"<strong>ISBN:</strong> $ISBN <br>".
                       	"<strong>Price:</strong> $Price <br><br>".
						"</div>";
						
			if($colCount == 4){
				echo "</div>";
			}
			$rowCount++; 
			$colCount++;
		}
		echo '</div></p>';
	}else{
		echo "<div style='text-align:center'>No results were found.</div>";
	}
}
include('includes/footer.php'); 
?>
