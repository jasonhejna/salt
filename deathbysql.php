<?php 
 include 'dbc.php';
 page_protect();
if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id'];

	$blam = mysql_query("SELECT `unix_time`, `text` FROM happy WHERE `user_id` = '$sesvar' AND `text` IS NOT NULL ORDER BY unix_time DESC LIMIT 20");
		
	while($row = mysql_fetch_array($blam)) {
		$time = $row['unix_time'];// -(31*24*60*60);
   		$ftime = strftime("%m/%d/%y",$time);

		echo ''.$ftime.'<br>' . $row['text'] . '<br><br>';
	}
}
?>