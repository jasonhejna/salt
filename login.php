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
//error_reporting (E_ALL ^ E_NOTICE);
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
					 
// start of user registration php
$err = array();
                     
if($_POST['doRegister'] == 'Register') 
{ 
/******************* Filtering/Sanitizing Input *****************************
This code filters harmful script code and escapes data of all POST data
from the user submitted form.
*****************************************************************/
foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
}

/********************* RECAPTCHA CHECK *******************************
This code checks and validates recaptcha
****************************************************************/
 require_once('recaptchalib.php');
     
      $resp = recaptcha_check_answer ($privatekey,
                                      $_SERVER["REMOTE_ADDR"],
                                      $_POST["recaptcha_challenge_field"],
                                      $_POST["recaptcha_response_field"]);

      if (!$resp->is_valid) {
        die ("<h3>Image Verification failed!. Go back and try again.</h3>" .
             "(reCAPTCHA said: " . $resp->error . ")");         
      }
/************************ SERVER SIDE VALIDATION **************************************/
/********** This validation is useful if javascript is disabled in the browswer ***/

if(empty($data['full_name']) || strlen($data['full_name']) < 4)
{
$err[] = "ERROR - Invalid name. Please enter atleast 3 or more characters for your name";
//header("Location: register.php?msg=$err");
//exit();
}

// Validate User Name
if (!isUserID($data['user_name'])) {
$err[] = "ERROR - Invalid user name. It can contain alphabet, number and underscore.";
//header("Location: register.php?msg=$err");
//exit();
}

// Validate Email
if(!isEmail($data['usr_email'])) {
$err[] = "ERROR - Invalid email address.";
//header("Location: register.php?msg=$err");
//exit();
}
// Check User Passwords
if (!checkPwd($data['pwd'],$data['pwd2'])) {
$err[] = "ERROR - Invalid Password or mismatch. Enter 5 chars or more";
//header("Location: register.php?msg=$err");
//exit();
}
      
$user_ip = $_SERVER['REMOTE_ADDR'];

// stores sha1 of password
$sha1pass = PwdHash($data['pwd']);

// Automatically collects the hostname or domain  like example.com) 
$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

// Generates activation code simple 4 digit number
$activ_code = rand(1000,9999);

$usr_email = $data['usr_email'];
$user_name = $data['user_name'];
$approved = '1';

/************ USER EMAIL CHECK ************************************
This code does a second check on the server side if the email already exists. It 
queries the database and if it has any existing email it throws user email already exists
*******************************************************************/

$rs_duplicate = mysql_query("select count(*) as total from users where user_email='$usr_email' OR user_name='$user_name'") or die(mysql_error());
list($total) = mysql_fetch_row($rs_duplicate);

if ($total > 0)
{
$err[] = "ERROR - The username/email already exists. Please try again with different username and email.";
//header("Location: register.php?msg=$err");
//exit();
}
/***************************************************************************/

if(empty($err)) {

$sql_insert = "INSERT into `users`
            (`full_name`,`user_email`,`pwd`,`date`,`users_ip`,`activation_code`,`user_name`,`approved`
            )
            VALUES
            ('$data[full_name]','$usr_email','$sha1pass',now(),'$user_ip','$activ_code','$user_name','$approved'
            )
            ";
            
mysql_query($sql_insert,$link) or die("Insertion Failed:" . mysql_error());
$user_id = mysql_insert_id($link);  
$md5_id = md5($user_id);
mysql_query("update users set md5_id='$md5_id' where id='$user_id'");
//  echo "<h3>Thank You</h3> We received your submission.";

if($user_registration)  {
$a_link = "
*****ACTIVATION LINK*****\n
http://$host$path/activate.php?user=$md5_id&activ_code=$activ_code
"; 
} else {
$a_link = 
"Your account is *PENDING APPROVAL* and will be soon activated the administrator.
";
}

$message = 
"Hello \n
Thank you for registering with us. Here are your login details...\n

User ID: $user_name
Email: $usr_email \n 
Passwd: $data[pwd] \n

$a_link

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

    mail($usr_email, "Login Details", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion());

  header("Location: login.php");  //remember to delete thankyou.php, as login is always true without email activation as set in login.php
  exit();
     
     } 
 }  


