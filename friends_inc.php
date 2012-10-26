<?php
error_reporting (E_ALL ^ E_NOTICE);
//include 'dbc.php';
//page_protect();

if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id'];
	$q = "";
	if (isset($_POST["course"]) && $_POST["course"] != "") {

	$q = strtolower($_POST["course"]);
	if (strlen($q) <= "2") {
		echo '<p>Not enough Characters in your Search. Try your search again. </p>';
	}
	else {}

	

	
	$result2 = mysql_query("SELECT `full_name`, `profile_pic`, `id` FROM users WHERE `full_name` LIKE '%$q%'");
	while($row = mysql_fetch_array($result2)) {
// write the if statement to check if the user if already a friend. hint: write a post in the ajax (onSubmit as a session variable)
		$myid = $row['id'];
		//print_r($myid);
		//$friendfrag =  array_intersect($explodefriend, $myid);

	if (empty($friendfrag)) {
		//echo "hello";
	
	if (is_null($row['profile_pic'])) {
		echo '<div id="userbox">

		<div id="coolbox">
		<img class="upic" src="images/malesilhouette.png" /></div>&nbsp;&nbsp;' 
    	. $row['full_name'] . '<input  id="cdialog" class="' . $row['id'] . '" type="submit" value="connect" onclick="javascript:runfriends('. $row['id'] . ')" /> </div>';
	}
	else {
		echo '<div id="userbox">
		
		<div id="coolbox">
		<img class="upic" src="data:image/jpeg;base64,' . base64_encode( $row['profile_pic'] ) . '" /></div>&nbsp;&nbsp;' 
    	. $row['full_name'] . '<input id="cdialog" class="' . $row['id'] . '" type="submit" value="connect" onclick="javascript:runfriends('. $row['id'] . ')" /> </div>';
	}
}	
else {
		if (is_null($row['profile_pic'])) {
		echo '<div id="userbox">

		<div id="coolbox">
		<img class="upic" src="images/malesilhouette.png" /></div>&nbsp;&nbsp;' 
    	. $row['full_name'] . '</div>';
	}
	else {
		echo '<div id="userbox">
		
		<div id="coolbox">
		<img class="upic" src="data:image/jpeg;base64,' . base64_encode( $row['profile_pic'] ) . '" /></div>&nbsp;&nbsp;' 
    	. $row['full_name'] . '</div>';
	}
}
}
	
}
		else {
			// do nothing I guess
			echo '<div id="coltitle"><center>Pending Connections</center></div>';
			//there should be something that check for a null value in autocomplete textbox, and if null then do this else
			include 'friends_conf.php';
			//something
			//post the connect result to the freinds_left.php. maybe do this in connect.php
			
		}
}
?>