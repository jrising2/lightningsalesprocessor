<?php
require_once "includes/employee_header.php";
require "../includes/database.php";
global $link;
$qryEmployees = "SELECT FirstName, LastName, Role FROM Employees"
//$qryOrders = "SELECT Quantity, Status, DeliveryType, TimeStamp FROM Transactions"


?>
<script type="text/javascript">
//Globabls for controlling the page
var report_type = "";
</script>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2>Report Generation</h2>
        </div>
        <div class="panel-body">
            <div class="row" style="padding-bottom:20px">
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block" style="width:150px">Step 1<br>Selection</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary btn-block" style="width:150px">Step 2<br>Filtering</button>
                </div>
                <div class="col-md-2">
                    <button  class="btn btn-primary btn-block" style="width:150px">Step 3<br>Generation</button>
                </div>
            </div>
            <form role="form" id="form_generate" action="printables_process.php" method="POST">
                <div class="panel panel-default">
                     <!--Hidden Tab to navigate between steps-->
                     <div class="panel-body">
                        <ul class="nav nav-pills nav-justified" id="all_steps" style="display:none;">
                            <li class="active"><a data-toggle="tab" href="#Step1"></a></li>
                            <li><a data-toggle="tab" href="#Step2"></a>v</li>
                            <li><a data-toggle="tab" href="#Step3"></a></li>
                            <li><a data-toggle="tab" href="#Step4"></a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="Step1" class="tab-pane active">
                                <h3>Choose the Type to generate:</h3>
                                <div class="form-group">
                                    <div class="radio">
                                        <label><input type="radio" name="whichreport" id="salesreport" value="sales">Sales Report</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="whichreport" id="employeesreport" value="employees">Employee Report</label>
                                    </div>
                                </div>
                            </div>
                            <div id="Step2" class="tab-pane">
                                
                            </div>
							<div id="Step3" class="tab-pane">
                                
                            </div>
                            <div id="Step4" class="tab-pane">
                                <h3>Generate Report:</h3>
                                <div class="form-group">
                                    <div class="radio">
                                        <label><input type="radio" name="viewtype" id="webview" value="webpage">View as webpage</label>
                                    </div>
                                    <div class="radio">
                                        <label><input type="radio" name="viewtype" id="pdfview" value="pdf">View as pdf</label>
                                    </div>
									<div class="radio">
                                        <label><input type="radio" name="viewtype" id="dpdfview" value="dpdf">Download as pdf</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                </div><!--Form panel close-->
            </form>

        </div><!--Panel body-->
        <div class="panel-footer">
            <div class="row">
                <div class="col-md-6">
                    <div align="left"><button class="btn btn-primary btn-block" id="previous" name="previous" style="width:150px;visibility:hidden"> &#60;&#60; Previous </button></div>
                </div>
                <div class="col-md-6">
                    <div align="right"><button class="btn btn-primary btn-block" id="next" name="next" value="step2" style="width:150px">Next >></button></div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
		//PREVIOUS FUNCTION
        $("#previous").click(function() {
            console.log($("#previous").val());
            if ($("#previous").val() == "step1") { //In Step2 to Step1
                //prep for step 2
                $("#previous").css("visibility", "hidden");
                $("#previous").val("");
                $("#next").val("step2");
                $('#all_steps a[href="#Step1"]').tab('show');

            } else if ($("#previous").val() == "step2") { //In Step3 to Step2
                $("#previous").val("step1");
                $("#next").val("step3");
                $('#all_steps a[href="#Step2"]').tab('show');
				
            }else if ($("#previous").val() == "step3") { //In Step4 to Step3
                $("#previous").val("step2");
                $("#next").val("step4");
                $('#all_steps a[href="#Step3"]').tab('show');
            }
        });
		
		//NEXT FUNCTION
        $("#next").click(function() {
			
            if ($("#next").val() == "step2") { //In Step1 to Step2
                //determine which step 2:
                if ($("#salesreport").is(":checked")  == true) {
                    $.get("printables_sales_step2.php", function(data){
                        if (report_type != "Sales"){
                            $("#Step2").html(data);
                            report_type = "Sales";
                        }
                    });
                }else if ($("#employeesreport").is(":checked") == true){
                    $.get("printables_employees_step2.php", function(data){
                        if (report_type != "Employees"){
                            $("#Step2").html(data);
                            report_type = "Employees";
                        }
                    });
                } else {
                    //neither selected
                    alert("No report type has been selected");
                    return;
                }
                //prep for step 2
                $("#previous").css("visibility", "visible");
                $("#previous").val("step1");
                $("#next").val("step3");
                $('#all_steps a[href="#Step2"]').tab('show');
            } else if ($("#next").val() == "step3") { //In Step2(date selection) to Step3(filtering)
				//Do some code here to make sure step2 forms is filled
				if ($("#ReportDuration").val() == "") {
					alert("No report duration type selected");
					return;
				}
				if ($("#datepicker").datepicker("getDate") == null) {
					alert("No start date is selected");
					return;
				}
				//prep for step 3
				if (report_type == "Sales") {
					$.get("printables_sales_step3.php", function(data){
						$("#Step3").html(data);
					});
				}else if (report_type == "Employees") {
					$.get("printables_employees_step3.php", function(data){
						$("#Step3").html(data);
					});
				}
                $("#previous").val("step2");
                $("#next").val("step4");
                $('#all_steps a[href="#Step3"]').tab('show');
				
				//Set the date
				$("#date").val($("#datepicker").val());	
			} else if ($("#next").val() == "step4"){ //In Step 3 to Step4
				//Do some code here to make sure step2 forms is filled//
				
                $("#previous").val("step3");
                $("#next").val("generate");
                $("#next").text("Generate");
                $('#all_steps a[href="#Step4"]').tab('show');	
            } else if($("#next").val() == "generate"){ //In Step 4 to Generation
				//Ensures a radio button is checked before generating
				if ($("#webview").is(":checked")  == true) {
                }else if ($("#pdfview").is(":checked") == true){
				}else if ($("#dpdfview").is(":checked") == true){
                } else {
                    //neither selected
                    alert("Please select a view type");
                    return;
                }
				
                //our form's submit will be called here here.
                if (report_type == "Sales") {
                    document.getElementById("form_generate").action = "printables_process_sales_report.php";
					document.getElementById("form_generate").submit();
                }else if (report_type == "Employees"){
                    document.getElementById("form_generate").action = "printables_process_employees_report.php";
					document.getElementById("form_generate").submit();
                }
            }
        });
    </script>

<?php
require_once "includes/footer_empty.php";
?>