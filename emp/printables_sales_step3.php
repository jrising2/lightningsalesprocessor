<?php
include "../includes/database.php";
session_start();
global $link;
?>

<h3>Setup Filter Options:</h3>
<div class="row" style="padding-top:15px">
    <div class="col-md-5">
        <label for="ProductTypeToSelect">Available Columns</label>
        <select multiple class="form-control" id="ProductTypeToSelect" style="min-height:200px">
            <?php
            $qryProducts = "SELECT DISTINCT Genre FROM Products ORDER BY Genre ASC";
            $resultProducts = mysqli_query($link, $qryProducts);
            for($i = 0; $i < mysqli_num_rows($resultProducts); $i++) {
               $row = mysqli_fetch_assoc($resultProducts);
               echo '<option>' . $row['Genre'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-2">
		<div class="text-center">
			<div class="btn-group-vertical" style="padding-top:30px;width:80px">
				<button type="button" class="btn btn-default" onClick="AddType()"> > </button>
				<button type="button" class="btn btn-default" onClick="AddAll()"> >> </button>
				<button type="button" class="btn btn-default" onClick="RemoveType()"> &#60; </button>
				<button type="button" class="btn btn-default" onClick="RemoveAll()"> &#60;&#60; </button>
			</div>
		</div>
    </div>
    <script type="text/javascript">
        //Note does not preserve alphabetical order may or may not fix.
        //Doesn't seem pertinent right now.
        function AddType() {
            $('#ProductTypeToSelect :selected').each(function(i, selected){
                var val = $(selected).detach();
                $('#ProductTypeSelected').append(val);
            });
        }
        function RemoveType() {
            $('#ProductTypeSelected :selected').each(function(i, selected){
                var val = $(selected).detach();
                $('#ProductTypeToSelect').append(val);
            });
        }
        function AddAll() {
            $('#ProductTypeToSelect > option').each(function(){
                this.selected = true;
            });
            $('#ProductTypeToSelect :selected').each(function(i, selected){
                var val = $(selected).detach();
                $('#ProductTypeSelected').append(val);
            });
        }
        function RemoveAll() {
            $('#ProductTypeSelected > option').each(function(){
                this.selected = true;
            });
            $('#ProductTypeSelected :selected').each(function(i, selected){
                var val = $(selected).detach();
                $('#ProductTypeToSelect').append(val);
            });
        }
    </script>
    <div class="col-md-5">
        <label for="ProductTypeSelected[]">Selected Columns</label>
        <select multiple class="form-control" name="ProductTypeSelected[]" id="ProductTypeSelected" style="min-height:200px">
        </select>
    </div>
</div>

<div class="row" style="padding-top:15px">
    <div class="col-md-2">
        <label for="stock" class="col-form-label">Stock Threshold:</label>
        <input class="form-control" type="text" name="stock">
    </div>
</div>