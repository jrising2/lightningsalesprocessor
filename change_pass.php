<?php
include_once "includes/header.php";

//Check if the person is logged in before allowing page access
if (isset($_SESSION['id']) == false) {
	header("Location: login.php");
}
?>

        <!-- Main Body Start -->
        <body>
            <?php
            if (isset($_GET['error'])) {
                $ERROR = $_GET['error'];
            }
            if ($ERROR == "1") {
                echo  '<div class="alert alert-danger" role="alert">
                <strong>Error: </strong>Passwords do not match.
                </div>';
            }
            ?>
           <div class="row">
                <div class="col-md-4"></div>
                    <div class="col-md-4">
                    <h2 align="center">Change Password</h2><br>

                    <form role="form" action="change_pass_process.php" method="POST">
                        <div class="form-group">
                            <label for="currentpass">Current Password</label>
                            <input type="password" class="form-control" name="currentpass">
                        </div>
                        <div class="form-group">
                            <label for="newpass">New Password</label>
                            <input type="password" class="form-control" name="newpass">
                        </div>
                        <div class="form-group">
                            <label for="newpass2">Re-enter New Password</label>
                            <input type="password" class="form-control" name="newpass2">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" style="width:100px">Confirm</button>
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>
        </body>
        <!-- Main Body End -->
<?php
include_once "includes/footer.php";
?>