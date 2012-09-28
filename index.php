<?php
include 'dbc.php';
page_protect();

if (isset($_SESSION['user_id'])) {
	$goturid = $_SESSION['user_id'];
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Happy Data</title>
<link rel="stylesheet" href="css/angrystyle.css" />
<link rel="stylesheet" href="css/960_24_col.css" />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
	<!-- jquery for the happiness buttons http://docs.jquery.com/UI/Button#theming -->
	<script type="text/javascript">
	var happiness;
	var unix_time;
	var date= new Date();
	$.fx.speeds._default = 700; //animation speed
	$(document).ready(function(){
		$("#radio1").click(function(){
    		//$("#boxin").hide();
			happiness = '1';
			
    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio2").click(function(){
    		//$("#radio").hide();
			happiness = '2';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio3").click(function(){
    		//$("#radio").hide();
			happiness = '3';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio4").click(function(){
    		//$("#radio").hide();
			happiness = '4';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  	});

	$(function() {
		$( "#radio" ).buttonset();
	});
	$(function() {
		$( "#dialog" ).dialog({
			resizable: false,
			height:140,
			autoOpen: false,
			show: "blind",
			hide: "explode",
			modal:true,
			buttons: {
						Submit: function() {
							countDown(80,"status");
							$( this ).dialog( "close" );
							//var unix = unix_time;
							$(".background").show();
							$.ajax({
							    type: 'post',
							    url: 'happypost.php',
							    data: {yahoo:unix_time,happiness:happiness},
							});
							
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						},
					}

		});
	});	
	</script>
</head>
<body>
<div class="container_24">
	<div class="clear"></div>
<div class="grid_5 prefix_19">
<div class="myaccount">
  <a href="mysettings.php">Settings</a>
  <a href="logout.php">Logout </a>
</div>
</div>
<div class="grid_18 prefix_3 suffix_3">
	<br/><br/>
	<div hidden class="background"><div id="status"></div></div>
	<div class="boxin">
		
	<center><h1 class="q">At this moment, would you say you are</h1>
	<form>
	<div id="radio">
		<input type="radio" id="radio1" name="radio" /><label for="radio1">very happy</label>
		<input type="radio" id="radio2" name="radio" /><label for="radio2">rather happy</label>
		<input type="radio" id="radio3" name="radio" /><label for="radio3">not very happy</label>
		<input type="radio" id="radio4" name="radio" /><label for="radio4">not at all happy</label>
	</div>
	</form>
	</center>
	<br/><br/>
		
	</div> <!-- end div of boxin css -->
</div>
<div class="clear"></div>
<div class="grid_24">
<div id="dialog" title="confirmation">
<p>hello<p>
</div>
<div class="clear"></div>
<div class="grid_24">

 <script type="text/javascript">
function countDown(secs,elem) {
var element = document.getElementById(elem);
element.innerHTML = ""+secs+" seconds remaining until you may answer again";
if(secs < 1) {
clearTimeout(timer);
$("#status").hide();
$(".background").hide();
 element.innerHTML = '<h2>Countdown Complete!</h2>';
 //element.innerHTML += '<a href="#">Click here now</a>';
 
}
secs--;
var timer = setTimeout('countDown('+secs+',"'+elem+'")',1000);
}
 </script>



</div>
</div> <!--where I left 960 end div -->
</body>
</html>
<?php }

?>