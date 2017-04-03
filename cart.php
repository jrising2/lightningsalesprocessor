<?php
include_once "includes/header.php";
include_once "includes/database.php";
include_once "includes/functions.php";
?>

  <!-- Main Body Start -->
    
    <h2>Cart</h2>
    <h3><a id="btnEmpty" href="php/empty.php">Empty Cart</a></h3>


    <div class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-6">Orders</div>
          <div class="col-md-6 text-right"><br>Date/Time Stamp</div>
        </div>
      </div>

      <!-- Cart Items Start -->
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
                    <div class ="col-md-2"><p>Status<br>New/Used/Digital</p></div>
                    <div class="col-md-2 text-right"><br><a href="php/remove.php?id=<?php echo $item["pid"]; ?>">Remove</a></div>
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
          ?>

          	<div style="padding: 15px">
          		<h3><strong>Grand Total:</strong> <?php echo "$".$item_total; ?></h3>
          		<a href="checkout.php"><button type="button" class="btn btn-primary">Checkout</button></a>
      		</div>
    </div>
        <?php
      } else {
    echo "</div>";
      }
      ?>
      <!-- Cart Items End -->

  <!-- Main Body End -->

<?php
include_once "includes/footer.php";
?>