<?php 
//error_reporting (E_ALL ^ E_NOTICE);
if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id'];

				$result2 = mysql_query("SELECT `friendid` FROM pendingfriend WHERE `myid` = $sesvar");


				$i=0;
				while($row = mysql_fetch_array($result2)) {


					$getdaid = $row['friendid'];
					
					$profinfo = mysql_query("SELECT `id`,`full_name`,`profile_pic` FROM users WHERE `id` = $getdaid");
					while($row2 = mysql_fetch_array($profinfo)) {
					$i++;
					if (is_null($row2['profile_pic'])) {
						echo '<div id="userbox">

						<div id="coolbox">
						<img class="upic" src="images/malesilhouette.png" />
						</div><center>' 
				    	. $row2['full_name'] . '
				    	<br><form>
				    	<button  id="conf' . $i . '" class="confirmfr" name="' . $row2['id'] . '" type="button" onclick="javascript:rundialog('. $row2['id'] . ')">
				    	<span  onmouseover="javascript:puzzle('. $i . ');" >
				    	

				    	<img src="images/puzzleyes.png" id="puzzle2' . $i . '" width="65" class="puzzle2" />
				    	<img src="images/puzzlepieceno.png" id="puzzle' . $i . '" width="65" class="puzzle" />
				    	</span>
				    	</button>
				    	</form>
				    	</center>
				    	</div>';
					}
					else {
						echo '<div id="userbox">
						
						<div id="coolbox">
						<img class="upic" src="data:image/jpeg;base64,' . base64_encode( $row2['profile_pic'] ) . '" />
						</div><center>' 
				    	. $row2['full_name'] . '
				    	<br><form>
				    	<button  id="conf' . $i . '" class="confirmfr" name="' . $row2['id'] . '" type="button" onclick="javascript:rundialog('. $row2['id'] . ')">
				    	<span onmouseover="javascript:puzzle('. $i . ');" >
				    	

				    	<img src="images/puzzleyes.png" id="puzzle2' . $i . '" width="65" class="puzzle2" />
				    	<img src="images/puzzlepieceno.png" id="puzzle' . $i . '" width="65" class="puzzle" />
				    	</span>
				    	</button>
				    	</form>
				    	</center>
				    	</div>';
					}
				
					}

				}

					if($i<=0) {
						echo '<div id="userbox">You have no pending connections.</div>';
						//$i++;
					}	

	}


?>