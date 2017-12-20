<?php
session_start();
if (isset($_SESSION["eid"])){
  header("Location: tracking.php");
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
<div class="row">
  <div class="col-md-3"></div>
    <div class="col-md-6 well" align="center">
      <h2 align="center">Book Store Sales Management System</h2>
      <h3 align="center">Employee Login</h3><br>
      <form role="form" method="POST" action="php/employee_login_process.php">
        <div class="form-group tight-form-group">
          <label class="sr-only" for="eid">Employee ID</label>
          Employee ID<input type="text" name="eid">
        </div>
        <div class="form-group tight-form-group">
          <label class="sr-only" for="pass">Password</label>
          Password<input type="password" name="epass">
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="width:100px">Submit</button>
      </form>
    </div>
  <div class="col-md-3"></div>
</div>
<!-- Main Body End -->

<?php
include_once "includes/footer_empty.php";
?>