<?php // database.php

$dbhost = 'sql212.epizy.com';
$dbuser = 'epiz_19723230';
$dbpass = 'icebreaker';
$dbname = 'epiz_19723230_lightnsalesproc';
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Connection to database could not be established");

?>