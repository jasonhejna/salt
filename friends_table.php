<?php

//include 'dbc.php';
//page_protect();

if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id'];

	$icanhasfriends = mysql_query("SELECT `user`,`friend` FROM friends WHERE `user` = $sesvar OR `friend` = $sesvar ");
	while($row2 = mysql_fetch_array($icanhasfriends)) {
		if ($sesvar != $row['user'] && $sesvar != $row['friend']) {
			//json encode for google chart
		$arr = array()
		}
	}
}
?>