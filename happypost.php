<?php
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
	
$happiness = $_POST['happiness'];
$time = $_POST['time'];
$blah = $_POST['latylony'];
$_SESSION['lasttime'] = $time ;


$info = "INSERT INTO happy (`user_id`,`happiness`,`unix_time`,`latz`) VALUES ('$goturid',$happiness,'$time','$blah')";
mysql_query($info) or die(mysql_error()); 
}
?>