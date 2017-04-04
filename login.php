<?php
include_once "includes/header.php";
?>

<!-- Main Body Start -->
<div class="row">
  <div class="col-md-4"></div>
    <div class="col-md-4 well" align="center">
      <h2 align="center">Login</h2><br>
      <form role="form" method="POST" action="php/login_process.php">
        <div class="form-group tight-form-group">
          <label class="sr-only" for="email">Email</label>
          <input type="text" class="form-control" name="email" placeholder="Enter email ...">
        </div>
        <div class="form-group tight-form-group">
          <label class="sr-only" for="pass">Password</label>
          <input type="password" class="form-control" name="pass" placeholder="Enter password ...">
        </div>
        <button type="submit" class="btn btn-primary btn-block" style="width:100px">Submit</button>
        <br>
        <p>Don't have an account already? <a href="register.php">Register</a> for one!</p>
        <p>Forgot your password? <a href="reset.php">Reset</a> your password!</p>
      </form>
    </div>
  <div class="col-md-4"></div>
</div>
<!-- Main Body End -->

<?php
include_once "includes/footer.php";
?>