<?php
include ('SingleItem.php');

$browseItemDesc = new SingleItem($_GET['ItemID'], true);  // true => get Item Desc

print_r($browseItemDesc);

print "<H1>Item Description</H1>";

print $browseItemDesc->resp->Item->Description;

?>
