<?php // database.php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'lightnsalesproc';
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Connection to database could not be established");

?>
