<?php 
 include 'dbc.php';
 page_protect();
if (isset($_SESSION['user_id'])) {

$goturid = $_SESSION['user_id'];
$latlon = $_POST['lati2'];
$leave = explode(",", $latlon);

$trimlat = substr($leave[0], 0, 5);
$trimlon = substr($leave[1], 0, 6);
//echo $trimlat;
$trimlat = str_replace(',', '', $trimlat);
$trimlon = str_replace(',', '', $trimlon);

$result42 = mysql_query("SELECT `place_name` FROM whereorigin WHERE `lat` = $trimlat AND `lon` = $trimlon");
	while($row = mysql_fetch_array($result42)) {
		echo $row['place_name'];}
}
?>