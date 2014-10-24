<?php
session_start();
error_reporting(0);
$host="localhost";
$dbusername="root";
$dbpassword="gamen7";
$db="club";
$conn=mysql_connect("$host","$dbusername", "$dbpassword") or die(mysql_error());
$mydb=mysql_select_db($db) or die(mysql_error());
 
if (!$conn)
{
die("Could not connect: " . mysql_error());
}

//$_SESSION['username']='ssa';
//$_SESSION['password']='pound';
if(isset($_SESSION['username'])){

if($_SESSION['username']=="administrator"){
 //echo '<script type="text/javascript">document.location.href="admin.php";
 header("Location:admin.php");
}

}

//change your picture
if(isset($_FILES['file'])){
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
	
	$pic=$_SESSION['myid'].".jpg";
	$chuid=$_SESSION['myid'];
	$file = $_FILES['file']['name'];
$tmp_file = $_FILES['file']['tmp_name'];
$size = $_FILES['file']['size'];
$poster="./images/".$chuid.".jpg";//.basename($file);
//echo $poster;
//basename($file)="7.jpg";
/*if(file_exists($poster)) {echo "<p>Файла съществува !<br /></p>";
echo basename($file);
exit;}*/

if($size==0) {echo "<p>File is corrupted !<br /><br /></p><a href='index.php'>Go to home page</a>";exit;}
if($size>999999) {echo "<p>File is too big !<br /><br /></p><a href='index.php'>Go to home page</a>";exit;}
$extensions = array("gif","jpg","jpeg","png");
$extension_file = end(explode(".",$file));
$extension_file = strtolower($extension_file);
if(!in_array($extension_file,$extensions)) {echo "<p>This file is not allowed ! You can upload only gif, jpg, jpeg, png !<br /></p><a href='index.php'>Go to home page</a>";exit;}
$upload = move_uploaded_file ($tmp_file,$poster);
if($upload){
	$pquery = mysql_query("UPDATE `users` SET `picture`='$pic' WHERE `id`='$chuid'") or die(mysql_error()); 
	if(!$pquery){
die("There's little problem with updating your picture: ".mysql_error());
}

}
	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="project, aberystwyth, computer science, third year, athlete, coach" />
<meta name="description" content="CS39440 Major Project" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0,user-scalable=no,width=device-width" />
<title>Athlete's training website - CS39440 Major Project</title>
 
 <style type="text/css">
@import "css/jquery.countdown.css";
 
</style>
 <link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="./css/mobile-style.css" type="text/css" media="all and (min-width: 320px) and (max-width: 480px)" />
 <link rel="stylesheet" href="../JQuery/alertify.js-0.3.10/themes/alertify.core.css" />
	<link rel="stylesheet" href="../JQuery/alertify.js-0.3.10/themes/alertify.default.css" />
 <link rel="shortcut icon" href="images/sportTypeIcon_Triathlon.jpg" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-1.9.1.min.js"></script>
<script src="./js/jquery-ui.js"></script>
<script src="./js/jquery.titlealert.js" type="text/javascript"></script>
<script type="text/javascript" src="./js/jquery.countdown.js"></script>
  <script type="text/javascript" src="./js/jquery.timeago.js"></script>
<script type="text/javascript" src="./js/jsapi"></script>

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      
    </script>
<script type="text/javascript" src="../JQuery/alertify.js-0.3.10/lib/alertify.js"></script>
 <script type="text/javascript" src="./js/jsscripts.js"></script>
 
</head>
<body>
<header></header>

<div id="content">
<h1>Aber Triathlon Club</h1>
<noscript><h1>Javascript is turned off.<br />It must be on if you want to use the page</h1></noscript>
<nav>


<?php
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
echo '<p id="welcome">Welcome, <strong id="whois"></strong>
<a href="logout.php"><img src="./images/logout.png" alt="[Log Out]"/></a></p> ';
 echo '<script type="text/javascript">GetRemoteData("'.$_SESSION['username'].'");</script>';
   echo '<script type="text/javascript">showLogin();</script>';
}else{
print "<p id='welcome'>Welcome, Guest</p>";

}
?>

</nav>

<div id="tabs">
<ul id="menu">
</ul>

