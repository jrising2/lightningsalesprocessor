<?php
include_once "includes/header.php";
?>

<!-- Main Body Start -->
<div class="row">
  <div class="col-md-4"></div>

    <div class="col-md-4 well" align="center">
      <h2 align="center">Register</h2>
      <p>This is not a real site and you should NOT provide your real information except your email for testing purposes</p>
      <br>
      <form role="form" method="POST" action="php/register_process.php">
          <div class="form-group tight-form-group">
              <label class="sr-only" for="fname">First Name</label>
              <input type="text" class="form-control" name="fname" placeholder="Enter first name ... (required)" required="required">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="lname">Last Name</label>
              <input type="text" class="form-control" name="lname" placeholder="Enter last name ... (required)" required="required">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="email">Email</label>
              <input type="email" class="form-control" name="email" placeholder="Enter email ... (required)" required="required">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="pass">Choose Password</label>
              <input type="password" class="form-control" name="pass" placeholder="Choose password ... (required)" required="required">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="passrp">Repeat Password</label>
              <input type="password" class="form-control" name="passrp" placeholder="Repeat password ... (required)" required="required">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="address1">Address 1</label>
              <input type="text" class="form-control" name="address1" placeholder="Enter address 1 ... (required)" required="required">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="address2">Address 2</label>
              <input type="text" class="form-control" name="address2" placeholder="Enter address 2 ... (optional)">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="city">City</label>
              <input type="text" class="form-control" name="city" placeholder="Enter city ... (required)" required="required">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="state">State</label>
              Select your state (required)
              <select type="text" class="form-control" name="state" required="required">
                  <?php
                      $st = array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming");
                      for ($i = 0; $i < 50; $i++) {
                          if (strtolower($st[$i]) == strtolower($row['State'])) {
                              echo "<option value=" . $st[$i] . " selected>" . $st[$i] . "</option>";
                          } else {
                              echo "<option value=" . $st[$i] . ">" . $st[$i] . "</option>";
                          }
                      }
                  ?>
              </select>
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="zip">Zip Code</label>
              <input type="text" class="form-control" name="zip" placeholder="Enter zip code ... (required)" required="required">
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