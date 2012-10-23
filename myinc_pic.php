<?php 


if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id'];

				$result8 = mysql_query("SELECT `profile_pic` FROM users WHERE `id` = $sesvar");
				
				while($row = mysql_fetch_array($result8)) {
					
					if (is_null($row['profile_pic'])) {
						echo '
						<img class="upic" src="images/malesilhouette.png" />';
					}
					else {
						echo '
						<img class="upic" src="data:image/jpeg;base64,' . base64_encode( $row['profile_pic'] ) . '" />';
					}
				}

		

	


	
}
?>