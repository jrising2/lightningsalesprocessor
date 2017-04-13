<?php
include_once "includes/database.php";
include_once "includes/functions.php";
include_once "includes/header.php";
session_start();

// Check for login status
if (!isset($_SESSION["id"])){
  error('You must be logged in to checkout');
}

checkShippingExist($_SESSION["id"]);

$card = billingQuery($_POST["card"]);
$bid = $card["BillingID"];
$name = $card["NameOnCard"];
$number = $card["CardNumber"];
$expm = $card["CardExpirationMonth"];
$expy = $card["CardExpirationYear"];
$sec = decrypt($card["SecurityNumber"],$_SESSION["id"]);
$add1 = $card["BillingAddress1"];
$add2 = $card["BillingAddress2"];
$city = $card["City"];
$state = $card["State"];
$zip = $card["ZipCode"];
$delivery = $_POST["delivery"];
?>
    <h2 class="well">Confirm Order Details</h2>
    <h2>Order Details</h2>
    <h3><a id="btnEmpty" href="cart.php">Edit</a></h3>


    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-6">Orders</div>
          
        </div>
      </div>
      

    <!-- Display Line Items -->
    <?php
    if(isset($_SESSION["cart"])){
        $item_total = 0;

        foreach ($_SESSION["cart"] as $item){
        ?>
          
          <div class="panel-body">
            <div class="row">
              <div class="col-md-2"><a href="productpage.php?id=<?php echo $item['pid'] ?>"><img src="<?php displayImage($item['pid']); ?>" alt="Insert Image here" width="100" height="100"/></a></div>
              <div class="col-md-10">
                <div class="row">
                  <div class ="col-md-2"><p>Price<br>$<?php echo $item["price"]; ?></p></div>
                  <div class="col-md-2"> <p>Quantity<br><?php echo $item["quantity"]; ?></p></div>
                  <div class="col-md-2"> <p>Total<br>$<?php echo $item["quantity"]*$item["price"]; ?></p></div>
                </div>
                <div class="row">
                  <div class="col-md-6"> <pre><?php echo $item["pname"]; ?></pre></div>
                </div>
              </div>
            </div>
          </div>
        <?php
            $item_total += ($item["price"]*$item["quantity"]);
        }
        $_SESSION["total"] = $item_total;
        ?>

          <div style="padding: 15px">
            <h3><strong>Total:</strong> <?php echo "$".$item_total; ?></h3>
          </div>
        </div>
      <?php
    } else {
      echo "</div>";
    }
    ?>

    <!-- Fill Payment Info -->
    <div>
      <form role="form" method="POST" action="php/checkout_process.php">
        <h2>Payment Details</h2>
        <h4>Credit Card</h4>
        <p style="color:red">Make sure to enter security code (3 digit code on back of card) before placing order</p>
        <input type="hidden" name="bid" <?php echo "value='$bid'"; ?>>
        <div class="row">
          <div class="form-group tight-form-group col-md-4">
              <label class="sr-only" for="name">Name</label>Name on Card
              <?php echo "<input type='text' class='form-control' name='name' value='$name' readonly='readonly'>"; ?>
          </div>
          <div class="form-group tight-form-group col-md-4">
              <label class="sr-only" for="number">Credit Card Number</label>Credit Card Number
              <?php echo "<input type='text' class='form-control' name='number' value='$number' readonly='readonly'>"; ?>
          </div>
        </div>
        <div class="row">
          <div class="form-group tight-form-group col-md-2">
              <label class="sr-only" for="exp">Expiration Month</label>Expiration Month
              <?php echo "<input type='text' class='form-control' name='expm' value='$expm' readonly='readonly'>"; ?>
          </div>
          <div class="form-group tight-form-group col-md-2">
              <label class="sr-only" for="exp">Expiration Year</label>Expiration Year
              <?php echo "<input type='text' class='form-control' name='expy' value='$expy' readonly='readonly'>"; ?>
          </div>
          <div class="form-group tight-form-group col-md-2">
              <label class="sr-only" for="exp">Security Code</label>Security Code
              <input type='text' class='form-control' name='sec' required='required'>
          </div>
        </div>

        <h4>Billing Address</h4>
        <div class="row">
          <div class="form-group tight-form-group col-md-4">
              <label class="sr-only" for="address1">Address 1</label>Address 1
              <?php echo "<input type='text' class='form-control' name='address1' value='$add1' readonly='readonly'>"; ?>
          </div>
          <div class="form-group tight-form-group col-md-4">
              <label class="sr-only" for="address2">Address 2</label>Address 2
              <?php echo "<input type='text' class='form-control' name='address2' value='$add2' readonly='readonly'>"; ?>
          </div>
        </div>
        <div class="row">
          <div class="form-group tight-form-group col-md-4">
              <label class="sr-only" for="city">City</label>City
              <?php echo "<input type='text' class='form-control' name='city' value='$city' readonly='readonly'>"; ?>
          </div>
          <div class="form-group tight-form-group col-md-2">
              <label class="sr-only" for="state">State</label>State
              <?php echo "<input type='text' class='form-control' name='state' value='$state' readonly='readonly'>"; ?>
          </div>
          <div class="form-group tight-form-group col-md-2">
              <label class="sr-only" for="zip">Zip Code</label>Zip Code
              <?php echo "<input type='text' class='form-control' name='zip' value='$zip' readonly='readonly'>"; ?>
          </div>
        </div>

        <h2>Delivery Method</h2>
        <div class="row">
          <div class="form-group tight-form-group col-md-2">
              <label class="sr-only" for="zip">Delivery Method</label>
              <?php echo "<input type='text' class='form-control' name='delivery' value='$delivery' readonly='readonly'>"; ?>
          </div>
        </div>

          <button type="submit" class="btn btn-primary btn-block" style="width:100px" onclick="return confirm('Are you sure you want to place this order?');">Place Order</button>
      </form>
    </div>

<?php
include_once "includes/footer.php";
?>