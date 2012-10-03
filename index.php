<?php
include 'dbc.php';
page_protect();

if (isset($_SESSION['user_id'])) {

	$goturid = $_SESSION['user_id'];
date_default_timezone_set('America/New_York');
	}
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


 <script type="text/javascript" src="http://www.google.com/jsapi"></script>
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

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
	var geocoder = new google.maps.Geocoder();
/*	var icon = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/blue.png",
 		new google.maps.Size(32, 32),
 		new google.maps.Point(0, 0),
 		new google.maps.Point(16, 32)
 	);
 	var center = null;
 	var map = null;
 	var currentPopup;
 	var bounds = new google.maps.LatLngBounds();*/
 	
	$.fx.speeds._default = 700; //animation speed

		//make sure things are hidden in IE, since IE doesn't like the hidden tag
		//$('div[id~="proghide"]').css({"display":"none"});
		
		//$('div[id~="foxbox"]').css({"display":"none"});
		//$(".foxbox").toggle();

		//$('div[id~="charthider"]').css({"display":"none"});
		$('h1[id~="question0"]').css({"display":"none"});
		$('h1[id~="question1"]').css({"display":"none"});
		$('h1[id~="question2"]').css({"display":"none"});
		$('h1[id~="question3"]').css({"display":"none"});


	$(document).ready(function(){
//document.getElementById(foxbox).style.display = 'none'; 

	if(!localStorage.lastLatLon){
		geocoder.geocode( { 'address': 
		<?php
        $result = mysql_query("SELECT * FROM users WHERE `id` = $goturid");
        while($row = mysql_fetch_array($result)){
        $country = $row['country'];
        echo "'$country'";
        }
		?>
		}, function(results, status) {
          		if (status == google.maps.GeocoderStatus.OK) {
          			lat = results[0].geometry.location.lat();
          			lon = results[0].geometry.location.lng();
          			latlon = lat+","+lon;
          			localStorage.lastLatLon = latlon;
          			var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=2&size=150x150&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
  					document.getElementById("map").innerHTML="<img src='"+img_url+"'>";
          		}
          		else {
            		alert("Something went wrong " + status);
          		}
          	});
          }
        else{
        //localStorage.lastLatLon = '0,0'
        	var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=10&size=150x150&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
  			document.getElementById("map").innerHTML="<img src='"+img_url+"'>";
        }
	
		document.getElementById("y").innerHTML = localStorage.lastLatLon;
		$.getLocation();
		
		$("#radio1").click(function(){
    		//$("#boxin").hide();
			happiness = '4';
			
    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio2").click(function(){
    		//$("#radio").hide();
			happiness = '3';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio3").click(function(){
    		//$("#radio").hide();
			happiness = '2';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio4").click(function(){
    		//$("#radio").hide();
			happiness = '1';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#button1").click(function(){
			geocoder.geocode( { 'address': document.getElementById("address1").value}, function(results, status) {
          		if (status == google.maps.GeocoderStatus.OK) {
          			lat = results[0].geometry.location.lat();
          			lon = results[0].geometry.location.lng();
          			localStorage.lastLatLon = lat+","+lon;
        			var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=10&size=150x150&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
  					document.getElementById("map").innerHTML="<img src='"+img_url+"'>";
  					//document.getElementById("x").innerHTML = document.getElementById("address1").value;
  					document.getElementById("y").innerHTML = localStorage.lastLatLon;
            		//alert("location : " + results[0].geometry.location.lat() + " " +results[0].geometry.location.lng());
            		
            		//var latlngStr = localStorage.lastLatLon.split(",",2);
   					//var lat = parseFloat(latlngStr[0]);
    				//var lng = parseFloat(latlngStr[1]);
    				var latlng = new google.maps.LatLng(lat, lon);
					geocoder.geocode({'latLng': latlng}, function(resultz, status) {
	      				if (status == google.maps.GeocoderStatus.OK) {
			          		document.getElementById("x").innerHTML=resultz[1].formatted_address;
    			   		}
      					else {
        					alert("Geocoder failed due to: " + status);
		        		}
	    		  	}); 
          		} else {
            		alert("Something went wrong " + status);
          		}
        	});
        	
		});
  	});

	$(function() {
		$( "#radio" ).buttonset();
	});
	function question(happiness,happiness) {
							if (happiness == '4'){
								$("#question0").show();
							}
							else if (happiness == '3'){
								$("#question1").show();
							}
							else if (happiness == '2'){
								$("#question2").show();
							}
							else if (happiness == '1'){
								$("#question3").show();
							}
							else {
								//$("#question3").hide(); hide and display question again
							}
	}
	
	$.showError = function(error){ 
	  switch(error.code) {
		case error.PERMISSION_DENIED:
	    	document.getElementById("x").innerHTML="User denied the request for Geolocation.";
	    	//var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=10&size=150x150&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
  			//document.getElementById("map").innerHTML="<img src='"+img_url+"'>";
  			break;
		case error.POSITION_UNAVAILABLE:
			document.getElementById("x").innerHTML="Location information is unavailable.";
		    break;
    	case error.TIMEOUT:
			document.getElementById("x").innerHTML="The request to get user location timed out.";
      		break;
    	case error.UNKNOWN_ERROR:
      		document.getElementById("x").innerHTML="An unknown error occurred.";
      		break;
    	}
    	//document.getElementById("x").innerHTML="hkafks";
  	};
  	$.getLocation = function() { //retrieves geolocation, send to showposition function
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition($.showPosition,$.showError);
			var latlngStr = localStorage.lastLatLon.split(",",2);
   			var lat = parseFloat(latlngStr[0]);
    		var lng = parseFloat(latlngStr[1]);
    		var latlng = new google.maps.LatLng(lat, lng);
			geocoder.geocode({'latLng': latlng}, function(results, status) {
      			if (status == google.maps.GeocoderStatus.OK) {
	          		document.getElementById("x").innerHTML=results[0].formatted_address;
    	   		}
      			else {
        			alert("Geocoder failed due to: " + status);
	        	}
    	  	});
    	}
		else{
			document.getElementById("x").innerHTML="Geolocation is not supported by this browser.";
		}
	};
  	$.showPosition = function(position){ //shows geolocation on the "map" image
		var latlon=position.coords.latitude+","+position.coords.longitude;
		var latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
		
		geocoder.geocode({'latLng': latlng}, function(results, status) {
      		if (status == google.maps.GeocoderStatus.OK) {
          		document.getElementById("x").innerHTML=results[0].formatted_address;
       		}
      		else {
        		alert("Geocoder failed due to: " + status);
        	}
      	});
  		var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=10&size=150x150&sensor=false&markers=color:blue|"+latlon;
  		document.getElementById("map").innerHTML="<img src='"+img_url+"'>";
  		localStorage.lastLatLon = latlon;
  		document.getElementById("y").innerHTML = localStorage.lastLatLon;
  	};
