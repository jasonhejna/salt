<?php
include 'dbc.php';
page_protect();

if (isset($_SESSION['user_id'])) {
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Mental State</title>
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/angrystyle.css" />
<link rel="stylesheet" href="css/960_24_col.css" />
<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
	<script type="text/javascript">
  $(document).ready(function(){
    

    $("#cdialog").click(function(){
      $( "#connectdialog" ).dialog( "open" );

    });
  });
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

    $(function() {
    $( "#connectdialog" ).dialog({
      resizable: false,
      height:200,
      width:400,
      autoOpen: false,
      show: "blind",
      hide: "explode",
      modal:true,
      buttons: {
            Submit: function() {
              //$("input").attr("class:");
              var friendid = document.getElementById("cdialog").getAttribute("class");

                $('div#userbox').hide();
                $('div#magnifyfriend').show();
              $( this ).dialog( "close" );
                  $.ajax({  
                    type: "POST",  
                    url: "connect.php", 
                    data: {friendid:friendid,},  
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
      <input type="submit" />
      </form>
    
      <div class="usericons" style="float:right;">
			<button ONCLICK="window.location.href=''">About this site</button>
			<button ONCLICK="window.location.href='mysettings.php'">Settings</button>
			<button ONCLICK="window.location.href='logout.php'">Logout</button>
			&nbsp;		
		</div>
    </div>

  </div><!-- end .grid_24 -->
 
<div class="clear"></div>
<div class="grid_6">
  <br><br>
</div>
<div class="grid_15">
  <br><br>
  <?php include 'friends_inc.php'; ?>
  <div id="magnifyfriend">
    <?php include 'friends_left.php'; ?>
  </div>
</div>
<div class="clear"></div>
<div class="grid_24">
  <div id="connectdialog" title="Are you sure?">
    <span>Do you want to Connect?</span>
  </div>
</div>
</div> <!-- end 960 -->
</body>
</html>
<?php } ?>