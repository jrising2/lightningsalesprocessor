<?php
//Week Summary for sales
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

//Day summary for sales
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

//Employees Report (daily, weekly)
function employees_table($employee_name, $trans_ids, $quantity, $totals, $status, $delivery, $num_orders) {
	for($i = 0; $i < $num_orders; $i++) {
		if (($i % 2 != 0) || ($i == 1)){
			$html = $html . '<tr style="background-color:#80b3ff">'; //alternates colors
		}else {
			$html = $html . '<tr style="background-color:#e6f0ff">';
		}
		$fmt = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
		$format = $fmt->formatCurrency($totals[$i], 'USD');
		
		if ($i == 0) {
			$html = $html . '<td rowspan="' . strval($num_orders) . '">' . $employee_name . '</td>';
		}
		$html = $html . '<td>' . $trans_ids[$i] . '</td><td>' . $quantity[$i] .'</td><td>'. $format . '</td><td>' . $status[$i] . '</td><td>' . $delivery[$i] . '</td></tr>';
	}
	return $html;
}

function low_stock($product_names, $categories, $stocks, $num_products, $threshold) {
	//Red no stock, Orange low stock, yellow medium stock, green in stock (will be row colors)
	$html = '<table cellspacing="0" cellpadding="0" border="1">';
	$html = $html . '<tr><td>Product Name</td><td>Category/Genre</td><td>Current Stock</td></tr>';
	for($i = 0; $i < $num_products; $i++) {
		$html = $html . '<tr>';
		if (intval($stocks[$i]) == 0) { //red no stock
			$html = $html . '<td>' . $product_names[$i] . '</td><td>' . $categories[$i] .'</td><td style="text-weight:bold;color:#ff1a1a">'. $stocks[$i] . '</td>';
		}else if ((intval($stocks[$i]) <= $threshold) && (intval($stocks[$i]) != 0)) { //orange low stock
			$html = $html . '<td>' . $product_names[$i] . '</td><td>' . $categories[$i] .'</td><td style="text-weight:bold;color:#ff9900">'. $stocks[$i] . '</td>';
		}else {
			$html = $html . '<td>' . $product_names[$i] . '</td><td>' . $categories[$i] .'</td><td>'. $stocks[$i] . '</td>';
		}
		$html = $html . '</tr>';
	}
	$html = $html . '</table>';
	return $html;
}
?>