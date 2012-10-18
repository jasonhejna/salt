<?php
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
	$friendid = $_POST['friendid'];



$frienduya = "UPDATE users SET friends=CONCAT('|$goturid',friends) WHERE id = '$friendid'";
mysql_query($frienduya) or die(mysql_error()); 
}
?>