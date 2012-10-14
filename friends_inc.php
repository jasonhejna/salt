<?php
//include 'dbc.php';
//page_protect();

if (isset($_SESSION['user_id'])) {
	$q = "";
	if (isset($_POST["course"])) {

	$q = strtolower($_POST["course"]);
	
	$result2 = mysql_query("SELECT `full_name`, `profile_pic`, `id` FROM users WHERE `full_name` LIKE '%$q%'");

while($row = mysql_fetch_array($result2)) {
// write the if statement to check if the user if already a friend. hint: write a post in the ajax (onSubmit as a session variable)
	
	if (is_null($row['profile_pic'])) {
		echo '<div id="userbox">

		<div id="coolbox">
		<img class="upic" src="images/malesilhouette.png" /></div>&nbsp;&nbsp;' 
    	. $row['full_name'] . '<input id="cdialog" for="cdialog" class="' . $row['id'] . '" type="button" value="connect"/> </div> </br>';
	}
	else {
		echo '<div id="userbox">
		
		<div id="coolbox">
		<img class="upic" src="data:image/jpeg;base64,' . base64_encode( $row['profile_pic'] ) . '" /></div>&nbsp;&nbsp;' 
    	. $row['full_name'] . '<input id="cdialog" for="cdialog" class="' . $row['id'] . '" type="button" value="connect"/> </div> <br/>';
	}
		
}
		}
		else {
			echo '<div id="userbox">Connect with friends</div>';
		}
}
?>