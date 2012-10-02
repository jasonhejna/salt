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
                primary: "ui-icon-locked"
            },
            text: false
        })
	});
	
	var happiness = 5;
	var unix_time;
	var date = new Date();
	$.fx.speeds._default = 700; //animation speed

	$(document).ready(function(){
//$(".visualization").hide();
		//make sure things are hidden in IE, since IE doesn't like the hidden tag
		//$('div[id~="proghide"]').css({"display":"none"});
		$('div[id~="foxbox"]').css({"display":"none"});
		$('h1[id~="question0"]').css({"display":"none"});
		$('h1[id~="question1"]').css({"display":"none"});
		$('h1[id~="question2"]').css({"display":"none"});
		$('h1[id~="question3"]').css({"display":"none"});
		
		$("#radio1").click(function(){
    		//$("#boxin").hide();
			happiness = '3';
			
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
			happiness = '1';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio4").click(function(){
    		//$("#radio").hide();
			happiness = '0';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});

  	});

	$(function() {
		$( "#radio" ).buttonset();
	});
	function question(happiness,happiness) {
							if (happiness == '3'){
								$("#question0").show();
							}
							else if (happiness == '2'){
								$("#question1").show();
							}
							else if (happiness == '1'){
								$("#question2").show();
							}
							else if (happiness == '0'){
								$("#question3").show();
							}
							else {
								//$("#question3").hide(); hide and display question again
							}
	}
	$(function() {
		$( "#dialog" ).dialog({

			resizable: false,
			height:230,
			autoOpen: false,
			show: "blind",
			hide: "explode",
			modal:true,
			buttons: {
						Submit: function() {
							
							$('h1[id~="question0"]').css({"display":"none"});
							$('h1[id~="question1"]').css({"display":"none"});
							$('h1[id~="question2"]').css({"display":"none"});
							$('h1[id~="question3"]').css({"display":"none"});

							$( this ).dialog( "close" );

							$.ajax({
							    type: 'post',
							    url: 'happypost.php',
							    data: {yahoo:unix_time,happiness:happiness},
							    success: function () {//On Successful service call
                       			countDown(23,"status");
                        		question(happiness, happiness); 
                        		//trying to fucking hide the highlighted radio button after the countdown
                        		//$("input:radio").removeAttr("checked");
                        		//$(this).attr('checked', false);
                        		//$('form[id^="radform"]').find("input:radio:checked").removeAttr("checked");
                        		//$('form[id^="radform"]').find("input:radio:checked").attr('checked', false);
                        		//$('form[id^="form-"]').find("input:radio:checked").prop('checked',false);


                        		$(".boxin").hide();
								$(".background").show();
								$(".foxbox").show();
								$("#charthider").show();
								$(".proghide").show();
								//$(".hidevis").hide();
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
<div class="grid_9 prefix_3">.
<div hidden class="proghide" id="proghide" style="float:left;">
			<div hidden class="mini" id="status"></div>
			<div style="width:210px;height:20px;" class="pbartop" id="progressbar"></div>
	</div>
</div>


<div class="grid_8 suffix_4">
			<div class="usericons" style="float:right;">
			<button ONCLICK="window.location.href=''">About this site</button>
			<button ONCLICK="window.location.href='mysettings.php'">Settings</button>
			<button ONCLICK="window.location.href='logout.php'">Logout</button>
			</div>

</div>

<div class="clear"></div>
<!-- coundown timer time -->
<script type="text/javascript">
	function countDown(secs,elem) {
	if (secs > -1) {
	var element = document.getElementById(elem);
	var mins = Math.round(secs/60);
	element.innerHTML = ""+mins+"minutes";
}
	if(secs < 1) {
	clearTimeout(timer);
	//var secs = 660;

	$(".boxin").show();
	$(".foxbox").hide();
	$(".proghide").hide();
	$(".background").show();
	$(".progressbar").hide();



	 element.innerHTML += 'go';
	 //element.innerHTML += '<a href="#">Click here now</a>';
	}
	secs--;

	var timer = setTimeout('countDown('+secs+',"'+elem+'")',1000);

			$( "#progressbar" ).progressbar({
				
				value: secs
			});
		
	
	}
</script>
<div class="clear"></div>
<div class="grid_17 prefix_4 suffix_3">
	<br/>
	<div hidden class="background">
		<center>
		<div hidden class="foxbox" id="foxbox">
		<table border="0">
		<tr>
			<td>
			<h1 hidden class="hide"  id="question0" name="question0">Why do you feel so happy?</h1>
			<h1 hidden class="hide"  id="question1" name="question1">Why do you feel happy?</h1>
			<h1 hidden class="hide"  id="question2" name="question2">Why aren't you feeling very happy?</h1>
			<h1 hidden class="hide"  id="question3" name="question3">Why aren't you feeling happy?</h1>
			</td>
			<td><h1 style="color:#A9A9A9;font-size: 1.4em;" class="greyed">(optional) </h1></td>
		</tr>
		</table> 
			<form>
			<textarea rows="4" cols="57"></textarea><br/><br/>
			<input type="submit" value="Submit">
		</form>
	</div>
		<br/><br/>
		</center>

</div>
</div> <!-- end of 960 of all of form -->
<div class="clear"></div>
<div class="grid_17 prefix_4 suffix_3">
	<div class="boxin" id="boxin">
	<center>
		<br/><img src="images/ilanguage.png"><br/><br/>
	<form id="radform">
	<div id="radio" class="radio">
		<input type="radio" id="radio1" name="radio" /><label for="radio1"><img src="images/hap1.png" width="50px" height="50px"></label>
		<input type="radio" id="radio2" name="radio" /><label for="radio2"><img src="images/hap2.png" width="50px" height="50px"></label>
		<input type="radio" id="radio3" name="radio" /><label for="radio3"><img src="images/hap3.png" width="50px" height="50px"></label>
		<input type="radio" id="radio4" name="radio" /><label for="radio4"><img src="images/hap4.png" width="50px" height="50px"></label>
	</div>
	</form>
	</center>
	<br/>

</div><!-- end div of boxin css -->
</div>
<div class="clear"></div>
<div class="grid_20 prefix_4">
	<br/>
	<div hidden id="charthider">
	<iframe frameborder="0" width="670" height="500" marginheight="0" marginwidth="0" src="gchart.php"></iframe>
	</div>

</div>

<div class="clear"></div>
<div class="grid_24">
	<div id="dialog" title="?">
		Are you sure?
	</div>
</div>

</div> <!-- end of 960 grid -->

</body>
</html>
<?php }

?>