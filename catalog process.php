<!DOCTYPE html>
<?php
require("includes/database.php");
global $link;
//if search occured redirect to the proper page
$temp = $link->real_escape_string($_POST['searchcatalog']);
header("Location: catalog.php?search={$temp}&page=1");
?>