<div id="tabs-1">
<table id="mySessions"></table>
<div id="coachdiv" style="display:none;">
<!--<a onclick="makeChart(getWhich())">REdraw</a>/-->
<a id="seenext" onClick="seeNext()">Next</a>

<a id="seeprev" onClick="seePrev()">Prev</a>
<a id="editthis" onClick="addTab(getWhich())">Edit</a>
</div>

<div id="readytostart" style="display:none;">

<div id="buttons">
<a id="startthis">Start</a>
<a id="pausethis">Pause</a>
<br />

</div>

<h3 id="momentdesc"></h3>
<h4 id="intervaldesc"></h4>
<h6 id="sessiondist">x kilemeters</h6>
<div id='countup'>countup</div>
<div id='monitor'>monitor down</div>
<div id='shortly'></div>
<div id='short'></div>
<!--<input type="button" onClick="backChart()" value="Back"><input type="button" onClick="nextChart()" value="Next"/>-->
<div id="intervaltitle"></div>
<progress value="0" id="progressbar" max="100"></progress>
</div>

<div id='good'></div>
<div id='takenbywho'></div>
<audio controls="controls" id="sound">
Your browser does not support the audio element.
Please update it!
</audio>
</div>


<div id="tabs-2">
<table id="myathletes">

</table>
</div>

<div id="tabs-3">
<form id="addsession" method="post" action="enter.php">
	    	<input id="intervals" name="intervals" type="hidden" value="1"/>
          
		<p>Type:<select name="type">
        <option selected="selected">cycling</option>
        <option>swimming</option>
        <option>running</option>
        </select></p>
        <p>Session Description:<br /><textarea name="description" id="description" placeholder="overall session description"></textarea></p>
        <p>Distance:<input type="text" name="distance" id="distance" size="5" placeholder="0.050 metres" value=""/> </p>
         <section id="interval1">Interval 1
		<p>Description:<br /><textarea name="description1" id="description1" size="20" placeholder="some instructions for this interval"></textarea></p>
         <!--<p>Distance:<input type="text" name="distance1" id="distance1" size="5" placeholder="0.050 metres" value=""/> </p>-->
		<p>Duration:<input type="text" id="duration1" name="duration1"  title="Duration in format 5.26 (5 minutes and 26 seconds)" placeholder="5.26" size="4" value=""/> </p>
         <p>Level:<select name="level1" id="level1" size="1">
         <option selected="selected" value="1">Level 1</option><option value="2">Level 2</option><option value="3">Level 3</option><option value="4">Recovery</option><option value="5">Aerobic</option><option value="6">Advanced Aerobic</option><option value="7">Anaerobic Threshold</option>
         <option value="8">VO2 Max</option><option value="9">Speed</option><option value="10">Sprint</option>
        </select> </p>
         
         </section>
        
         <input type="button" id="addfields" onClick="addIntervals(this.id)" value="More Intervals" />
         <input type="button" id="del" onClick="delIntervals('addfields')" value="Remove Interval" />
         <section id="cathletes"><?php
$host="localhost";
$dbusername="root";
$dbpassword="gamen7";
$db="club";
$conn=mysql_connect("$host","$dbusername", "$dbpassword") or die(mysql_error());
$mydb=mysql_select_db($db) or die(mysql_error());
 
