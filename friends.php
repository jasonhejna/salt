<?php
include 'dbc.php';
page_protect();

if (isset($_SESSION['user_id'])) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Happy Data</title>
<!-- <style type="text/css">
 #map { width: 150px; height: 150px; border: 0px; padding: 0px; }
 </style> -->
 <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/angrystyle.css" />
<link rel="stylesheet" href="css/960_24_col.css" />
<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
	<script type="text/javascript">
		$(function() {
		$( ".usericons button:first" ).button({
            icons: {
                primary: "ui-icon-info"
            },
            text: false
        }).next().button({
            icons: {
                primary: "ui-icon-wrench"
            },
            text: false
        }).next().button({
            icons: {
                primary: "ui-icon-locked"
            },
            text: false
        })
		});
		$(document).ready(function(){
		$("#course").autocomplete("autocomplete.php", {
        width: 230,
        matchContains: true,
        selectFirst: false
    	});
		});
	</script>
</head>
<body>
<div class="container_24">
<div class="clear"></div>
<div class="grid_21" id="bartitle">
    <div class="grid_7 alpha">
      &nbsp;&nbsp;&nbsp;
      <span class="title">MentalState </span>
    </div>
    <!-- end .grid_6.alpha -->
    <div class="grid_14 omega">
      
      <form action="friends.php" method="post">
      <input type="text" name="course" id="course"/>
      <input type="submit" /> </form>
    
      <div class="usericons" style="float:right;">
			<button ONCLICK="window.location.href=''">About this site</button>
			<button ONCLICK="window.location.href='mysettings.php'">Settings</button>
			<button ONCLICK="window.location.href='logout.php'">Logout</button>
			&nbsp;		
		</div>
    </div>

  </div><!-- end .grid_24 -->
 
<div class="clear"></div>
<div class="grid_4">
</div>
<div class="grid_17">
</div>
</body>
</html>
<?php } ?>