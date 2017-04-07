<?php
require "vendor/autoload.php";

function validateName($name) {
//we assume on roman characters
if (preg_match("/^[a-zA-Z ]*$/",$name)) {
	return true;
} else {
	return false;
}

}

function validateEmail($email) {
//$emailValidation = '[A-Za-z0-9]+@{1}[A-Za-z]{2,}.?[A-Za-z]*'; //assuming only english domains
if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
	return true;
}else {
	return false;
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
        'address_zip'       => '{$z}'
        ));
    } catch (Lob\Exception\ResourceNotFoundException $e) {
        //if error occurs the address is invalid
        return false;
    }
    return true;
}

?>