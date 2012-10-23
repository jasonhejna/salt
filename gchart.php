<?php
 include 'dbc.php';
 page_protect();
 if (isset($_SESSION['user_id'])) {
 	$goturid = $_SESSION['user_id'];
 	date_default_timezone_set('America/New_York');
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">

google.load('visualization', '1', {packages: ['annotatedtimeline']});
    function drawVisualization() {


    var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'happiness');
      data.addColumn('string', 'title1');
      data.addColumn('string', 'text1');

      data.addRows([
        
<?php
$i=0;
        $result = mysql_query("SELECT `happiness`, `unix_time`,`text` FROM happy WHERE `user_id` = $goturid");

while($row = mysql_fetch_array($result)){
        $time = $row['unix_time'];// -(31*24*60*60);
        $ftime = strftime("%Y,%m-1,%d,%H,%M,%S",$time);
        $happz = $row['happiness'];

        switch ($happz) {
            case 0:
                   $smile = ":`(";
                   break;
            case 1:
                   $smile = ":(";
                   break;
            case 2:
                   $smile = ":|";
                   break;
            case 3:
                   $smile = ":/";
                   break;
            case 4:
                   $smile = ":)";
                   break;
            case 5:
                   $smile = ":D";
                   break;
            default:
                  $smile = "undefined";
        }
        $smilestr = (string)$smile;
        $text = $row['text'];
        $textstr = "";
        $textstr = (string)$text;
        if ($textstr != "") {
        echo "[new Date($ftime), $happz, '$smile', '$textstr'],";
        }
        else {
          echo "[new Date($ftime), $happz, undefined,undefined],";
        }

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
	<div id="visualization" style="width: 720px; height: 400px;"></div>
</body>
</html>
<?php } ?>
