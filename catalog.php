<?php
$output = NULL;

if(isset($_POST['submit'])){
	$mysqli = NEW MySQLi("localhost", "root", "", "epiz_19723230_lightnsalesproc");

	$search = $mysqli->real_escape_string($_POST['search']);

	$result = $mysqli->query("SELECT ProductName, Genre, ISBN FROM products WHERE ProductName LIKE '%$search%'");

	if($result->num_rows > 0){
		$rowCount = 0;
		$colCount = 0;
		echo '<table align="center"><tr>';
		while($rows = $result->fetch_assoc()){
			$ProductName = $rows['ProductName'];
			$Genre = $rows['Genre'];
			$ISBN = $rows['ISBN'];
			
			if($rowCount % 4 == 0){
				$output .= "<tr>";
				$colCount = 1;
			}
			
			// Change ISBN to Price
			$output .= "<td style='width:220px'><img src='http://placehold.it/200x200'><br><br>".
						"<strong>Name:</strong> $ProductName <br>".
						"<strong>Genre:</strong> $Genre <br>".
						"<strong>ISBN:</strong> $ISBN <br><br>".
						"</td>";
						
			if($colCount == 4){
				$output .= "</tr>";
			}
			$rowCount++; 
			$colCount++;
		}
	}else{
		$output = "No results were found.";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head></head>
	
	<body>
	
		<br />
		<div style="text-align:center">
			<form method="POST" action="catalog.php">
				<input type="text" name="search" style="width:500px" />
				<input type="submit" name="submit" value="Search" />
			</form>
			<br />
		</div>
		<hr />
		
		<?php echo $output; ?>
		
	</body>
</html>
