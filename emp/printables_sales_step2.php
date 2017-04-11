<!DOCTYPE html>
<div class="row">
    <div class="col-md-6">
        <p style="font-weight:bold">Start Date:</p>
        <div class="row">
            <div class="col-md-3">
                <select type="text" class="form-control" name="YearStart" id="YearStart" style="width:100px">
                    <option>2017</option>
                </select>
            </div>
            <script type="text/javascript">
                function monthStartChange() {
                    var month = document.getElementById("MonthStart");
                    var days = document.getElementById("DayStart");
                    var i = 0;
                    for (i = days.options.length - 1; i >= 0; i--) {
                        days.removeChild(days.options[i]);
                    }
                    var now = new Date();
                    var months = new Date(now.getFullYear(), month.value, 0).getDate();
                    for (i = 1; i <= parseInt(months.toString()); i++){
                        var opt = document.createElement('option');
                        opt.appendChild(document.createTextNode(i.toString()));
                        days.appendChild(opt);
                    }
                }
            </script>
            <div class="col-md-3">
                <?php
                echo'<select type="text" onChange="monthStartChange()" class="form-control" id="MonthStart" style="width:120px">
                    <option value="1" selected>January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>';
                ?>
            </div>

            <div class="col-md-3">
                <select type="text" class="form-control" id="DayStart">
                    <?php
                        $days = cal_days_in_month(CAL_GREGORIAN , 1 , intval(date("Y")));
                        for ($i = 1; $i <= $days; $i++) {
                            echo '<option>' . $i . '</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
    </div><!--startdate col-6 divide-->

    <div class="col-md-6">
        <p style="font-weight:bold">End Date:</p>
        <div class="row">
            <div class="col-md-3">
                <select type="text" class="form-control" name="YearEnd" id="YearEnd" style="width:100px">
                    <option>2017</option>
                </select>
            </div>
            <script type="text/javascript">
                function monthEndChange() {
                    var month = document.getElementById("MonthEnd");
                    var days = document.getElementById("DayEnd");
                    var i = 0;
                    for (i = days.options.length - 1; i >= 0; i--) {
                        days.removeChild(days.options[i]);
                    }
                    var now = new Date();
                    console.log(month.value);
                    var months = new Date(now.getFullYear(), month.value, 0).getDate();
                    for (i = 1; i <= parseInt(months.toString()); i++){
                        var opt = document.createElement('option');
                        opt.appendChild(document.createTextNode(i.toString()));
                        days.appendChild(opt);
                    }
                }
            </script>
            <div class="col-md-3">
                <?php
                echo'<select type="text" onChange="monthEndChange()" class="form-control" name="MonthEnd" id="MonthEnd" style="width:120px">
                    <option value="1" selected>January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>';
                ?>
            </div>
            <div class="col-md-3">
                <select type="text" class="form-control" id="DayEnd">
                    <?php
                        $days = cal_days_in_month(CAL_GREGORIAN , 1 , intval(date("Y")));
                        for ($i = 1; $i <= $days; $i++) {
                            echo '<option>' . $i . '</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
    </div><!--startdate col-6 divide-->

</div>
<div class="row" style="padding-top:15px">
    <div class="col-md-6">
        <label for="producttype">Product Type/Category</label>
        <select multiple class="form-control" id="ProductType" style="min-height:200px">
            <?php
            for($i = 0; $i < mysqli_num_rows($result); $i++) {
               $row = mysqli_fetch_assoc($result);
               echo '<option>' . $row['Genre'] . '</option>';
            }
            ?>
        </select>
    </div>
    <!-- This is a bit of extra work may not keep this-->
    <div class="col-md-6">
        <label for="productlist">Product List</label>
        <select multiple class="form-control" id="ProductList" style="min-height:200px">
            <option>XXXXXX</option>
            <option>XXXXXX</option>
            <option>XXXXXX</option>
            <option>XXXXXX</option>
            <option>XXXXXX</option>
        </select>
    </div>
</div>

<div class="row" style="padding-top:15px">
    <div class="col-md-2">
        <label for="stock" class="col-form-label">Stock Threshold:</label>
        <input class="form-control" type="text" name="stock">
    </div>
</div>
<!-- I plan to generate this piece of html through php when the form is submitted (maybe)-->
<!--<object data='http://www.pdf995.com/samples/pdf.pdf'
    type='application/pdf'
    width='100%'
    height='100%'>
<p>This browser does not support inline PDFs. Please download the PDF to view it: <a href="http://www.pdf995.com/samples/pdf.pdf">Download PDF</a></p>
</object>-->
