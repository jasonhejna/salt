<?php 
 include 'dbc.php';
 page_protect();
if (isset($_SESSION['user_id'])) {
	$sesvar = $_SESSION['user_id']; 


    $q = strtolower($_GET["q"]);

if (!$q) return;
$sql = "SELECT `full_name`, `id` FROM users WHERE `full_name` LIKE '%$q%'";

$rsd = mysql_query($sql);

while($rs = mysql_fetch_array($rsd)) {
    $cname = $rs['full_name'];
    echo "$cname\n";
}

}
?>