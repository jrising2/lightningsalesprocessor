<?php
include_once "includes/header.php";
include_once "includes/database.php";
include_once "includes/functions.php";
?>

  <!-- Main Body Start -->
    
    <h2>Order Details</h2>
    <h3><a id="btnEmpty" href="cart.php">Edit Cart</a></h3>


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

    <!-- Display Payment Options -->
    <div>
      <h2>Payment Options</h2>
      <form role="form" method="POST" action="php/checkout_process.php">
          <h4>Billing Address</h4>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="address1">Address 1</label>Address 1
              <input type="text" class="form-control" name="address1" placeholder="1234 My St.">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="address2">Address 2</label>Address 2
              <input type="text" class="form-control" name="address2" placeholder="Apt #123">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="city">City</label>City
              <input type="text" class="form-control" name="city" placeholder="City">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="state">State</label>State
              <input type="text" class="form-control" name="state" placeholder="ST">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="zip">Zip Code</label>Zip Code
              <input type="text" class="form-control" name="zip" placeholder="12345">
          </div>
          <h4>Credit Card Info</h4>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="name">Name</label>Name on Card
              <input type="text" class="form-control" name="name" placeholder="Your name as it appears on the card">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="number">Credit Card Number</label>Credit Card Number
              <input type="text" class="form-control" name="number">
          </div>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="exp">Expiration</label>Expiration
              <input type="text" class="form-control" name="exp" placeholder="03/17">
          </div>
          <h4>Delivery Method</h4>
          <div class="form-group tight-form-group">
              <label class="sr-only" for="name">Delivery Method</label>
              <input type="radio" name="delivery" value="Shipping" checked="checked"> Ship to my address<br>
              <input type="radio" name="delivery" value="Pickup"> I will pickup my order at the store
          </div>
          <button type="submit" class="btn btn-primary btn-block" style="width:100px">Purchase</button>
      </form>
    </div>

  <!-- Main Body End -->

<?php
include_once "includes/footer.php";
?>