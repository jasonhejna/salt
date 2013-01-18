<?php
include 'dbc.php';
page_protect();
if (isset($_SESSION['user_id'])) {

$goturid = $_SESSION['user_id'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<meta name="viewport" content="width=device-width, initial-scale=.79"> -->
<meta name="author" content="Jason Hejna">
  <link rel="shortcut icon" href="images/gauge.ico">
  <link rel="icon" href="images/gauge.ico">
<title>HappyData</title>
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="js/indexjava.js"></script>
<link rel="stylesheet" href="css/960_24_col.css" />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div id="leftbartitle"></div>
<div class="container_24">
<div class="clear"></div>
<div class="grid_24" id="bartitle">
	<div class="grid_18 alpha">
    	<span class="title">HappyData</span><span class="titleme">.me</span>
	</div>
<div class="grid_12 omega">
	fuuu
</div>
</div>
<div class="clear"></div>
<div class="grid_17">
	gfd<br><br><br><br><br><br><br><br><br><br>hello
</div>
<div class="clear"></div>
</div>
</body>
</html>