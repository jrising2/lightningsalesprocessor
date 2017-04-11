<?php
require "vendor/autoload.php";

function validateName($name) {
$fullname = explode(" ", $name);

//we assume only roman characters
for ($i = 0; $i < sizeof($fullname); $i++) {
    if (preg_match("/^[a-zA-Z ]*$/", $fullname[$i])) {
    } else {
    	return false;
    }
}
return true;

}

function validateEmail($email) {
if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
	return true;
}else {
	return false; //if false invalid email
}
}

function validateAddress($a1, $a2, $cit, $st, $z) {
	$apiKey = 'test_5776333037812dde964ccd62129227d71c5';
	$apiVersion = '2016-06-30';
    $lob = new Lob\Lob($apiKey, $apiVersion);
    try {
       $result = $lob->addresses()->verify(array(
        'address_line1'     => "{$a1}",
        'address_line2'      => "{$a2}",
        'address_city'      => "{$cit}",
        'address_state'     => "{$st}",
        'address_zip'       => "{$z}"
        ));
    } catch (Lob\Exception\ResourceNotFoundException $e) {
        //if error occurs the address is invalid
        return false;
    }
    
    if (($result['message'] == "address not found") || ($result['status_code'] == 404)) {
        return false;
    }
    return true;
}

?>