?>
<html>
<head>
<title>MentalState.me</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/960_24_col.css" />
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<link rel="stylesheet" href="css/angrystyle.css" />
  <script>
  $(document).ready(function(){
    $("#logForm").validate();
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
<div class="grid_5 prefix_13">
	<form action="login.php" method="post" name="logForm" id="logForm" >
            Email or Username<br/>
            <input name="usr_email" type="text" class="required" id="txtbox" size="25">
            <br/>
            <input name="remember" type="checkbox" id="remember" value="1">
                Remember me
</div>
<div class="grid_5">

          Password<br/>
            <input name="pwd" type="password" class="required password" id="txtbox" size="25">
          
          
                
                  
            <br/>
                
                  <a href="forgot.php">Forgot Password</a> 
                  <br/>
                

</div>
<div class="grid_1">
<br/>
<input name="doLogin" type="submit" id="doLogin3" value="Login">
</form>
</div>
<div class="clear"></div>
</div>  <!-- end 960 container_24 -->
<!-- start of user registration -->
  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>

<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td width="160" valign="top"><p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top"><p>
    <?php 
     if (isset($_GET['done'])) { ?>
      <h2>Thank you</h2> Your registration is now complete and you can <a href="login.php">login here</a>";
     <?php exit();
      }
    ?></p>
      <!-- <h3 class="titlehdr">Free Registration / Signup</h3>
      <p>Please register a free account, before you can start tracking your happiness</p> -->
     <?php  
     if(!empty($err))  {
       echo "<div class=\"msg\">";
      foreach ($err as $e) {
        echo "* $e <br>";
        }
      echo "</div>";    
       }
     ?> 
     
      <br>
      <form action="register.php" method="post" name="regForm" id="regForm" >
        <table width="95%" border="0" cellpadding="3" cellspacing="3" class="forms">

          <tr> 
            <td colspan="2"><h4><strong>Login Details</strong></h4></td>
          </tr>
          <tr> 
            <td>Your Name<span class="required"><font color="#CC0000">*</font></span></td> 
            <td><input name="full_name" type="text" id="full_name" class="required"></td>
          </tr>
          <tr> 
            <td>Username<span class="required"><font color="#CC0000">*</font></span></td>
            <td><input name="user_name" type="text" id="user_name" class="required username" minlength="5" > 
              <input name="btnAvailable" type="button" id="btnAvailable" 
              onclick='$("#checkid").html("Please wait..."); $.get("checkuser.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
              value="Check Availability"> 
                <span style="color:red; font: bold 12px verdana; " id="checkid" ></span> 
            </td>
          </tr>
          <tr> 
            <td>Your Email<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="usr_email" type="text" id="usr_email3" class="required email"> 
              <span class="example">** Valid email please..</span></td>
          </tr>
          <tr> 
            <td>Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd" type="password" class="required password" minlength="5" id="pwd"> 
              <span class="example">** 5 chars minimum..</span></td>
          </tr>
          <tr> 
            <td>Retype Password<span class="required"><font color="#CC0000">*</font></span> 
            </td>
            <td><input name="pwd2"  id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td width="22%"><strong>Image Verification </strong></td>
            <td width="78%"> 
              <?php 
            require_once('recaptchalib.php');
            
                echo recaptcha_get_html($publickey);
            ?>
            </td>
          </tr>
        </table>
        <p align="center">
          <input name="doRegister" type="submit" id="doRegister" value="Register">
        </p>
      </form>
      <p align="right"><span style="font: normal 9px verdana">Powered by <a href="http://php-login-script.com">PHP 
                  Login Script v2.0</a></span></p>
       
      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>
