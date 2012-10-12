<?php
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
	$friendid = $_POST['friendid'];

$frienduya = "INSERT INTO users (`id`) VALUES '$friendid' WHERE id = '$goturid'";
mysql_query($frienduya) or die(mysql_error()); 
}
?>