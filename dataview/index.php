<?php
include_once "../includes/database.php";
$table = $_POST["table"];
$sql = "SELECT * FROM $table";
$result = mysqli_query($link,$sql);
$rows = array();
  while ($row = mysqli_fetch_assoc($result)){
      $rows[] = $row;
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>

<!-- Main Body Start -->

<form role="form" method="POST" action="<?=$_SERVER['PHP_SELF']?>"> 
  <div class="form-group tight-form-group">
    <input type="radio" name="table" value="Billing" required="required"> Billing<br>
    <input type="radio" name="table" value="Customers" required="required"> Customers<br>
    <input type="radio" name="table" value="Employees" required="required"> Employees<br>
    <input type="radio" name="table" value="Products" required="required"> Products<br>
    <input type="radio" name="table" value="Roles" required="required"> Roles<br>
    <input type="radio" name="table" value="Transactions" required="required"> Transactions 
  </div>
  <button type="submit" class="btn btn-primary btn-block" style="width:100px">View Data</button>
</form>

<?php
echo '<pre>'; print_r($rows); echo '</pre>';
?>

<!-- Main Body End -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>

</html>