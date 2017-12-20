<?php
include "../../includes/database.php";
global $link;
//if search occured redirect to the proper page
$search = $link->real_escape_string($_POST['searchinventory']);
$filter = $_POST['filters'];
$order = $_POST['order'];
$link = "../inventory.php?search={$search}";
if ($filter != "") $link = $link . "&filter={$filter}";
if ($order != "") $link = $link . "&order={$order}";
$link = $link . "&page=1";
echo $link;
header("Location: {$link}");
?>
