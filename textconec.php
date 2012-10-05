<?php
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {
	
	$goturid = $_SESSION['user_id'];
	$last = $_SESSION['lasttime'];
	$lastround = round($last);
	$textarea = $_POST['textarea'];

//$query = "INSERT INTO happy (text) VALUES ($textarea) ON DUPLICATE KEY UPDATE  text='$textarea' text SET user_id = '$goturid' AND unix_time = '$lastround'";

$yolo = "UPDATE happy SET text='$textarea'
WHERE user_id = '$goturid' AND unix_time = '$lastround'";

mysql_query($yolo) or die(mysql_error()); 

//replace this bitch with ajax
header("Location: ../newsalt/index.php");
exit;
}
?>