<?php 
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
	$confirm = $_POST['conf'];
	//print_r($confirm);
	
	$friend = "INSERT INTO friends (`user`,`friend`) VALUES ('$goturid','$confirm')";
	mysql_query($friend) or die(mysql_error()); 

	$delete = "DELETE FROM pendingfriend WHERE '$goturid' = myid AND '$confirm' = friendid";
	mysql_query($delete) or die(mysql_error()); 

	//cool delete bro, but the deleted/confirmed friend are still on the page. lets hide the puzzle button
	require 'friend_conf.php';
}
?>