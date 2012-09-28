<?php
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
$happiness = $_POST['happiness'];
$yahoo = $_POST['yahoo'];
$info = "INSERT INTO happy (`user_id`,`happiness`,`unix_time`) VALUES ('$goturid',$happiness,'$yahoo')";
mysql_query($info) or die(mysql_error()); 
}
?>