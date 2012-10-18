<?php 
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
	$confirm = $_POST['conf'];
	//print_r($confirm);
	
	$friend = "INSERT INTO friends (`user`,`friend`) VALUES ('$goturid','$confirm')";
	mysql_query($friend) or die(mysql_error()); 
}
?>