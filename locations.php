<?php 
 include 'dbc.php';
 page_protect();
//if (isset($_SESSION['user_id'])) {

$goturid = $_SESSION['user_id'];
$later = $_POST['lati'];
$pieces = explode(",", $later);
$trimlat = substr($pieces[0], 0, 6);
$trimlon = substr($pieces[1], 0, 6);
//echo $trimlat;
$trimlat = str_replace(',', '', $trimlat);
$trimlon = str_replace(',', '', $trimlon);
//echo $cleanlate;
/*$result22 = mysql_query("SELECT
    `place_name`, `lat`, `lon` FROM whereorigin WHERE
    ( 6371 * acos( cos( radians({$lat}) ) * cos( radians( `lat` ) ) * cos( radians( `lon` ) - radians({$lng}) ) + sin( radians({$lat}) ) * sin( radians( `lat` ) ) ) ) AS distance
FROM `positions`
HAVING distance <= {"3"}
ORDER BY distance ASC");
while($row = mysql_fetch_array($result22)) {

}*/
//$loner = $_GET['loni'];
	$result43 = mysql_query("SELECT `place_name`, `lat`, `lon` FROM whereorigin WHERE `user_id` = $goturid");
	while($row = mysql_fetch_array($result43)) {
		$laat = substr($row['lat'], 0, 6);
		$loon = substr($row['lon'], 0, 6);
		
		
		if ($laat == $trimlat && $loon == $trimlon) {
			//$lat = $row['lat'];
			//$lon = $row['lon'];
			//$count = $row['count'];
			//$counted = $count ++;

			//mysql_query("UPDATE whereorigin SET count=$counted WHERE `user_id` = $goturid AND place_name=$place_name");
		/*$loco = "INSERT INTO whereorigin (`place_name`) VALUES ('$goturid','$place_name','$lat','$lon')";
		mysql_query($loco) or die(mysql_error()); */
		echo $row['place_name'];

		}
		
	}

//}
?>