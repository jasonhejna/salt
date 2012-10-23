<?php


 if (isset($_SESSION['user_id'])) {
 	$goturid = $_SESSION['user_id'];
 	date_default_timezone_set('America/New_York');
 
?>
<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body>
	<?php include 'deathbysql.php'; ?>
</body>
</html>
<?php } ?>
