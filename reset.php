<?php
include_once "includes/header.php";
?>

<!-- Main Body Start -->
<div class="row">
  <div class="col-md-4"></div>

    <div class="col-md-4 well" align="center">
      <h2 align="center">Reset Password</h2>
      <br>
      <form role="form" method="POST" action="php/reset_process.php">
          <div class="form-group tight-form-group">
              <label class="sr-only" for="email">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter email ..." required>
          </div>
          <button type="submit" class="btn btn-primary btn-block" style="width:100px">Submit</button>
      </form>
    </div>

  <div class="col-md-4"></div>
</div>
<!-- Main Body End -->

<?php
include_once "includes/footer.php";
?>