<?php 
/*************** PHP LOGIN SCRIPT V 2.3*********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.

***********************************************************/
error_reporting (E_ALL ^ E_NOTICE);
include 'dbc.php';

$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value); //get variables are filtered.
}


if ($_POST['doLogin']=='Login')
{

foreach($_POST as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}


$user_email = $data['usr_email'];
$pass = $data['pwd'];


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";
    
}

	
$result = mysql_query("SELECT `id`,`pwd`,`full_name`,`approved`,`user_level` FROM users WHERE 
           $user_cond
			AND `banned` = '0'
			") or die (mysql_error()); 
$num = mysql_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
	
	list($id,$pwd,$full_name,$approved,$user_level) = mysql_fetch_row($result);
	
	if(!$approved) {
	//$msg = urlencode("Account not activated. Please check your email for activation code");
	$err[] = "Account not activated. Please check your email for activation code";
	
	//header("Location: login.php?msg=$msg");
	 //exit();
	 }
	 
		//check against salt
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	if(empty($err)){			

     // this sets session and logs user in  
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // this sets variables in the session 
		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $full_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		mysql_query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'") or die(mysql_error());
		
		//set a cookie 
		
	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
		  header("Location: index.php");
		 }
		}
		else
		{
		//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
		$err[] = "Invalid Login. Please try again with correct user email and password.";
		//header("Location: login.php?msg=$msg");
		}
	} else {
		$err[] = "Error - Invalid login. No such user exists";
	  }		
}
					 
?>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Jason Hejna">
  <link rel="shortcut icon" href="images/gauge.ico">
  <link rel="icon" href="images/gauge.ico">
<title>HappyData.me - Self-Reported Happiness Question</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/960_24_col.css" />
<link rel="stylesheet" href="css/loginstyle.css" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />


  <script type="text/javascript">


  $(function() { //jquery button register
        $( "button" )
            .button()
            .click(function( event ) {
                event.preventDefault();
            });
    });


$(function() {
    $( "#radio" ).buttonset();
  });

  
  $(document).ready(function(){
    $("#logForm").validate();
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();

      $("#txtbox").keyup(function(event){
    if(event.keyCode == 13){
        $("#doLogin3").click();
    }
  });
  });


  </script>

</head>

<body>

	  <?php
	  /******************** ERROR MESSAGES*************************************************
	  This code is to show error messages 
	  **************************************************************************/
	  if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";	
	   }
	  /******************************* END ********************************/	  
	  ?>

<div class="container_24">
<div class="clear"></div>
<div class="grid_24" id="bartitle">
  
<div class="grid_15 alpha">
      &nbsp;
      <a href="register.php"><span class="title">HappyData</span></a>
</div>
<div class="grid_3 omega">
..
    </div>


</div> <!-- end .grid_18 -->
<div class="clear"></div>

<div class="grid_9">
  <br><br><br><br><br>
  <div class="boxin" id="boxin">
<!--   <center>
    <img src="images/ilanguage.png" width="580" height="470"><br><br>
  </center> -->
  <br>
..
</div><!-- end div of boxin css -->
</div>
<div class="grid_9">
  <br><br><br>
<form action="login.php" method="post" name="logForm" id="logForm" >
            <span class="ftitle">Login</span><br><br>
            Email or Username:<br/>
            <input name="usr_email" type="text" class="required" id="txtbox" size="25" tabindex="1">
            <br/>
            Password:<br>
            <input name="pwd" type="password" class="required password" id="txtbox" size="25" tabindex="2">
            
            &nbsp;<a href="forgot.php">Forgot Password?</a><br>
            <input name="remember" type="checkbox" id="remember" value="1">
                Remember me
                <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="doLogin" type="submit" id="doLogin3" value="Login"  tabindex="3">
</form>
<center>
  <button ONCLICK="window.location.href='register.php'" style="font-size: 2.03em;padding:4px;">Register / Sign-Up</button><br>
</center>
  <h4>HappyData is free, and always will be.</h4>

  </div>
<div class="clear"></div>
</div>  <!-- end 960 container_24 --> 

</body>
</html>
