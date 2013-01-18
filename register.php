<?php 
/*************** PHP LOGIN SCRIPT V 2.0*********************
***************** Auto Approve Version**********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects.

Limitations:
- This script cannot be sold.
- This script may not be provided for download except on its original site.

For further usage, please contact me.

***********************************************************/

error_reporting (E_ALL ^ E_NOTICE);
include 'dbc.php';

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
        // die ("<h3>Image Verification failed!. Go back and try again.</h3>" .
        //      "(reCAPTCHA said: " . $resp->error . ")");
        $err[] = "ERROR - Invalid reCAPTCHA.";  
      }
/************************ SERVER SIDE VALIDATION **************************************/
/********** This validation is useful if javascript is disabled in the browswer ***/

if(empty($data['first_name']) || strlen($data['first_name']) < 3)
{
$err[] = "ERROR - Invalid name. Please enter atleast 2 or more characters for your first name.";
//header("Location: register.php?msg=$err");
//exit();
}
if(empty($data['last_name']) || strlen($data['last_name']) < 3)
{
$err[] = "ERROR - Invalid name. Please enter atleast 2 or more characters for your last name.";
//header("Location: register.php?msg=$err");
//exit();
}
// Validate User Name
if (!isUserID($data['user_name'])) {
$err[] = "ERROR - Invalid email address.";
//header("Location: register.php?msg=$err");
//exit();
}

// Validate Email
if(!isEmail($data['usr_email'])) {
$err[] = "ERROR - Invalid email address.";
//header("Location: register.php?msg=$err");
//exit();
}
// Check that User Name (email1) and Email (email 2) match, or are ==
if(!isMatchEmail($data['usr_email'],$data['user_name'])) {
$err[] = "ERROR - email address does not match.";
//header("Location: register.php?msg=$err");
//exit();
}
// Check User Passwords
if (!checkPwd($data['pwd'],$data['pwd2'])) {
$err[] = "ERROR - Invalid Password or mismatch. Enter 5 chars or more.";
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
$full_name = "{$data[first_name]}{ }{$data[last_name]}";
$sql_insert = "INSERT into `users`
            (`full_name`,`user_email`,`pwd`,`date`,`users_ip`,`activation_code`,`user_name`,`approved`
            )
            VALUES
            ('$full_name','$usr_email','$sha1pass',now(),'$user_ip','$activ_code','$user_name','$approved'
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

  header("Location: thankyou.php");  //remember to delete thankyou.php, as login is always true without email activation as set in login.php
  exit();
     
     } 
 }                   

?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Jason Hejna">
  <link rel="shortcut icon" href="images/gauge.ico">
  <link rel="icon" href="images/gauge.ico">
<title>HappyData.me - Register / Sign-Up</title>
<link href='http://fonts.googleapis.com/css?family=Grand+Hotel|Text+Me+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/registstyle.css" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<style type="text/css">
</style>
  <script type="text/javascript">

  
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");


  });

  var RecaptchaOptions = {
    theme : 'white'
 };

    $("#regForm").validate();

    $(function() {
        $( "input[type=submit], a, button" )
            .button()
            .click(function( event ) {
                event.preventDefault();
            });
    });
  </script>

</head>

<body>

  <p>
    <?php 
     if (isset($_GET['done'])) { ?>
      <h2>Thank you</h2> Your registration is now complete and you can <a href="login.php">login here</a>";
     <?php exit();
      }
    ?></p>

      <form action="register.php" method="post" name="regForm" id="regForm" >
        
          
            <td colspan="2">
              <h3><strong>Register / Sign Up</strong></h3>
              <h4>It's free forever.</h4><br>
          <div id="registext">
          
          
            <td colspan="2">
            <?php  
              if(!empty($err))  {
               echo "<div class=\"msg\">";
              foreach ($err as $e) {
                echo "* $e <br><br>";
                }
              echo "</div>";    
               }
            ?>
          
          
          
            <span id="regspaceing">First Name<span class="required"><font color="#CC0000">*</font></span></span>
            <input name="first_name" type="text" id="first_name" class="required"><br>
          
            <span id="regspaceing">Last Name<span class="required"><font color="#CC0000">*</font></span>
          </span><input name="last_name" type="text" id="last_name" class="required"><br>

            <span id="regspaceing">Your Email<span class="required"><font color="#CC0000">*</font></span></span>
            <input name="btnAvailable" type="button" id="btnAvailable" 
              onclick='javascript:$("#checkid").html("Please wait..."); $.get("checkuser.php",{ cmd: "check", user: $("#user_name").val() } ,function(data){  $("#checkid").html(data); });'
              value="Check"> 
            <input name="user_name" type="text" id="user_name" class="required username" minlength="5" ><br>
              <span style="color:red;" id="checkid" ></span>

                
            
          
          
            <span id="regspaceing">Confirm Email<span class="required"><font color="#CC0000">*</font></span></span>
            
            <input name="usr_email" type="text" id="usr_email3" class="required email"><br>
          
          
            <span id="regspaceing">Password<span class="required"><font color="#CC0000">*</font></span></span>
            
            <input name="pwd" type="password" class="required password" minlength="5" id="pwd"><br>
          
          
            <span id="regspaceing">Retype Password<span class="required"><font color="#CC0000">*</font></span></span>
            
            <input name="pwd2"  id="pwd2" class="required password" type="password" minlength="5" equalto="#pwd"><br>
          </div>
            <div><br></div>

              <?php 
            require_once('recaptchalib.php');
            
                echo recaptcha_get_html($publickey);
            ?>

        <br>
          <input name="doRegister" type="submit" id="doRegister" value="Register">
        <br><br>
      </form>
      

</body>
</html>
