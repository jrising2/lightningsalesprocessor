<?php
include_once "includes/header.php";
include_once "includes/functions.php";

$maxpid = maxpid();
?>

<!-- Main Body Start -->
<div id="homebody" class="tab-pane fade in active">
    <h2>Home</h2>
    <hr>
    <div class="panel-body">
        <div class="row">
            <em><h3>Recently Added</h3></em><br>
            <div class="col-md-3">
                <a href="productpage.php?id=<?php echo $maxpid; ?>"><img class="img-responsive" style="height: 20em;"  src="<?php displayImage($maxpid) ?>">
                    <h4>
                        <?php
                            displayTitle($maxpid);
                        ?>
                    </h4>
                </a>
            </div>
            <div class="col-md-3">
                <a href="productpage.php?id=<?php echo $maxpid-1; ?>"><img class="img-responsive" style="height: 20em;"  src="<?php displayImage($maxpid-1) ?>">
                    <h4>
                        <?php
                            displayTitle($maxpid-1);
                        ?>
                    </h4>
                </a>
            </div>
            <div class="col-md-3">
                <a href="productpage.php?id=<?php echo $maxpid-2; ?>"><img class="img-responsive" style="height: 20em;"  src="<?php displayImage($maxpid-2) ?>">
                    <h4>
                        <?php
                            displayTitle($maxpid-2);
                        ?>
                    </h4>
                </a>
            </div>
            <div class="col-md-3">
                <a href="productpage.php?id=<?php echo $maxpid-3; ?>"><img class="img-responsive" style="height: 20em;"  src="<?php displayImage($maxpid-3) ?>">
                    <h4>
                        <?php
                            displayTitle($maxpid-3);
                        ?>
                    </h4>
                </a>
            </div>
        </div>
        <hr>
<!--        <div class="row">-->
<!--            <em><h3>On Sale</h3></em>-->
<!--            <div class="col-md-3">-->
<!--                <a href="#"><img clas="img-responsive" style="height: 20em;"  src="http://placehold.it/200x200">-->
<!--                    <p>Title <span class="text-danger">10% Off</span></p>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <a href="#"><img clas="img-responsive" style="height: 20em;"  src="http://placehold.it/200x200">-->
<!--                    <p>Title <span class="text-danger">10% Off</span></p>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <a href="#"><img clas="img-responsive" style="height: 20em;"  src="http://placehold.it/200x200">-->
<!--                    <p>Title <span class="text-danger">10% Off</span></p>-->
<!--                </a>-->
<!--            </div>-->
<!--            <div class="col-md-3">-->
<!--                <a href="#"><img clas="img-responsive" style="height: 20em;"  src="http://placehold.it/200x200">-->
<!--                    <p>Title <span class="text-danger">10% Off</span></p>-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->
</div>
<!-- Main Body End -->

<?php
include_once "includes/footer.php";
?>
