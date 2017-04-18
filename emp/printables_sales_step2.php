<!DOCTYPE html>
<script ="text/javascript">
//JS GLOBALS
var curSelect = "";
</script>
<h3>Date Selection:</h3>
<div class="row">
    <div class="col-md-12" id="duration_select">
        <p style="font-weight:bold">Report Duration:</p>
        <div class="row">
			<script type="text/javascript">			
				$("#ReportDuration").on('change', function() {
					//REMOVE ANY PREVIOUS APPENDS
					if ((curSelect == "daily") || (curSelect == "weekly")) {
						$("#append_datepicker").remove();
					} else if (curSelect == "quarterly") {
						$("#append_quarters").remove();
					}

					if ((this.value == "daily") || (this.value == "weekly")) {
						//Add row divide
						var add = $("<div class='row' id='append_datepicker'></div>");
						$("#duration_select").append(add);
						
						//add report date picker to previously added row divide
						var dp = $("<div class='col-md-4'><div id='datepicker'></div></div>");
						$("#append_datepicker").append(dp);
						
						//Embed date picker in the html
						$( function() {
							$("#datepicker").datepicker();
						});
						//$("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
						
						if (this.value == "daily") {
							$("#prompt").text("Select date for the report:");
							curSelect = "daily";
						} else if (this.value == "weekly") {
							$("#prompt").text("Select start date for the report:");
							curSelect = "weekly";
						}
					} else if (this.value == "quarterly") {
						//Add row divide
						var add = $("<div class='row' id='append_quarters'></div>");
						$("#duration_select").append(add);
						
						//add quarters check boxes
						var i;
						for (i = 1; i < 5; i++ ) {
							var quart = $('<div class="col-md-12"><div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox" value="quarter' + i.toString() + '">Q' +  i.toString() + '</label></div></div>');
							$("#append_quarters").append(quart);
						}
						$("#prompt").text("Select the quarters to include the report:");
						curSelect = "quarterly";
					} else if (this.value == "") {
						curSelect = "";
					}
				});	
			</script>
			<div class="col-md-3">
				<select type="text" class="form-control" name="ReportDuration" id="ReportDuration">
                    <option value="" selected></option>
					<option value="daily">Daily Sales Report</option>
					<option value="weekly">Weekly Sales Report</option>
					<option value="quarterly">Quarterly Sales Report</option>
                </select>
			</div>
        </div>
		<div class ="row" style="padding-top:10px">
			<div class="col-md-4">
				<p style="font-weight:bold" id="prompt"></p>
				<input type="hidden" name="date" id="date" value=""/>
			</div>
		</div>
		
    </div><!--startdate col-12 divide-->

</div>