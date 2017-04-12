<?php
include_once "includes/header.php";
include_once "includes/database.php";
include_once "includes/functions.php";

// Check for login status
if (!isset($_SESSION["id"])){
  error('You must be logged in to checkout');
}

checkCardExist($_SESSION["id"]);

function cardOption($cid){
  $row = customerCards($cid);  
  foreach($row as $card){
    $last4 = substr($card["CardNumber"],-4);
    $bid = $card["BillingID"];
    echo "<input type='radio' name='card' value='$bid' required='required'> $last4<br>";
  }
}
?>

  <!-- Main Body Start -->
    
  <h2 class="well">Checkout</h2>
  <h3><strong>Order Total:</strong> <?php echo "$".$_SESSION["total"]; ?></h3>
  <hr>

    <!-- Display Payment Options -->
    <div>
      <form role="form" method="POST" action="confirmation.php">
          <h3>Payment Options</h3>
          <h4>(Last 4 of your credit card number)</h4>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="card">Credit Card</label>
              <?php
                cardOption($_SESSION["id"]);
              ?>
          </div>
          <h3>Delivery Options</h3>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="name">Delivery Method</label>
              <input type="radio" name="delivery" value="Shipping" required="required"> Ship to my address<br>
              <input type="radio" name="delivery" value="Pickup" required="required"> I will pickup my order at the store
          </div>
          <button type="submit" class="btn btn-primary btn-block" style="width:100px">Continue</button>
      </form>
    </div>

  <!-- Main Body End -->

<?php
include_once "includes/footer.php";
?>