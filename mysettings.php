<?php 
/********************** MYSETTINGS.PHP**************************
This updates user settings and password
************************************************************/
error_reporting (E_ALL ^ E_NOTICE);
include 'dbc.php';
page_protect();

/*********************** MYACCOUNT MENU ****************************
This code shows my account menu only to logged in users. 
Copy this code till END and place it in a new html or php where
you want to show myaccount options. This is only visible to logged in users
*******************************************************************/
if (isset($_SESSION['user_id'])) { 

$err = array();
$msg = array();

if($_POST['doUpdate'] == 'Update')  
{


$rs_pwd = mysql_query("select pwd from users where id='$_SESSION[user_id]'");
list($old) = mysql_fetch_row($rs_pwd);
$old_salt = substr($old,0,9);

//check for old password in md5 format
	if($old === PwdHash($_POST['pwd_old'],$old_salt))
	{
	$newsha1 = PwdHash($_POST['pwd_new']);
	mysql_query("update users set pwd='$newsha1' where id='$_SESSION[user_id]'");
	$msg[] = "Your new password is updated";
	//header("Location: mysettings.php?msg=Your new password is updated");
	} else
	{
	 $err[] = "Your old password is invalid";
	 //header("Location: mysettings.php?msg=Your old password is invalid");
	}

}

if($_POST['doSave'] == 'Save')  
{
// Filter POST data for harmful code (sanitize)
foreach($_POST as $key => $value) {
	$data[$key] = filter($value);
}


mysql_query("UPDATE users SET
			`full_name` = '$data[name]',
			 WHERE id='$_SESSION[user_id]'
			") or die(mysql_error());

//header("Location: mysettings.php?msg=Profile Sucessfully saved");
$msg[] = "Profile Sucessfully saved";
 }
 
$rs_settings = mysql_query("select * from users where id='$_SESSION[user_id]'"); 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="author" content="Jason Hejna">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="images/gauge.ico">
  <link rel="icon" href="images/gauge.ico">
<title>Mental State - Account info</title>
<!-- <style type="text/css">
 #map { width: 150px; height: 150px; border: 0px; padding: 0px; }
 </style> -->
 <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/angrystyle.css" />
<link rel="stylesheet" href="css/960_24_col.css" />
<script type='text/javascript' src='js/jquery.autocomplete.js'></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#myform").validate();
	 $("#pform").validate();
  });
  </script>
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
                primary: "ui-icon-home"
            },
            text: false
        }).next().button({
            icons: {
                primary: "ui-icon-locked"
            },
            text: false
        })
  });
  </script>
<link href="styles.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="container_24">
<div class="clear"></div>
<div class="grid_18" id="bartitle">
  
<div class="grid_6 alpha">
      &nbsp;
      <a href="friends.php"><span class="title">HappyData</span></a>
</div>
<div class="grid_12 omega">
    
      <form action="friends.php" method="post">
        <div class="searchicon">
      

      <input type="text" name="course" id="course" style="float:left;vertical-align:inherit;margin-top:14px;width:255px;margin-left:8px;" />
      <button id="uniqueny1" type="submit" class="searchbutton" >Find Friends</button>
    
      </form>
    </div>
      <div class="usericons">
      <button id="uniqueny2" ONCLICK="window.location.href='friends.php'" style="margin-left:26px;">Friends</button>
      <button id="uniqueny3" ONCLICK="window.location.href='index.php'" >Settings</button>
      <button id="uniqueny4" ONCLICK="window.location.href='logout.php'" style="margin-right:3px;">Logout</button>
      
    </div>
</div>
</div> <!-- end .grid_18 -->

<br><br><br>
<table width="100%" border="0" cellspacing="0" cellpadding="5" class="main">

  <tr> 
    <td width="160" valign="top">
  <?php 
  include 'myinc_pic.php';
if (checkAdmin()) {
/*******************************END**************************/
?>
      <p> <a href="admin.php">Admin CP </a></p>
	  <?php } ?>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td width="732" valign="top">
<h3 class="titlehdr">My Account - Settings</h3>
      <p> 
        <?php	
	if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "* Error - $e <br>";
	    }
	  echo "</div>";	
	   }
	   if(!empty($msg))  {
	    echo "<div class=\"msg\">" . $msg[0] . "</div>";

	   }
	  ?>
      </p>
      <p>Here you can make changes to your profile. Please note that you will 
        not be able to change your email which has been already registered.</p>
	  <?php while ($row_settings = mysql_fetch_array($rs_settings)) {?>
      <form action="mysettings.php" method="post" name="myform" id="myform">
        <table width="90%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td colspan="2"> <span class="example">Your name</span> <input name="name" type="text" id="name"  class="required" value="<?php echo $row_settings['full_name']; ?>" size="47"> 
              </td>
          </tr>

          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>User Name/Login Name</td>
            <td><input name="user_name" type="text" id="web2" value="<?php echo $row_settings['user_name']; ?>" disabled></td>
          </tr>
          <tr> 
            <td>Email</td>
            <td><input name="user_email" type="text" id="web3"  value="<?php echo $row_settings['user_email']; ?>" disabled></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doSave" type="submit" id="doSave" value="Save">
        </p>
      </form>
	  <?php } ?>
      <h3 class="titlehdr">Change Password</h3>
      <p>If you want to change your password, please input your old and new password 
        to make changes.</p>
      <form name="pform" id="pform" method="post" action="">
        <table width="80%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">
          <tr> 
            <td width="31%">Old Password</td>
            <td width="69%"><input name="pwd_old" type="password" class="required password"  id="pwd_old"></td>
          </tr>
          <tr> 
            <td>New Password</td>
            <td><input name="pwd_new" type="password" id="pwd_new" class="required password"  ></td>
          </tr>
        </table>
        <p align="center"> 
          <input name="doUpdate" type="submit" id="doUpdate" value="Update">
        </p>
        <p>&nbsp; </p>
      </form>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
	   
      <p align="right">&nbsp; </p></td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

</body>
</html>
<?php } 
/*******************************END**************************/
?>