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
         //$('input.confirmfr').click(function() { 
          var confirmedid;
          var friendid;
        function rundialog(id){

          confirmedid = id;
        //var lolz = document.getElementById("conf").getAttribute("class");
        //var turnkey = this.class;
        //document.getElementById("conf").setAttribute("id","monkey");

          //var conf ='1';
          //$(this).class;
          //var confid = this;
        //var conf = '55';
        $( "#confirmdialog" ).dialog( "open" );
          return false; 
      }

      function runfriends(runfriendsid) {
        friendid = runfriendsid;
        $( "#connectdialog" ).dialog( "open" );
        return false;
      }
  $(document).ready(function(){
    //var cnfrm;
      $("#course").autocomplete("autocomplete.php", {
        width: 230,
        matchContains: true,
        selectFirst: false
      });

      // $("input#cdialog").click(function() {
      //   //var friendid = document.getElementById("cdialog").getAttribute("class");
      //   //var friendid = this.class;
      //   var friendid = $("input#cdialog").attr("class");
      //   $( "#connectdialog" ).dialog( "open" );
      //   return false;
      // });
    
       //$('input.confirmfr').click(function() { 
      //   $(function rundialog(){


      //   //var lolz = document.getElementById("conf").getAttribute("class");
      //   //var turnkey = this.class;
      //   document.getElementById("conf").setAttribute("id","monkey");

      //     //var conf ='1';
      //     //$(this).class;
      //     //var confid = this;
      //   //var conf = '55';
      //   $( "#confirmdialog" ).dialog( "open" );
      //     return false; 
      // });
      //confirm connection
/*      $("#confirmfr").click(function() {
        $("#confirmfr").load($(this).attr("class"));
        return false;
        $( "#confirm" ).dialog('open');
        
      });*/


    });

//confirm connection
/*  function confirmdfunc(id) {
    //var conf = document.getElementById("confirmfr").getAttribute("class");
    //var idd = id;
    $( "#confirm" ).dialog('open');
  }*/

		$(function() {
		$( ".usericons button:first" ).button({
            icons: {
                primary: "ui-icon-home"
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
              //var friendid = document.getElementById("cdialog").getAttribute("class");
              //var friendos = friendid;

                //$('.' + friendid).hide();
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

  //confirm connection
//var confid;
     

    $(function() {
      //var confid;
    $( "#confirmdialog" ).dialog({
      resizable: false,
      height:200,
      width:400,
      autoOpen: false,
      show: "blind",
      hide: "explode",
      modal:true,
      buttons: {
            Submit: function() {
              //var conf = document.getElementById(cnfrm).getAttribute("class");
              //$("input").attr("class:");
              //var confid;
              //var conf = document.getElementById("monkey").getAttribute("name");

              //var conf = this.getAttribute("name");
              //var confirmos = conf;
              //var conf = '55';
                //$('.' + friendid).hide();
              $( this ).dialog( "close" );
                  $.ajax({  
                    type: "POST",  
                    url: "confirmajax.php", 
                    data: {conf:confirmedid,},  
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
<div class="grid_18" id="bartitle">
    <div class="grid_7 alpha">
      &nbsp;&nbsp;&nbsp;
      <a href="index.php"><span class="title">MentalState </span></a>
    </div>
    <!-- end .grid_6.alpha -->
    <div class="grid_11 omega">
      
      <form action="friends.php" method="post">
      <input type="text" name="course" id="course"/>
      <input type="submit" />
      </form>
    
      <div class="usericons" style="float:right;">
			<button ONCLICK="window.location.href='index.php'">About this site</button>
			<button ONCLICK="window.location.href='mysettings.php'">Settings</button>
			<button ONCLICK="window.location.href='logout.php'">Logout</button>
			&nbsp;		
		</div>
    </div>

  </div><!-- end .grid_24 -->
 
<div class="clear"></div>
<div class="grid_4">
  <br><br><br><br>.
</div>
<div class="grid_14">
  <br><br><br><br>
  <?php include 'friends_inc.php'; ?>
</div>
<div class="clear"></div>
<div class="grid_24">
  <div id="connectdialog" title="Are you sure?">
    <span>Connecting with friends allows them to see some of your info. Are you sure?</span>
  </div>
  <div id="confirmdialog" title="Are you sure?">
    <span>Connecting with friends allows them to see some of your Info. Are you sure?</span>
  </div>
</div>
</div> <!-- end 960 -->
</body>
</html>
<?php } ?>