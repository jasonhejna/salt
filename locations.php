<?php 

if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
$later = $_GET['lati'];
echo $row['lati'];
$loner = $_GET['loni'];
	$result43 = mysql_query("SELECT `place_name`, `lat`, `lon` FROM whereorigin WHERE `user_id` = $goturid");
	while($row = mysql_fetch_array($result43)) {
		
		
		if ($later == $row['lat'] && $loner == $row['lon']) {
			$place_name = $row['place_name'];
			$lat = $row['lat'];
			$lon = $row['lon'];
			//$count = $row['count'];
			//$counted = $count ++;

			//mysql_query("UPDATE whereorigin SET count=$counted WHERE `user_id` = $goturid AND place_name=$place_name");
		/*$loco = "INSERT INTO whereorigin (`place_name`) VALUES ('$goturid','$place_name','$lat','$lon')";
		mysql_query($loco) or die(mysql_error()); */
		echo $place_name;
		echo $row['place_name'];
		}

	}

}
?>