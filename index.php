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
                primary: "ui-icon-unlocked"
            },
            text: false
        })
	});
	
	var happiness = 5;
	var unix_time;
	var date = new Date();
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
	function question(happiness,happiness) {
								//$("#question0").show();
								//$("#question1").show();
								//$("#question2").show();
								//$("#question3").show();
	
							if (happiness == '1'){
								
								$("#question0").show();
								
							}
							else if (happiness == '2'){
								$("#question1").show();
								
							}
							else if (happiness == '3'){
								$("#question2").show();
								
							}
							else if (happiness == '4'){
								$("#question3").show();
							}
							else {
								
								//$("#question3").hide(); hide and display question again

							}
	}
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
							countDown(660,"status");
							
							$( this ).dialog( "close" );
							//var unix = unix_time;
							
							$(".boxin").hide();
							$(".background").show();
							$.ajax({
							    type: 'post',
							    url: 'happypost.php',
							    data: {yahoo:unix_time,happiness:happiness},
							    success: function () {//On Successful service call
                       			
                        		question(happiness, happiness);
                    			},
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
<div class="grid_5 prefix_16 suffix_3">
	<!-- <div class="myaccount">
	<div id="icons">
		<a class="ui-icon ui-icon-info" title="info" href="mysettings.php"></a>
		<a class="ui-icon ui-icon-wrench" title="Account" href="mysettings.php"></a>

		<a class="ui-icon ui-icon-circle-close" title="Logout" href="logout.php"></a>
	</div>
	</div> -->
	<div class="usericons">
	<button ONCLICK="window.location.href='mysettings.php'">About this site</button>
	<button ONCLICK="window.location.href='mysettings.php'">Settings</button>
	<button ONCLICK="window.location.href='logout.php'">Logout</button>
	</div>
</div>
	<div class="clear"></div>
	<div class="grid_18 prefix_3 suffix_3">

	<!-- coundown timer time -->
	 <script type="text/javascript">
	function countDown(secs,elem) {
	var element = document.getElementById(elem);
	var mins = Math.round(secs/60);
	element.innerHTML = ""+mins+"minutes";
	if(secs < 1) {
	clearTimeout(timer);
	$(".background").hide();
	$(".boxin").show();
	 element.innerHTML = 'gogogo';
	 //element.innerHTML += '<a href="#">Click here now</a>';
	}
	secs--;

	var timer = setTimeout('countDown('+secs+',"'+elem+'")',1000);

			$( "#progressbar" ).progressbar({
				
				value: secs/6.6
			});
	}
	 </script>
	
	<div class="clear"></div>
	<div hidden class="background">
		<center>
		<table border="0">
		<tr>
		<td><h2 class="mini" id="status"></h2></td>
		<td><div style="width:210px;height:20px;" class="pbartop" id="progressbar"></div></td>
		</tr>
		</table> 
		
			<h1 hidden class="q"  id="question0" name="question0">Why do you feel so happy?</h1>
			<h1 hidden class="q"  id="question1" name="question1">Why do you feel happy?</h1>
			<h1 hidden class="q"  id="question2" name="question2">why aren't you feeling very happy?</h1>
			<h1 hidden class="q"  id="question3" name="question3">why aren't you feeling happy?</h1>
			<form>
			<textarea rows="4" cols="50"></textarea><br/>
			<input type="submit" value="Submit">
		</form>
		<br/><br/>
		</center>
	</div>
	<div class="boxin">
		
	<center><h1 class="q">At this moment, would you say you are</h1>
	<form>
	<div id="radio" >
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





</div>
</div> <!--where I left 960 end div -->
</body>
</html>
<?php }

?>