if (!$conn)
{
die("Could not connect: " . mysql_error());
}
$mynick=$_SESSION['username'];
$getmembers = mysql_query("SELECT * FROM users WHERE trained_by='$mynick' ORDER BY firstName");
$c=1;
if(mysql_num_rows(@$getmembers) > 0){
	echo "Athletes:<br />";
while ($members = MySQL_Fetch_Array($getmembers)) {
echo "<input type='checkbox' name='check$c' id='check$c' value='$members[id]' /><label for='check$c'>$members[firstName] $members[lastName]</label><br />";
$c++;
}
}else{
	echo "You do not have athletes<br />";
}
//echo "<br />";
?></section>
         <input type="reset" value="Reset"/> 
        <input type="button" value="Add Session" onClick="addSession()"/>
         
	</form>
    <p id="success"></p>
    </div>
    
    <div id="tabs-4">
    
    <form id="editsession" method="post"  action="enter.php">
	    	<input id="eintervals" name="eintervals" type="hidden" value="1"/>
            <input type="hidden" id="sessionid" name="sessionid" value="0"/>
		<p>Type:<select name="etype" id="etype">
        <option>cycling</option>
        <option>swimming</option>
        <option>running</option>
        </select></p>
        <p><label for="edescription">Session Description</label><br /><textarea name="edescription" id="edescription" placeholder="overall session description"></textarea></p>
        <p>Distance:<input type="text" name="edistance" id="edistance" size="6" value="1"/> </p>
         <section id="einterval1">Interval 1
		<p>Description:<br /><textarea name="edescription1" id="edescription1" size="20" placeholder="some instructions"></textarea></p>
         <!--<p>Distance:<input type="text" name="edistance1" id="edistance1" size="5" placeholder="0.050 metres" value=""/> </p>-->
		<p>Duration:<input type="text" id="eduration1" name="eduration1" placeholder="5.26" title="Duration in format 5.26 (5 minutes and 26 seconds)" size="4" value=""/> </p>
         <p>Level:<select name="elevel1" id="elevel1" size="1">
         <option value="1">Level 1</option><option value="2">Level 2</option><option value="3">Level 3</option><option value="4">Recovery</option><option value="5">Aerobic</option><option value="6">Advanced Aerobic</option><option value="7">Anaerobic Threshold</option>
         <option value="8">VO2 Max</option><option value="9">Speed</option><option value="10">Sprint</option>
        </select> </p>
         
         </section>
        <div><input type="button" id="editfields"  value="More Intervals"/>
         <input type="button" id="rem" value="Remove Interval"  onclick="delIntervals('editfields')"/></div>
        <div id="eathletes"></div>
         <input type="reset" value="Reset Form"/> 
        <input type="button" value="Edit Session" name="editsession" onClick="editSession()"/>
        
	</form>
    <p id="edittest"></p>
    </div>

	<div id="tabs-5">
    	
<div id="profileinfo">

<dl>
<dt>Name:
<dd id="cname"></dd>

</dt>
<dt>Age:<dd id="cage"></dd></dt>
<dt>Email:<dd id="email"></dd></dt>
<dt id="colabel">My Coach:</dt>
<dd id="mycoach"></dd>
<dt id="pic">Pic:</dt>
<dd><img src="" id="mypic" alt="My Picture" width="100" height="100"/></dd>

</dl>


</div>

<div>Change <button onclick="changeUser()">Username</button>, <button onClick="changePass()">Password</button> or <button onClick="changeEmail()">Email</button><br />Add/Change picture<br />
<form action="" method="post" id="formpic" enctype="multipart/form-data">
<input name="file" type="file" id="browsefile" width="50" size="1"/><br />
<input  name="submit" type="submit" value="Change picture" />
</form>

</div>

    </div>
    
</div><!--end of the tabs div-->



<div id="logform">

<form id="log" method="post" action="enter.php">
	     
			<label for="login_name">Username:</label><br />
			<input type="text" id="login_name" name="login_name" size="30" maxlength="20"/>
            <br />
		 	<label for="login_pass">Password:</label><br />
			<input type="password" id="login_pass" name="login_pass" size="30" maxlength="30" />
		 <br />
		<input type="submit" value="Login" /> 
	</form>
    </div>
    
<!--<img src="./images/swim_bike_run.jpg"/>
<img src="./images/triathlon.jpg"  width="150" height="150"/>-->

<footer>

<summary>
<?php 
// This is the link for this code: http://www.totallyphp.co.uk/code/date_file_last_modified.htm
// Change to the name of the file
$last_modified = filemtime("index.php");
// Display the results
// eg. Last modified Monday, 27th October, 2003 @ 02:59pm l,dS F , Y
//echo "Last modified: " . date("l, jS F Y H:i", $last_modified);
//$dt=date("Y-m-d")."T".date("H:i:s");

$que = "SELECT * FROM `users` WHERE `username`='administrator'";
 
 $Ras = mysql_query($que) or die("Mysql execute query error" .mysql_error());
 while ($Sa = mysql_fetch_array($Ras))
echo "<br />Administrated by ".$Sa['firstName'] ." ".$Sa['lastName'];
 //echo "<br />Copyright by INTRtri";
 echo '<br />';
//echo '<script type="text/javascript">document.oncontextmenu = function(){return false}
?>

</summary>

 </footer>
</div>


</body>

</html>