<?
include "../includes/database.php";
include "includes/employee_header.php";
global $link;

$qry = "SELECT DISTINCT Genre FROM Products ORDER BY Genre ASC";
$result = mysqli_query($link, $qry);


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
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="salesreport" id="salesreport" value="sales">
                                        Sales Report
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="employeesreport" id="employeesreport" value="employees">
                                        Employee Report
                                    </label>
                                </div>
                            </div>
                            <div id="Step2" class="tab-pane">
                                <h3>Setup Filter Options:</h3>

                            </div>
                            <div id="Step3" class="tab-pane">
                                <h3></h3>
                                <p>Some content in menu 2.</p>
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
        $("#previous").click(function() {
            console.log($("#previous").val());
            if ($("#previous").val() == "step1") {
                //prep for step 2
                $("#previous").css("visibility", "hidden");
                $("#previous").val("");
                $("#next").val("step2");
                $('#all_steps a[href="#Step1"]').tab('show');

            } else if ($("#previous").val() == "step2") {
                $("#previous").val("step1");
                $("#next").type = "button";
                $("#next").val("step3");
                $('#all_steps a[href="#Step2"]').tab('show');
            }
        });

        $("#next").click(function() {
            if ($("#next").val() == "step2") {
                //determine which step 2:
                if ($("#salesreport").is(":checked") == true) {
                    $.get("printables_sales_step2.php", function(data){
                        if (report_type != "Sales"){
                            $("#Step2").html(data);
                            report_type = "Sales";
                        }
                    });
                }else if ($("#employeesreport").is(":checked") == true){
                    $.get("banner.html", function(data){
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
            } else if ($("#next").val() == "step3") {
                $("#previous").val("step2");
                $("#next").val("generate");
                $("#next").text("Generate");
                $('#all_steps a[href="#Step3"]').tab('show');
            } else if($("#next").val() == "generate"){
                //our form's submit will be called here here.
                document.getElementById("form_generate").submit();
            }
        });
    </script>
        <!-- Main Body End -->
<?php
include "includes/footer_empty.php";
?>