<?php
//Week Summary
function week_table($sales, $sales_per, $units, $startdate, $enddate, $weekdays) {
	$html = '<h3 style="padding-top:20px">Week: ' .$startdate .'-'. $enddate . '</h3><table cellspacing="0" cellpadding="0" border="1"><tr style="text-weight:bold;color:#003d99"><td></td><td>Sales</td><td>Sales Percentage</td><td>Units Sold</td></tr>';
	for ($i = 0; $i < count($weekdays); $i++) {
		if (($i % 2 != 0) || ($i == 1)){
			$html = $html . '<tr style="background-color:#D1D1E0">'; //alternates colors
		}else {
			$html = $html . '<tr>';
		}
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$format = $fmt->formatCurrency($sales[$i], 'USD');
		$html = $html ."<td>{$weekdays[$i]}</td><td>{$format}</td><td>% {$sales_per[$i]}</td><td>{$units[$i]}</td></tr>";
	}
	//totals row
	$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
	$format = $fmt->formatCurrency(array_sum($sales), 'USD');
	$per_sum = array_sum($sales_per);
	$units_sum = array_sum($units);
	$html = $html .'<td style="font-weight:bold">Totals</td><td>' . $format . '</td><td>%' . $per_sum . '</td><td>' . $units_sum . '</td></tr>';
	$html = $html . "</table>";
	return $html;
}


//Day summary Includes Categories
function daily_table($cols, $sales, $sales_per, $units, $weekday) {
	//Write table for daily sales report
	$html = '<h3 style="padding-top:20px">' . $weekday .'</h3><table cellspacing="0" cellpadding="0" border="1"><tr style="text-weight:bold;color:#003d99"><td>Category/Genre</td><td>Sales</td><td>Sales Percentage</td><td>Units Sold</td></tr>';
	for($i = 0; $i < count($cols); $i++) {
		if (($i % 2 != 0) || ($i == 1)){
			$html = $html . '<tr style="background-color:#D1D1E0">'; //alternates colors
		}else {
			$html = $html . '<tr>';
		}
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$format = $fmt->formatCurrency($sales[$i], 'USD');
		$html = $html ."<td>{$cols[$i]}</td><td>{$format}</td><td>% {$sales_per[$i]}</td><td>{$units[$i]}</td></tr>";
	}
	$html = $html . "</table>";
	return $html;
}
?>