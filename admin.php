<?php
session_start();
if(isset($_SESSION['username'])){

if($_SESSION['username']!="administrator"){
  //echo '<script type="text/javascript">document.location.href="index.php";
   header("Location:index.php");
}

}else{
	  //echo '<script type="text/javascript">document.location.href="index.php";
	   header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="project, aberystwyth, computer science, third year, athlete, coach" />
<meta name="description" content="CS39440 Major Project" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0,user-scalable=no,width=device-width" />
<title>Admin panel - CS39440 Major Project</title>
 <link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="./css/mobile-style.css" type="text/css" media="all and (min-width: 320px) and (max-width: 480px)" />
  <link rel="stylesheet" href="../JQuery/alertify.js-0.3.10/themes/alertify.core.css" />
	<link rel="stylesheet" href="../JQuery/alertify.js-0.3.10/themes/alertify.default.css" />
 <link rel="shortcut icon" href="images/sportTypeIcon_Triathlon.jpg" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
 <script type="text/javascript" src="./js/jquery.timeago.js"></script>
 <script type="text/javascript" src="../JQuery/alertify.js-0.3.10/lib/alertify.js"></script>
 <script type="text/javascript" src="./js/admin.js"></script>
</head>
<body>
<header></header>

<div id="content">
<h1>Aber Triathlon Club</h1>
<noscript><h2>Javascript is turned off. It must be on if you want to use the page</h2></noscript>
<nav>
<?php
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
echo "<p>Welcome, <strong>".$_SESSION['username']."</strong><a href=\"logout.php\"><img src=\"./images/logout.png\" alt=\"[Log Out]\"/></a><p>";
//@include "config.php";
}
?>

</nav>


<div id="tabs">
<ul id="menu"><li><a href="#tabs-1">Add Member</a></li><li><a href="#tabs-2">Change Info</a></li><li><a href="#tabs-3">Remove</a></li><li><a href="#tabs-4">Make Reports</a></li><li><a href="#tabs-5" onClick="showProfile()">My Profile</a></li></ul>
<div id="tabs-1">
<form id="addmember" name"addform" method="post" action="enter.php">
	   
		<p>Firstname:<input type="text" size="20" value="" id="firstname" name="firstname"/>  </p>      
		<p>Lastname:<input type="text" size="20" value="" id="lastname" name="lastname"/>  </p>       
       <p> Year of birth:<input type="text" size="4"  maxlength="4" id="age" min="1940" max="2003" name="age" value="1990" placeholder="1990" /></p>  
        <p id="loaduser">Username:<input type="text" size="20" value="" id="user" name="user" onblur="return check_username();" /><div id="Info"></p>
        
			<p><img id="Loading" src="./images/loader.gif" alt="" /></p></div>
        
        <p>Password:<input type="password" size="20" id="pass" name="pass"/></p> 
         <p>Email:<input type="email" size="20" placeholder="text@some.here" id="email" name="email"/></p> 
    <p><input type="checkbox"  id="coach" name="coach" /><label for="coach" title="Click if you want the user to be a coach">Coach Member</label></p> 
        <p id="trainedp">Trained by:<select id="trained" name="trained">
        <?php
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
$getmembers = @mysql_query("SELECT * FROM users WHERE coach='1'");
while ($members = @mysql_fetch_array($getmembers)) {
echo "<option value='$members[username]'>$members[firstName] $members[lastName]</option>";
}
?>
        </select>
         </p> 
        
        <input type="reset" id="resetform" value="Reset"/> 
		<input type="button"  name="submit" onClick="validateForm();return false;" value="Add Member"/>
	</form>
    
    </div>
    
    <div id="tabs-2">
    
    
    </div>
    
    <div id="tabs-3">
    
    	<?php
		include("config.php");
$getmembers = mysql_query("SELECT * FROM users WHERE coach='1' ORDER BY firstName") or die("Mysql execute query get coaches error" .mysql_error());
$c=1;
$coa=mysql_num_rows($getmembers);
echo "<form  id='rcoach'>$coa coaches:<select id='cradios'>";
while ($members = MySQL_Fetch_Array($getmembers)) {
//echo "<input type='radio' name='rradio' id='cradio$c' value='$members[id]' /><label for='cradio$c'>$members[firstName] $members[lastName]</label>";
echo "<option value='$members[id]' title='$members[username]'>$members[firstName] $members[lastName]</option>";
$c++;

}
echo "</select><br /><input type='button' value='Remove Coach' onClick='removeMember(0);return false;' /></form><br />";

$getmembers = mysql_query("SELECT * FROM users WHERE username!='administrator' AND coach='0' ORDER BY firstName") or die("Mysql execute query get  athletes error" .mysql_error());
$c=1;
$atl=mysql_num_rows($getmembers);
echo "<form id='rathlete'>$atl athletes:<select id='aradios'>";
while ($members = MySQL_Fetch_Array($getmembers)) {
//echo "<input type='radio' name='rradio' id='aradio$c' value='$members[id]' /><label for='aradio$c'>$members[firstName] $members[lastName]</label>";
echo "<option value='$members[id]' title='$members[username]'>$members[firstName] $members[lastName]</option>";
$c++;

}
echo "</select><br /><input type='button' value='Remove Athlete' onClick='removeMember(1);return false;' /></form>";
?><br />
<form id="csessions">
<!--<input type="button" value="Remove Completed" onClick="removeSessions();return false;"/>-->
<input type="button" value="Remove All Sessions" title="Delete all sessions(drop all information from tables)" onClick="removeSessions();return false;"/></form>

    </div>
   
    <div id="tabs-4">
    	
        <a href="#pdf" onclick="makeReports();">Make report for All sessions</a><br />
        <a href="#" id="pdf" target="_blank" title="View produced pdf">View pdf</a>
    </div>
    
    <p id="feedback"></p>
    
    <div id="tabs-5">
    
    <div id="profileinfo">

<dl>
<dt>Name:
<dd id="adminname"></dd>
</dt>
<dt>Age:
<dd id="adminage"></dd>
</dt>
<dt>Email:
<dd id="adminemail"></dd>
</dt>

</dl>

</div>
<form>FirstName<input type="text" id="adminfirst" />
    Lastname<input type="text" id="adminlast" /><br />
Year of birth<input type="text" id="adminyear" size="4" min="1940" value="" max="2003" />
Email<input type="email" id="ademail"/>
<input type="button" value="Change Info" onClick="myDetails();return false;"/>
</form>
    </div>
    
    

    </div>

<footer>
<details>
<summary>
<?php 
// This is the link for this code: http://www.totallyphp.co.uk/code/date_file_last_modified.htm
// Change to the name of the file
$last_modified = filemtime("admin.php");
// Display the results
// eg. Last modified Monday, 27th October, 2003 @ 02:59pm l,dS F , Y
//echo "Last modified: " . date("l, jS F Y \a\\t H:i", $last_modified);
//$dt=date("Y-m-d")."T".date("H:i:s");
 
$que = "SELECT * FROM `users` WHERE `username`='administrator'";
 
 $Ras = mysql_query($que) or die("Mysql execute query error" .mysql_error());
 while ($Sa = mysql_fetch_array($Ras))
echo "<br />Administrated by ".$Sa['firstName'] ." ".$Sa['lastName'];
//echo "Last modified: " . date ("F d Y H:i:s.", getlastmod());
 echo '<br />';
 //<cite class="timeago" title="'.$dt.'">Drink beer</cite>';
//echo '<script type="text/javascript">document.oncontextmenu = function(){return false}
?>
</summary>
</details>
 </footer>
</div>


</body>

</html>