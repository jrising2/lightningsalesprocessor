<?php
include "../includes/database.php";
include "includes/employee_header.php";
?>
        <!--Main body to seperate employee_header-->
        <!-- As stated on the edit_employee_info page, this page is setup the same,
        with the exception of names being slightly different. -->

        <?php
		//Check if the person is logged in before allowing page access
		if (isset($_SESSION['eid']) == false) {
			header("Location: index.php");
		}
        //Get current employee role
        $ROLE;
        $temp = mysqli_query($link, "SELECT Role FROM Employees WHERE EmployeeID={$_SESSION['eid']}");
        if (mysqli_num_rows($temp) > 0) {
            $r = mysqli_fetch_assoc($temp);
            $ROLE = $r['Role'];
        }
		//check if the current employee has priviledges to access the page
		if (($ROLE == '1') || ($ROLE == '2')) {
		}else{
			header("Location: tracking.php");
		}
		
        //database  link
        global $link;
        //ManageBooks Globals
        $qry; //current search qry by default will qry all items
        $result;  //result of the above qry (may need to be page_results)
        $rows; //a collection of all the rows to be fetched by the result of the qry

        //Get information from super globals
        $ID = (!isset($_GET['product']))? "" : $_GET['product'];
        $ERROR;
        $SUCCESS;
        if (isset($_GET['error'])) {
            $ERROR = $_GET['error'];
        }
        if (isset($_GET['redirect_success'])) {
            $SUCCESS = $_GET['redirect_success'];
        }

        $qry = "SELECT ProductID, ProductName, ISBN, Stock FROM Products";
        if ($ID != "") {
            $qry = $qry . " WHERE ProductID={$ID}";
            $result = mysqli_query($link, $qry);
            $row = mysqli_fetch_assoc($result);
        }
        //if redirected look for errors
        if ($ERROR == "1"){
             echo  '<div class="alert alert-danger" role="alert">
                    <strong>Error: </strong>Error occured while Adding or Editing a product.
                </div>';
        }else if ($ERROR == "2") {
             echo  '<div class="alert alert-warning" role="alert">
                    <strong>Error: </strong>Please select a record before deleting.
                </div>';
        } else if ($ERROR =="3"){
            echo '<div class="alert alert-danger" role="alert">
                    <strong>System Error: </strong> Error occured while deleting the record.
                </div>';
        } else if ($ERROR == "4"){
              echo '<div class="alert alert-warning" role="alert">
                    <strong>Error: </strong> Please enter or select a ProductID before editing or adding a product.
                </div>';
        } else if ($ERROR == "5"){
            echo '<div class="alert alert-danger" role="alert">
                        <strong>System Error: </strong> Error occured while uploading file to the server.
                </div>';
        } else if ($ERROR == "6"){
            echo '<div class="alert alert-danger" role="alert">
                        <strong>System Error: </strong> Failure to connect to the server when attempting to upload file.
                </div>';
        }
        //if redirected look for successful edit or deletes
        if ($SUCCESS == 1) {
            echo '<div class="alert alert-success" role="alert">
                    <strong>Product edited succesfully!</strong>
                </div>';
        }else if ($SUCCESS == "2") {
               echo '<div class="alert alert-success" role="alert">
                    <strong>Product added successfully!</strong>
                </div>';
        }else if ($SUCCESS == "3") {
               echo '<div class="alert alert-success" role="alert">
                    <strong>Product deleted successfully!</strong>
                </div>';
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <h3>Add/Edit Book</h3>
                <hr />
            </div>
        </div>

        <form enctype="multipart/form-data" action="managebooks_process.php" method="POST">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="prodid">Product ID:</label>
                        <?php
                            if ($ID != "") {
                                echo '<input type="text" class="form-control" name="prodid" style="width:263px" value="'. $row['ProductID'] .'">';
                            } else {
                                 echo '<input type="text" class="form-control" name="prodid" style="width:263px">';
                            }
                        ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <?php
                            if ($ID != "") {
                                echo '<input type="text" class="form-control" name="title" style="width:263px" value="'. $row['ProductName'] .'">';
                            } else {
                                 echo '<input type="text" class="form-control" name="title" style="width:263px">';
                            }
                        ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="isbn">ISBN:</label>
                        <?php
                            if ($ID != "") {
                                echo '<input type="text" class="form-control" name="isbn" style="width:263px" value="'. $row['ISBN'] .'">';
                            } else {
                                 echo '<input type="text" class="form-control" name="isbn" style="width:263px">';
                            }
                        ?>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="stock">Amount In Stock:</label>
                        <?php
                            if ($ID != "") {
                                echo '<input type="text" class="form-control" name="stock" style="width:263px" value="'. $row['Stock'] .'">';
                            } else {
                                 echo '<input type="text" class="form-control" name="stock" style="width:263px">';
                            }
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- TO INSERT A IMAGE UPLOAD-->
                <div class="col-md-6">
                    <div class="form form-group">
                        <label for="upload">Upload Image File:</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="204800" />
                        <input type="text" class="form-control" name="upload" id="upload" style="width:400px">
                        <input type="file" id="userfile" name="userfile" onchange="getFile()" accept="image/*" style="display: none;">
                        <br>
                        <input class="btn btn-default" value="Browse..." onclick="document.getElementById('userfile').click()" style="width:85px;height:30px;">
                    </div>
                </div>
                <script type="text/javascript">
                    function getFile() {
                        var upload = document.getElementById("userfile");
                         if ('files' in upload) {
                            if (upload.files.length != 0) {
                                var file = upload.files[0];
                                var objectURL = window.URL.createObjectURL(file);
                                console.log(file);
                                document.getElementById("upload").value = file.name;
                            }
                        }
                    }
                </script>
                <div class="col-md-6" style="text-align:right">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
            </div>
            <input type="hidden" name="edit_add" value="">
        </form>

        <div class="row">
            <div class="col-md-6">
                <!-- The idea with this is to input the book id and then the relevant information
                appears in the above section's input boxes to be edited. That's the idea I had for it at least.
                It can always be changed if another setup would be better. -->
                <h3>Choose Book to Edit</h3>
                <hr/>

                <!--This form allow for the lookup of a book by id-->
                <form role="form" class="form-inline" method="POST" action="managebooks_process.php">
                    <div class="form-group">
                        <label for="editbookid">Book ID:</label>
                        <input type="text" class="form-control" name="editbookid" style="width:200px">
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>
                    <input type="hidden" name="id_lookup" value="">
                </form>
            </div>

            <!-- Type in a book id, then the information about that book is displayed in the read only input box.
            The idea is to have verification that the correct employee is being deleted to prevent accidental deletions.

            This also assumes we even want to delete books from the system. I wasn't sure if we wanted this, but since
            it was pretty much copy/paste job from the other page, I included it just in case. -->
            <div class="col-md-6">
                <h3>Delete Book</h3>
                <hr />
                <br />

                <form method="POST" action="managebooks_process.php">
                    <div class="form-group">
                        <label for="confirmdel">Is this the book you want to delete?:</label>
                        <?php
                         if ($ID != "") {
                            echo '<input type="text" class="form-control" name="confirmdel" value="'. $row['ProductName'] .'" readonly>';
                        }else{
                            echo '<input type="text" class="form-control" name="confirmdel" readonly>';
                        }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-default">Delete</button>
                    <?php
                    if($ID != "") echo '<input type="hidden" name="confirm_delete" value="' . $ID . '">';
                    ?>
                </form>
            </div>
        </div>
        <!-- Main Body End -->

        <!--This closes the employee header-->
<?php
include('includes/footer_empty.php');
?>