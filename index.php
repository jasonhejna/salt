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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<meta name="viewport" content="width=device-width, initial-scale=.79"> -->
<meta name="author" content="Jason Hejna">
  <link rel="shortcut icon" href="images/gauge.ico">
  <link rel="icon" href="images/gauge.ico">
<title>HappyData</title>
<!-- <style type="text/css">
 #map { width: 274px; height: 274px; border: 0px; padding: 0px; }
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
    $( ".searchicon button:first" ).button({
            icons: {
                primary: "ui-icon-search"
            },
            text: false
          })
    });

		$(function() {
		$( ".usericons button:first" ).button({
            icons: {
                primary: "ui-icon-person"
            },
            text: false
        }).next().button({
            icons: {
                primary: "ui-icon-contact"
            },
            text: false
        }).next().button({
            icons: {
                primary: "ui-icon-comment"
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
 	
$.fx.speeds._default = 700; //animation speed
$(document).ready(function(){
    $('div#dismap').show();
		$('div#disprog').hide();
		$('div#ilang').show();
		$('div#whylang').hide();
    //$('div#dischart').hide();
    //$('#y').hide();

    $("#button1").click(function(){
			geocoder.geocode( { 'address': document.getElementById("address1").value}, function(results, status) {
          		if (status == google.maps.GeocoderStatus.OK) {
          			lat = results[0].geometry.location.lat();
          			lon = results[0].geometry.location.lng();
          			localStorage.lastLatLon = lat+","+lon;
        			var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=10&size=274x274&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
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
        					//alert("Geocoder failed due to: " + status);
        					$( "#mapdialog" ).dialog( "open" );
							return false;
		        		}
	    		  	}); 
          		} else {
            		//alert("Something went wrong " + status);
            		$( "#mapdialog" ).dialog( "open" );
					return false;
          		}
          		setTimeout(loctime,800);
        	});
        	
		});

    $("#course").autocomplete("autocomplete.php", {
        width: 290,
        matchContains: true,
        selectFirst: false,
        minLength: 3,
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
          			//localStorage.lastLatLon = latlon;
          			var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=2&size=274x274&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
  					document.getElementById("map").innerHTML="<img src='"+img_url+"'>";
          		}
          		else {
            		//alert("Something went wrong " + status);
            		$( "#mapdialog" ).dialog( "open" );
					return false;

          		}
          	});
          }
        else{
        //localStorage.lastLatLon = '0,0'
        	var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=10&size=274x274&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
  			document.getElementById("map").innerHTML="<img src='"+img_url+"'>";

        }
        

	          		
		document.getElementById("y").innerHTML = localStorage.lastLatLon;

		$.getLocation();

  	}); //end ducument ready

	$(function() {
		$( "#radio" ).buttonset();
	});
	
	$.showError = function(error){ 
	  switch(error.code) {
		case error.PERMISSION_DENIED:
	    	document.getElementById("x").innerHTML="User denied the request for Geolocation.";
	    	//var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+localStorage.lastLatLon+"&zoom=10&size=274x274&sensor=false&markers=color:blue|"+localStorage.lastLatLon;
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
  		var img_url="http://maps.googleapis.com/maps/api/staticmap?center="+latlon+"&zoom=10&size=274x274&sensor=false&markers=color:blue|"+latlon;
  		document.getElementById("map").innerHTML="<img src='"+img_url+"'>";
  		localStorage.lastLatLon = latlon;
  		document.getElementById("y").innerHTML = localStorage.lastLatLon;
  	};

	$(function() {
		$( "#mapdialog" ).dialog({
			resizable: false,
			height:200,
			width:400,
			autoOpen: false,
			show: "blind",
			hide: "explode",
			modal:true,
			buttons: {
						
						Done: function() {
							$( this ).dialog( "close" );

						},
					}
		});
		$("#address1").keyup(function(event){
		    if(event.keyCode == 13){
		        $("#button1").click();
		    }
		});

	});

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
							var datastring = $('#text').val();
							//var datastring = $("#textarea").serialize();
/*                       		$('div#dismap').show();
								$('div#disprog').hide();
								$('div#ilang').show();*/
								$('div#whylang').hide();
								
							$( this ).dialog( "close" );

							    $.ajax({  
							      type: 'POST',  
							      url: 'textconec.php',  
							      data: {dataString:datastring},
							      success: function() {  
							        
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
								//$('div#dischart').show();

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
	$(function() {
		$( "#newlocdialog" ).dialog({
			resizable: false,
			height:200,
			width:400,
			autoOpen: false,
			show: "blind",
			hide: "explode",
			modal:true,
			buttons: {
						Submit: function() {
								
							$( this ).dialog( "close" );

/*							    $.ajax({  
							      type: 'POST',  
							      url: 'addlocation.php',  
							      data: {locname:locname},
							      success: function() {  
							        //display message back to user here  
							      }  
							    });
							    return false;  */
							
						},
						Cancel: function() {
							$( this ).dialog( "close" );

						},
					}
		});
	});
/*	$(function() {
		$( "#latlonstart" ).dialog({
			resizable: false,
			height:200,
			width:400,
			autoOpen: false,
			show: "blind",
			hide: "explode",
			modal:true,
			buttons: {
				Submit: function() {
                

							$( this ).dialog( "close" );

							$.ajax({
							    type: 'post',
							    url: 'locations.php',
							    data: {supbro:localStorage.lastLatLon},
							    success: function () {//On Successful service call
                       			
                        		//question(happiness, happiness); 
                    			},
							});
							
						},
						Cancel: function() {
							$( this ).dialog( "close" );

						},
					}
		});
	});*/

//google calendar
google.load('visualization', '1', {packages: ['annotatedtimeline']});
    function drawVisualization() {


    var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'My happiness');
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

    $(document).ready(function(){
  var limitnum = 127; // set your int limit for max number of characters
  
  function limiting(obj, limit) {
    var cnt = $("#counter > span");
    var txt = $(obj).val(); 
    var len = txt.length;
    
    // check if the current length is over the limit
    if(len > limit){
       $(obj).val(txt.substr(0,limit));
       $(cnt).html(limit-len);
     } 
     else { 
       $(cnt).html(limit-len);
     }
     
     // check if user has less than 20 chars left
     if(limit-len <= 20) {
      $(cnt).addClass("warning");
     }
  }


  $('textarea').keyup(function(){
    limiting($(this), limitnum);
  });
});

//countdown timer
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

/*okayso = localStorage.lastLatLon;
function SetCookie(cookiebro,okayso,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null || nDays==0) nDays=9999;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)
                 + ";expires="+expire.toGMTString();
}*/

$(document).ready(function(){
	
	document.getElementById("button1").onclick = function() { HideError(id); }

	$("#txtdialog").click(function(){
			$( "#textdialog" ).dialog( "open" );

		});
		//map click button
		$("#map").click(function(){
			$( "#mapdialog" ).dialog( "open" );
			return false;
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
});
setTimeout(loctime,800);
function loctime(){

   								$.ajax({
							    type: 'post',
							    url: 'locations.php',
							    data: {lati:localStorage.lastLatLon},
							    success: function (result) {//On Successful service call
							    $('#locname').attr("value", result);
							    if (result == "Set a new location") {
							    	//$( "#mapdialog" ).dialog( "close" );
							    	//$( "#newlocdialog" ).dialog( "open" ); set time instead
							    	setTimeout(sweetime,800);
							    }
                    			},
							});

}
function sweetime(){
	$.ajax({
	type: 'post',
	url: 'otheruserloc.php',
	 data: {lati2:localStorage.lastLatLon},
	success: function (otherloc) {//On Successful service call
	//$('#locname').attr("value", otherloc);
	//alert(otherloc);
	$( "#newlocdialog" ).dialog( "open" );
    },
	});
}

</script>
</head>
<body>

<div class="container_24">
<div class="clear"></div>
<div class="grid_24" id="bartitle">
  
<div class="grid_8 alpha">
      &nbsp;
      <a href="friends.php" id="titleid"><span class="title">HappyData</span><span class="titleme">&nbsp;.me</span></a>
</div>
<div class="grid_16 omega">
    
      <form action="friends.php" method="post">
        <div class="searchicon">
      

      <input type="text" name="course" id="course" />
      <button id="uniqueny1" type="submit" class="searchbutton" >Find Friends</button>
    
      </form>
    </div>
      <div class="usericons">
      		<button id="uniqueny2" ONCLICK="window.location.href='myprofile.php'" class="topbutton">My Profile</button>
			<button id="uniqueny3" ONCLICK="window.location.href='friends.php'" class="topbutton">Friends</button>
			<button id="uniqueny4" ONCLICK="window.location.href='messenger.php'" class="topbutton">Messages</button>
			<button id="uniqueny5" ONCLICK="window.location.href='mysettings.php'" class="topbutton">Settings</button>
			<button id="uniqueny6" ONCLICK="window.location.href='logout.php'" class="topbutton">Logout</button>
    </div>
</div>
</div> <!-- end .grid_18 -->
<div class="clear"></div>
<div class="grid_8">
	<br><br><br><br><br>
	<div id="dismap">
	<div id="map"></div>
<span id="coltitle">&#8627;</span><input type="text" id="locname"></input>


	</div>

</div>
<div class="grid_16">
	<div id="ilang">
    <br><br><br><br><br>
		<!-- <img src="images/ilanguage.png"><br><br> -->
		
	<form>
	<div id="radio" class="radio">
		<input type="radio" id="radio1" name="radio" /><label for="radio1"><img src="images/hap1.png" width="68.915px" height="68.915px"></label>
		<input type="radio" id="radio2" name="radio" /><label for="radio2"><img src="images/hap2.png" width="68.915px" height="68.915px"></label>
		<input type="radio" id="radio3" name="radio" /><label for="radio3"><img src="images/hap6.png" width="68.915px" height="68.915px"></label>
		<input type="radio" id="radio4" name="radio" /><label for="radio4"><img src="images/hap5.png" width="68.915px" height="68.915px"></label>
		<input type="radio" id="radio5" name="radio" /><label for="radio5"><img src="images/hap3.png" width="68.915px" height="68.915px"></label>
		<input type="radio" id="radio6" name="radio" /><label for="radio6"><img src="images/hap4.png" width="68.915px" height="68.915px"></label>
	</div>
	</form>
	<br>
	<span id="coltitle">&#8627;At this moment, which best describes how you feel?</span>
	<br><br>
</div><!-- end div of boxin css -->
</div> <!-- end grid 15 -->
<div class="clear"></div>
<div class="grid_19">
	
	      	<div  id="disprog">
			<div hidden class="mini" id="status"></div>
			<div style="width:130px;height:24px;float:left;" class="pbartop" id="progressbar"></div>
			</div>
			<br><br>
		<div id="whylang" >
				<!-- <img src="images/whylanguage.png"> -->
			<form >
    <div id="w">
    	<span id="coltitle">
    		Why do you feel this way? (optional)
		</span><br>
      <textarea name="text" id="text" class="txt" tabindex="1" autofocus="autofocus" rows="3" cols="60"></textarea>
      <p id="counter" style="display:inline; margin:0px;font-family: Trebuchet MS, Tahoma, Verdana, Arial, sans-serif; font-size: 1.1em;color:#BABABA;float:right;margin-right:240px;"><span>127</span> to go.</p>
      &nbsp;&nbsp;
      <input type="button" value="Submit" id="txtdialog" for="txtdialog" style="float:right;margin-right:15px;" />
    </div>

		</form>

		<br>
	
	</div>
		
</div>
<div class="clear"></div>
<div class="grid_24">
	<div id="dialog" title="Are you sure?">
		Are you sure you want to submit your happiness from 
		<span id="x"></span>?
	</div>
	<div id="textdialog" title="Are you sure?">
		<span>You will not have another opportunity to edit your response. Do you still want to submit?</span>
	</div>
	<div id="mapdialog" title="Update your Address">
	<span>
		<form>
		<input id="address1" type="text" name="address" value="Address" width="30">
		<input type="button" id="button1" value="Search" tabindex="1" />
		</form>
	</span>
	</div>
		<span id="y"></span>
	<div id="newlocdialog" title="Set a new location">
		Where are you?<br> ex) Home, Comet Coffee, Work at Microsoft, Gym
		<span>
	</div>
	  
</div>
</div> <!-- end of 960 grid -->

</body>
</html>