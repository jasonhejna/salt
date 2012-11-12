<?php
if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id'];
$result_bro = mysql_query("SELECT `friend` FROM friends WHERE user=$sesvar");
	while($row = mysql_fetch_array($result_bro)) {
		$davariable = $row['friend'];

		$content_bro = mysql_query("SELECT `full_name`,`profile_pic` FROM users WHERE id=$davariable");
		while($row = mysql_fetch_array($content_bro)) {
			if (is_null($row['profile_pic'])) {
						echo '<div id="mahem" onmouseover="this.className="top1"" onmouseout="this.className="top"">
						<img style="float:left;" class="upic" src="images/malesilhouette.png" />
						<div style="float:right;">' . $row['full_name'] . '</div></div>';
					}
					else {
						echo '<div id="mahem" onmouseover="this.className=top1 onmouseout="this.className=top">
						<img style="float:left;margin-bottom:13px;" class="upic" src="data:image/jpeg;base64,' . base64_encode( $row['profile_pic'] ) . '" />
						<div style="float:right;">' . $row['full_name'] . '</div></div>';

					}
			
		}
	}
}
?>