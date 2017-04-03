<?php
include_once "includes/employee_header.php";
?>

<!-- Main Body Start -->
<div class="row">
  <div class="col-md-4"></div>
    <div class="col-md-4 well" align="center">
      <h2 align="center">Login</h2><br>
      <form role="form" method="POST" action="php/employee_login_process.php">
        <div class="form-group tight-form-group">
          <label class="sr-only" for="eid">Employee ID</label>Employee ID
          <input type="text" class="form-control" name="eid" placeholder="Enter employee ID ...">
        </div>
        <div class="form-group tight-form-group">
          <label class="sr-only" for="pass">Password</label>Password
          <input type="password" class="form-control" name="epass" placeholder="Enter password ...">
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="width:100px">Submit</button>
      </form>
    </div>
  <div class="col-md-4"></div>
</div>
<!-- Main Body End -->

<?php
include_once "includes/footer_empty.php";
?>