/*
	$.addMarker= function(lat, lng, info) {
		var pt = new google.maps.LatLng(lat, lng);
		bounds.extend(pt);
		var marker = new google.maps.Marker({
 			position: pt,
 			icon: icon,
 			map: map
		});
 		var popup = new google.maps.InfoWindow({
 			content: info,
 			maxWidth: 300
 	});
 	};
 	
 	$.initMap = function() {
 		map = new google.maps.Map(document.getElementById("map"), {
 			center: new google.maps.LatLng(0, 0),
	 		zoom: 2,
 			mapTypeId: google.maps.MapTypeId.ROADMAP,
 			mapTypeControl: false,
	 		mapTypeControlOptions: {
 				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR
 			},
	 		navigationControl: true,
 			navigationControlOptions: {
 				style: google.maps.NavigationControlStyle.SMALL
	 		}
 		});
 		$.addMarker(0,0,'yoyo');
 	 	center = bounds.getCenter();
	 	//map.fitBounds(bounds);
 		};*/
	$(function() {
		$( "#dialog" ).dialog({
			resizable: false,
			height:200,
			width:400,
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
							    data: {time:unix_time,happiness:happiness,latylony:localStorage.lastLatLon},
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
								$(".proghide").show();
								$(".visualization").show();
								
								

                    			},
							});
							
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						},
					}
		});
	});
//google calendar
google.load('visualization', '1', {packages: ['annotatedtimeline']});
    function drawVisualization() {


    var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'your happiness');
      data.addColumn('string', 'title1');
      data.addColumn('string', 'text1');

      data.addRows([
        
        <?php
        $result = mysql_query("SELECT `happiness`, `unix_time` FROM happy WHERE `user_id` = $goturid");
        while($row = mysql_fetch_array($result)){
        $time = $row['unix_time'];// -(31*24*60*60);
        $ftime = strftime("%Y,%m-1,%d,%H,%M,%S",$time);
        $happz = $row['happiness'];
        echo "[new Date($ftime), $happz, null, null],";
        }
		?>
      ]);
    
      var annotatedtimeline = new google.visualization.AnnotatedTimeLine(
          document.getElementById('visualization'));
      annotatedtimeline.draw(data, {'displayAnnotations': true});
    }
    
    google.setOnLoadCallback(drawVisualization);
	</script>
</head>
<body>
<div class="container_24">
<div class="clear"></div>
<div class="grid_9 prefix_3"><span style="color:#FFF;">.</span>
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
			//make sure things are hidden in IE, since IE doesn't like the hidden tag
		//$('div[id~="proghide"]').css({"display":"none"});
	//document.getElementById(foxbox).style.display = 'none'; 
	$(".proghide").hide();
	$(".background").show();




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
<div class="grid_17 suffix_3">
	<br/>
	<div hidden class="background">
		<center>
		<div hidden class="foxbox" id="foxbox" style="display:none">
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
<div class="grid_4">
	<div id="map"></div>
<form>
	
<input id="address1" type="text" name="address" value="miami,FL">
<input type="button" id="button1" value="Submit"/>
</form>
</div>
<div class="grid_17 suffix_3">
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
	<div id="charthider">
	<iframe frameborder="0" scrolling="no" width="670" height="500" marginheight="0" marginwidth="0" src="gchart.php" class="gchart"></iframe>
	</div>
</div>

<div class="clear"></div>
<div class="grid_24">
	<div id="dialog" title="confirmation">
	</div>
</div>
<div id="x"></div>
<div id="y"></div>
</div> <!-- end of 960 grid -->

</body>
</html>