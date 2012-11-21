<?php

include 'dbc.php';
page_protect();

if (isset($_SESSION['user_id'])) {
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="Jason Hejna">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="images/gauge.ico">
<link rel="icon" href="images/gauge.ico">
<title>HappyData</title>
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

      function puzzle(dasi) {
      $iit=0;
      $iss=0;
        //$iit++;
/*        if ($iit = 1 || $iit >=3){}
        if ($iit >= 4) {$iit=0;}*/

        // $('#puzzle'+ dasi +'').hide();
        // $('#puzzle2'+ dasi +'').show();
/*        if ($iit == 2) {$iit=0;}
        
        setTimeout(function(){
        
        $('#puzzle2'+ dasi +'').hide();
        $('#puzzle'+ dasi +'').show();

        
        },1500);
        clearTimeout();*/
      
      while ($iss < 1) {
        $iss++;
        $('#puzzle'+ dasi +'').hide();
        $('#puzzle2'+ dasi +'').show();
        
        setTimeout(function(){
        $('#puzzle'+ dasi +'').show();
        $('#puzzle2'+ dasi +'').hide();
        
        },1500);
        clearTimeout();

      }
      }


  $(document).ready(function(){
      $('.puzzle2').hide();
      $("#mahem").click(function() {
        alert("Handler for .click() called.");
      });
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
            
            $('#userbox').hide();
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
            $('.rawz'+ confirmedid +'').hide();

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
</div> <!-- end .grid_24 -->
<div class="clear"></div>
<div class="grid_7 suffix_1">
  <br><br><br><br>
<div id="coltitle">My Friends</div>
<?php include 'friends_ihave.php'; ?>

</div>
<div class="grid_8" id="moremargin">
  <br><br><br><br>
  <?php include 'friends_inc.php'; ?>
</div>
<div class="grid_3">
  <br><br><br>
  .
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