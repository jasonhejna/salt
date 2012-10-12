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
<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

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
	
	var happiness = 6;
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
$(document).ready(function(){
		//$('div#dischart').hide();
        $('div#dismap').show();
		$('div#disprog').hide();
		$('div#ilang').show();
		$('div#whylang').hide();

    $("#course").autocomplete("autocomplete.php", {
        width: 230,
        matchContains: true,
        selectFirst: false
    });

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
		$("#txtdialog").click(function(){
			$( "#textdialog" ).dialog( "open" );

		});
		//addign values when radio onlclick
		$("#radio1").click(function(){
    		//$("#boxin").hide();

			happiness = '5';
			
    		unix_time = date.getTime()/1000;

    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio2").click(function(){
    		//$("#radio").hide();

			happiness = '4';

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

			happiness = '2';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio5").click(function(){
    		//$("#radio").hide();

			happiness = '1';

    		unix_time = date.getTime()/1000;
    		$( "#dialog" ).dialog( "open" );
			return false;
  		});
  		$("#radio6").click(function(){
			happiness = '0';

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


/*function textdialog(){
	$( "#textdialog" ).dialog( "open" );
}*/

	$(function() {
		$( "#textdialog" ).dialog({
			resizable: false,
			height:200,
			width:400,
			autoOpen: false,
			show: "blind",
			hide: "explode",
			modal:true,
			buttons: {
						Submit: function() {
							var dataString = $("#textarea").serialize();
/*                       		$('div#dismap').show();
								$('div#disprog').hide();
								$('div#ilang').show();*/
								$('div#whylang').hide();
								
							$( this ).dialog( "close" );
							    $.ajax({  
							      type: "POST",  
							      url: "textconec.php",  
							      data: dataString,  
							      success: function() {  
							        //display message back to user here  
							      }  
							    });  
							    return false;  
							//$.post("textconec.php", $("#textarea").serialize());
							
						},
						Cancel: function() {
							$( this ).dialog( "close" );

						},
					}
		});
	});


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
                $('div#dismap').hide();
								$('div#disprog').show();
								$('div#ilang').hide();
								$('div#whylang').show();
								$('div#dischart').show();

							$( this ).dialog( "close" );

							$.ajax({
							    type: 'post',
							    url: 'happypost.php',
							    data: {time:unix_time,happiness:happiness,latylony:localStorage.lastLatLon},
							    success: function () {//On Successful service call
                       			countDown(660,"status");
                        		//question(happiness, happiness); 
                    			},
							});
							
						},
						Cancel: function() {
							$( this ).dialog( "close" );
							$('div#dismap').show();
							$('div#disprog').hide();
							$('div#ilang').show();
							$('div#whylang').hide();
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

    //autocomplete
  
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
 



<!-- coundown timer time -->
<script type="text/javascript">

	function countDown(secs,elem) {
	if (secs > 1) {
	var element = document.getElementById(elem);
	var mins = Math.round(secs/60);
	element.innerHTML = ""+mins+"minutes";
}
	if(secs < 1) {
	clearTimeout(timer);
	//var secs = 660;

	$('div#dismap').show();
	$('div#disprog').hide();
	$('div#ilang').show();
	$('div#whylang').hide();
	 element.innerHTML += 'go';
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
<div class="grid_4">
	<br>
	<div id="dismap">
	<div id="map"></div>
<form>
	
<input id="address1" type="text" name="address" value="here">
<input type="button" id="button1" value="Submit"/>
</form>

	</div>


			<div  id="disprog">
			<div hidden class="mini" id="status"></div>
			<div style="width:130px;height:24px" class="pbartop" id="progressbar"></div>
			</div>

</div>
<div class="grid_17">
	<br>

	<div id="ilang">
	<center>
		<img src="images/ilanguage.png"><br><br>
	<form>
	<div id="radio" class="radio">
		<input type="radio" id="radio1" name="radio" /><label for="radio1"><img src="images/hap1.png" width="50px" height="50px"></label>
		<input type="radio" id="radio2" name="radio" /><label for="radio2"><img src="images/hap2.png" width="50px" height="50px"></label>
		<input type="radio" id="radio3" name="radio" /><label for="radio3"><img src="images/hap6.png" width="50px" height="50px"></label>
		<input type="radio" id="radio4" name="radio" /><label for="radio4"><img src="images/hap5.png" width="50px" height="50px"></label>
		<input type="radio" id="radio5" name="radio" /><label for="radio5"><img src="images/hap3.png" width="50px" height="50px"></label>
		<input type="radio" id="radio6" name="radio" /><label for="radio6"><img src="images/hap4.png" width="50px" height="50px"></label>
	</div>
	</form>
	</center>
	<br><hr><br>
</div><!-- end div of boxin css -->
		<div id="whylang" >
			<br>
			<center>
				<img src="images/whylanguage.png">
			<form >
			<textarea id="textarea" name="textarea" rows="4" cols="57"></textarea>
			<br><br>
			<input type="button" value="Submit" id="txtdialog" for="txtdialog" />
		</form>
		</center>
		<br><hr><br>
	</div>

	
	<div id="dischart" class="dischart">
	<iframe frameborder="0" scrolling="no" width="680" height="400" marginheight="0" marginwidth="0" src="gchart.php" class="gchart"></iframe>
	</div>

</div>
<div class="clear"></div>
<div class="grid_24">
	<div id="dialog" title="Are you sure?">
		Are you sure you want to submit your happiness from 
		<span id="x"></span>,<span id="y"></span>?
	</div>
	<div id="textdialog" title="Are you sure?">
		<span>You will not have another opertunity to edit your response. Do you still want to submit?</span>
	</div>
</div>
</div> <!-- end of 960 grid -->

</body>
</html>