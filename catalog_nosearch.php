<html>
	<body>
		<br><br>
		<hr/>
   
		<div class="dropdown" style="text-align:center">
			<input type="text" style="width:500px">
			<button type="submit" class="btn btn-default">Search</button>
		</div>
	
		<hr />
   
		<div style="text-align:center">
		<?php
			$host = 'localhost';
			$user = 'root';
			$pass = '';
   
			$conn = mysql_connect($host, $user, $pass);
   
			if(!$conn){
				die('Could not connect: ' . mysql_error());
			}
   
			$sql = 'SELECT ProductID, ProductName, Genre, ISBN, Stock, Description FROM products';
			mysql_select_db('epiz_19723230_lightnsalesproc');
			$retval = mysql_query($sql,$conn);
   
			if(!$retval){
				die('Could not get data: ' . mysql_error());
			}

			$rowCount=0;
			$colCount=0;
			echo '<table align="center"><tr>';
			while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
				if($rowCount%4==0){
					echo "<tr>";
					$colCount=1;
				}
				// Change ISBN to Price
				echo "<td style='width:220px'><img src='http://placehold.it/200x200'><br><br>".
						"<strong>Name:</strong> {$row['ProductName']}<br>".
						"<strong>Genre:</strong> {$row['Genre']}<br>".
						"<strong>ISBN:</strong> {$row['ISBN']}<br><br>".
						"</td>";
				if($colCount==4){
					echo "</tr>";
				}
				$rowCount++; 
				$colCount++; 
			}
			echo '</tr></table>';
   
			mysql_close($conn);
		?>
		</div>
	
		<hr />
		<br /><br />
   </body>
</html>
