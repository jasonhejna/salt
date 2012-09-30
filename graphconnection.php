<?php 
// include 'dbc.php';
// page_protect();
if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id'];

$result = mysql_query("SELECT `happiness`, `unix_time` FROM happy WHERE `user_id` = $sesvar");
//mysql_query($result) or die(mysql_error());
// format data structure
//echo json_encode($result);
//[new Date(2008, 1 ,1), 1, null, null],
//what the fuck, I know I need to add some null values and convert unix time to the right format
$data = array();
$i = 0;
while($row = mysql_fetch_array($result)) {
    $i += 1;

    //array_push($data, array($i) + $row);
    array_push($data, array($i) + $row);
}
}
?>

    
      var raw_data = <?php echo json_encode($data) ?>
