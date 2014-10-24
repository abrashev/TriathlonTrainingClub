<?php
//Collect your info from login form
//Connecting to database
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
//$_POST['login_name']="magi";
//$_POST['login_pass']="smile";
if(isset($_POST['login_name']) && isset($_POST['login_pass'])){
//Connecting to database
//require('./connect.php');
 //include('connect.php');
 //include_once './config.php';
$username = $_POST['login_name'];
$password = $_POST['login_pass'];
//Find if entered data is correct
//echo $username;
$result = mysql_query("SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'");
$row = mysql_fetch_array($result);
$id = $row['id'];
/*$count = mysql_query ("SELECT count(id) FROM `users` WHERE `id`='$id'");
$count1=mysql_num_rows($count);
if($count1==1){
//echo $count1;
$_SESSION['username']=$username;
 $_SESSION['password']=$password;
 header('Location: index.php');
}else{
	header('Location: index.php');
}*/

$select_user = mysql_query("SELECT * FROM `users` WHERE `id`='$id'");
$row2 = mysql_fetch_array($select_user);
$user = $row2['username'];

$pass_check = mysql_query("SELECT * FROM `users` WHERE `username`='$username' AND `id`='$id'");
$row3 = mysql_fetch_array($pass_check);
$firstName = $row3['firstName'];
$select_pass = mysql_query("SELECT * FROM `users` WHERE `password`='$password' AND `id`='$id' AND `firstName`='$firstName'");
$row4 = mysql_fetch_array($select_pass);
$real_password = $row4['password'];

if($username != $user or $password != $real_password){
print "<p>Wrong username or password<br /><a href='index.php'>Go back</a></p>";

}else{
$_SESSION['username']=$username;
 $_SESSION['password']=$password;
 $_SESSION['myid']=$id;
 ///echo 'Successfully logged in...';
 if($username=='administrator'){
	header('Location: admin.php');
 //echo '<script type="text/javascript">document.location.href="admin.php"
 }else{
header('Location: index.php');
  //echo '<script type="text/javascript">document.location.href="index.php"
 }
 
}
//Thank you for logging in... You will be redirected to index page

}
//Now if everything is correct let's finish his/her/its login
// session_register("username", $username);
 //session_register("password", $password);

//i think get all coaches in the club I dont use it
if(isset($_POST['allcoaches'])){
 //include("connect.php");
$sqla = "SELECT * FROM `users` WHERE `coach`=1";
$resw = mysql_query ("SELECT count(id) FROM `users` WHERE `coach`=1");
$i=0;
$nums=mysql_num_rows($resw);
 $Ra = mysql_query($sqla,$conn) or die("Mysql execute query error" .mysql_error());
//echo $nums[0];
 $Optionsa = '[';

 while ($Sa = mysql_fetch_array($Ra))
  {
	$i++;
	if($i==$nums){
		$Optionsa='{ "firstName":"'.$Sa["firstName"].'" , "lastName":"'.$Sa["lastName"].'", "username":"'.$Sa["username"].'"},';
	}
	else{
		$Optionsa='{ "firstName":"'.$Sa["firstName"].'" , "lastName":"'.$Sa["lastName"].'", "username":"'.$Sa["username"].'"}';
	}

	
}
 if($nums==$i){
//echo $i;
 $Optionsa=rtrim($Optionsa, ",");
  $Optionsa=$Optionsa. "]";
 echo $Optionsa;
}else{
$Optionsa=$Optionsa. "]";
 echo $Optionsa;
}
//echo $Optionsa;//. htmlspecialchars($Options);

// echo "coaches by this club";
 
}
 
 //getting profile information
if(isset($_POST['userinfo']))
{
//require_once("connect.php");
$usr=$_POST['userinfo'];
$sqla = "SELECT * FROM `users` WHERE `username`='$usr'";

$Ra = mysql_query($sqla,$conn) or die("Mysql execute query error" .mysql_error());

$Optionsa = "";

while ($Sa = mysql_fetch_assoc($Ra))
{
$trained=$Sa["trained_by"];
$mytrain=getCoachInfo($trained);
$Optionsa='{ "id":'.$Sa["id"].' ,"firstName":"'.$Sa["firstName"].'" , "lastName":"'.$Sa["lastName"].'", "age":"'.$Sa["age"].'", "username":"'.$Sa["username"].'", "coach":'.$Sa["coach"].', "trained_by":"'.$Sa["trained_by"].'", "email":"'.$Sa["email"].'", "mycoach":"'.$mytrain.'", "picture":"'.$Sa["picture"].'"}';

	
}
echo $Optionsa;//. htmlspecialchars($Options);

}

//get all sessions for a coach
if(isset($_POST['sessions'])){
//include("connect.php");
$usr=$_POST['sessions'];		
$sqla = "SELECT * FROM `sessions` WHERE `by`='$usr' ORDER BY `time_added` desc";
 $resw = mysql_query ("SELECT count(id) FROM `sessions` WHERE `by`='$usr'");
$i=0;
$nums=mysql_num_rows($resw);
 $Ra = mysql_query($sqla) or die("Mysql execute query error" .mysql_error());
 $Optionsa = '[';
  
  while ($Sa = mysql_fetch_array($Ra))
  {
	  //echo '{ "level":"'.$Sa["level"].'"}';
	  $thissession=$Sa["id"];	  
	$i++;
//another variable

$z=0;
$sqlaa = "SELECT * FROM `intervals` WHERE `session_id`='$thissession'";
$Ras = mysql_query($sqlaa);
$resa = mysql_query ("SELECT count(session_id) FROM `intervals` WHERE `session_id`='$thissession'");
$numintervals=mysql_num_rows($resa);
 $Optionsat='['; //check
 while ($Sas = mysql_fetch_array($Ras))
  {
	$z++;
 
if($z==$numintervals){
//"distance":'.$Sas["distance"].' ,
 $Optionsat=$Optionsat.'{"duration":'.$Sas["duration"].' , "description":"'.$Sas["description"].'", "level":'.$Sas["level"].'}';
}else{
$Optionsat=$Optionsat.',{"duration":'.$Sas["duration"].' , "description":"'.$Sas["description"].'", "level":'.$Sas["level"].' }';
}
    
	
 }//end while intervals
 if($numintervals==$z){

 $Optionsat=rtrim($Optionsat, ",");
  $Optionsat=$Optionsat. "]}";
 //echo $Optionsa;
}else{
$Optionsat=$Optionsat. "]}";
 //echo $Optionsa;
}

if($i==$nums){
//echo $i;
 $Optionsa=$Optionsa.'{ "id":'.$Sa["id"].' , "description":"'.$Sa["description"].'", "type":"'.$Sa["type"].'", "distance":"'.$Sa["distance"].'", "duration":"'.$Sa["duration"].'", "by":"'.$Sa["by"].'", "completed":'.$Sa["allcompleted"].', "time_added":"'.$Sa["time_added"].'", "intervals":' .$Optionsat.'';
}else{
$Optionsa=$Optionsa.',{ "id":'.$Sa["id"].' , "description":"'.$Sa["description"].'", "type":"'.$Sa["type"].'", "distance":"'.$Sa["distance"].'", "duration":"'.$Sa["duration"].'", "by":"'.$Sa["by"].'", "completed":'.$Sa["allcompleted"].', "time_added":"'.$Sa["time_added"].'", "intervals":'.$Optionsat.'';
}
	
 }//end while
 if($nums==$i){
//echo $i;
 $Optionsa=rtrim($Optionsa, ",");
  $Optionsa=$Optionsa. "]";
 echo $Optionsa;
}else{
$Optionsa=$Optionsa. "]";
 echo $Optionsa;
}


}//end for coach sessions

//athlete sessions
if(isset($_POST['mysessions']))
{
//include("connect.php");
$myid=$_POST['mysessions'];		
 $sqla = "SELECT * FROM `takesessions`, `sessions` WHERE `user_id`='$myid' AND `id`=takesessions.session_id ORDER BY `completed` asc";
 $resw = mysql_query ("SELECT count(session_id) FROM `takesessions` WHERE `user_id`=$myid");
$i=0;
$nums=mysql_num_rows($resw);
 $Ra = mysql_query($sqla) or die("Mysql execute query error" .mysql_error());
//echo $nums=;
//echo "<p>".$nums."</p>";
$completed=0;
 $Optionsa = '[';
 while ($Sa = mysql_fetch_array($Ra))
  {//$nums=$Sa['COUNT(session_id)'];
  	$completed=$Sa['completed'];
	//echo $completed;
	 $thissession=$Sa["id"];	  
	$i++;
//another variable
$z=0;
$sqlaa = "SELECT * FROM `intervals` WHERE `session_id`='$thissession'";
$Ras = mysql_query($sqlaa);
$resa = mysql_query ("SELECT count(session_id) FROM `intervals` WHERE `session_id`='$thissession'");
$numintervals=mysql_num_rows($resa);
 $Optionsat='['; //check
 while ($Sas = mysql_fetch_array($Ras))
  {
	 
	$z++;
if($z==$numintervals){
//echo $i;
 $Optionsat=$Optionsat.'{ "duration":'.$Sas["duration"].' , "description":"'.$Sas["description"].'", "level":'.$Sas["level"].'}';
}else{
$Optionsat=$Optionsat.',{ "duration":'.$Sas["duration"].' , "description":"'.$Sas["description"].'", "level":'.$Sas["level"].' }';
}
    
	
 }//end while intervals
 if($numintervals==$z){
 $Optionsat=rtrim($Optionsat, ",");
  $Optionsat=$Optionsat. "]}";
 //echo $Optionsa;
}else{
$Optionsat=$Optionsat. "]}";
 //echo $Optionsa;
}

if($i==$nums){

 $Optionsa=$Optionsa.'{ "id":'.$Sa["id"].' , "description":"'.$Sa["description"].'", "type":"'.$Sa["type"].'", "distance":"'.$Sa["distance"].'", "duration":"'.$Sa["duration"].'", "by":"'.$Sa["by"].'", "completed":'.$completed.', "time_added":"'.$Sa["time_added"].'", "intervals":' .$Optionsat.'';
}else{
$Optionsa=$Optionsa.',{ "id":'.$Sa["id"].' , "description":"'.$Sa["description"].'", "type":"'.$Sa["type"].'", "distance":"'.$Sa["distance"].'", "duration":"'.$Sa["duration"].'", "by":"'.$Sa["by"].'", "completed":'.$completed.', "time_added":"'.$Sa["time_added"].'", "intervals":'.$Optionsat.'';
}
	
 }
 if($nums==$i){
 $Optionsa=rtrim($Optionsa, ",");
  $Optionsa=$Optionsa. "]";
 echo $Optionsa;
}else{
$Optionsa=$Optionsa. "]";
 echo $Optionsa;
}

}
//get all athletes for a specific coach
if(isset($_POST['athletes'])){
//include("connect.php");
$coach=$_POST['athletes'];		
$sqla = "SELECT * FROM `users` WHERE `trained_by`='$coach' ORDER BY firstName";
 $resw = mysql_query ("SELECT count(id) FROM `users` WHERE `trained_by`='$coach'");
$i=0;
$nums=mysql_num_rows($resw);
 $Ra = mysql_query($sqla) or die("Mysql execute query error" .mysql_error());
//echo $nums[0];
 $Optionsa = '[';

 while ($Sa = mysql_fetch_array($Ra))
  {
	$i++;	
if($nums==$i){
//echo $i;
 $Optionsa=$Optionsa.'{ "id":"'.$Sa["id"].'", "firstName":"'.$Sa["firstName"].'", "lastName":"'.$Sa["lastName"].'", "age":"'.$Sa["age"].'", "picture":"'.$Sa["picture"].'" }';
}else{
$Optionsa=$Optionsa.',{ "id":"'.$Sa["id"].'", "firstName":"'.$Sa["firstName"].'", "lastName":"'.$Sa["lastName"].'", "age":"'.$Sa["age"].'", "picture":"'.$Sa["picture"].'" }';
}
    
 }
 
 if($nums==$i){
//echo $i;
 $Optionsa=rtrim($Optionsa, ",");
  $Optionsa=$Optionsa. "]";
 echo $Optionsa;
}else{
$Optionsa=$Optionsa. "]";
 echo $Optionsa;
}

}
//get info for a coach
function getCoachInfo($coachname){
	
	
	//$usr=$_POST['user'];
$sqla = "SELECT firstName, lastName FROM `users` WHERE `username`='$coachname'";

$Ra = mysql_query($sqla) or die("Mysql execute query error" .mysql_error());

$names = "";

while ($Sa = mysql_fetch_array($Ra))
{

$names=$Sa["firstName"]." ".$Sa["lastName"];

	
}
return $names;

	
}

//session taken by users
if(isset($_POST['takenby'])){
	
		//include("connect.php");
		$takenby=$_POST['takenby'];
	//$usr=$_POST['user'];
	//echo $takenby;
$sq = "SELECT * FROM `takesessions` WHERE `session_id`='$takenby'";// AND `user_id`=users.id ORDER BY firstName";
$j=0;
$howmany = mysql_query ("SELECT count(user_id) FROM `takesessions` WHERE `session_id`='$takenby'");
$many=mysql_num_rows($howmany);
$At = mysql_query($sq,$conn) or die("Mysql execute query error" .mysql_error());
$they='[';//=array();
while ($athl = mysql_fetch_array($At))
{
	//$they[$j]=$athl['user_id'];
	//array_push($they,$athl['user_id'],$athl['completed']);
	//take just ids in array
//$they=$they."<section><input type='checkbox' name='check$j' checked='checked' value='$athl[id]' /><label>$athl[firstName] $athl[lastName]</label></section>";
$j++;	
if($many==$j){
//echo $i;
$they=$they.'{ "id":"'.$athl["user_id"].'" , "iscompleted":"'.$athl["completed"].'", "whenis":"'.$athl["whenis"].'" }';
}else{
$they=$they.',{ "id":"'.$athl["user_id"].'" , "iscompleted":"'.$athl["completed"].'", "whenis":"'.$athl["whenis"].'" }';
}

}//end while

if($many==$j){
//echo $i;
 $they=rtrim($they, ",");
  $they=$they. "]";
 echo $they;
}else{
$they=$they. "]";
 echo $they;
}
 //echo $they;//json_encode($they);
	
}

//EDIT A SESSION
if(isset($_POST['editsession'])){
	//foreach ($_POST as $key => $value) echo $key.'='.$value.'<br />';
	//print_r($_POST);
	//include("connect.php");
 $whenis = $_POST['whenis'];//date("Y-m-d H:i:s");
 
  $etype=$_POST['etype'];
  $edescription=htmlspecialchars($_POST['edescription'], ENT_QUOTES);
  $edistance=$_POST['edistance'];
  //$eduration=$_POST['duration'];
  $which=$_POST['editsession'];
  $intervals=$_POST['eintervals'];
  $durat=$_POST['alldur'];
  /*for($i=1;$i<=$intervals;$i++){
	$durat=$durat+$_POST['eduration'.$i];
  } $durat=$durat/0.60;*/
  mysql_query("DELETE FROM `intervals` WHERE session_id='$which'")or die("There's little problem with deleting previous intervals: ".mysql_error());
  mysql_query("DELETE FROM `takesessions` WHERE session_id='$which'")or die("There's little problem with deleting previous takesessions users: ".mysql_error());
    $update = mysql_query("UPDATE `sessions` SET type='$etype', description='$edescription', distance='$edistance', duration='$durat', allcompleted=0, time_added='$whenis' WHERE id='$which'");
if(!$update){
die("There's little problem with session edit: ".mysql_error());
}else{
echo "Successfully edited session";
}

$i=1;
 for($i=1;$i<=$intervals;$i++){
	$desc=htmlspecialchars($_POST['edescription'.$i], ENT_QUOTES);
	$dur=$_POST['eduration'.$i];
	$lev=$_POST['elevel'.$i];
	//$dis=$_POST['edistance'.$i];
	$ins = mysql_query("INSERT INTO `intervals` (`session_id`, `description`, `level`, `duration`) VALUES ('$which', '$desc', '$lev', '$dur')");

if(!$ins){
die("There's little problem with table insert: ".mysql_error());
}
	
 }
 
	foreach ($_POST as $key => $value){
	 // if(isset($_POST['check'.$i])){
		if (strpos($key,'check') !== false) {
   		
	 $inserta = mysql_query("INSERT INTO `takesessions` (`user_id`, `session_id`) VALUES ('$value', '$which')");

if(!$inserta){
die("There's little problem with insertion: ".mysql_error());
}
	
	 }
	  
  	}

}
//ADD A SESSION
if(isset($_POST['addsession'])){
	
	//include("connect.php");
	//foreach ($_POST as $key => $value) echo $key.'='.$value.'<br />';
	//print_r($_POST);
	$today =$_POST['timeadded']; //date("Y-m-d H:i:s");
  $type=$_POST['type'];
  $description=htmlspecialchars($_POST['description'], ENT_QUOTES);
  $distance=$_POST['distance'];
  $who=$_POST['addsession'];
  $intervals=$_POST['intervals'];
  $durat=$_POST['alldur'];
  /*for($i=1;$i<=$intervals;$i++){
	$durat=$durat+$_POST['duration'.$i];
  }*/
$insert = mysql_query("INSERT INTO `sessions` (`type`, `description`, `distance`, `duration`, `by`, `allcompleted`, `time_added`) VALUES ('$type', '$description', '$distance', '$durat', '$who', 0, '$today')");

if(!$insert){
die("There's little problem with sessions insert: ".mysql_error());
}else{
echo "Successfully added session";
}

	//to see what id is this just added session
	$sessionid;
	$sqla = "SELECT id FROM `sessions` WHERE `by`='$who' ORDER BY id DESC LIMIT 1";
	 $Ra = mysql_query($sqla) or die("Mysql execute query error" .mysql_error());
 while ($row = mysql_fetch_array($Ra))
  {
	  //echo "<br />session id: ".$row['id'];
	  $sessionid=$row['id'];
  }
  

   $i=1;
 for($i=1;$i<=$intervals;$i++){
	 
	$desc=htmlspecialchars($_POST['description'.$i], ENT_QUOTES);
	$dur=$_POST['duration'.$i];
	$lev=$_POST['level'.$i];
	
	$ins = mysql_query("INSERT INTO `intervals` (`session_id`, `description`, `level`, `duration`) VALUES ('$sessionid', '$desc', '$lev', '$dur')");

if(!$ins){
die("There's little problem with table insert: ".mysql_error());
}
	
 }
 
	foreach ($_POST as $key => $value){
	 // if(isset($_POST['check'.$i])){
		if (strpos($key,'check') !== false) {
   		
	 $inserta = mysql_query("INSERT INTO `takesessions` (`user_id`, `session_id`) VALUES ('$value', '$sessionid')");

if(!$inserta){
die("There's little problem with insertion: ".mysql_error());
}
	
	 }
	  
	  
  	}
  
	
}

//TEST add member
if(isset($_GET['testuser'])){
$username = htmlspecialchars($_GET['testuser']);
//$ifexists=mysql_num_rows($addq);

$addq = "SELECT * FROM `users` WHERE `username`='$username'";
	 $Ra = mysql_query($addq) or die("Mysql execute query error" .mysql_error());
 while ($row = mysql_fetch_array($Ra))
  {
	  //echo "<br />session id: ".$row['id'];
	 echo $row['username']. " - ".$row['lastName'];
  }
  


}
//administrator adds a member to the club
if(isset($_POST['submit'])){

if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
	
$firstname = htmlspecialchars($_POST['firstname']);
$lastname = htmlspecialchars($_POST['lastname']);
$firstname=ucfirst($firstname);
$lastname=ucfirst($lastname);
$age = htmlspecialchars($_POST['age']);
$username = htmlspecialchars($_POST['user']);
$password = htmlspecialchars($_POST['pass']);
$trained = htmlspecialchars($_POST['trained']);
$coach= $_POST['coach'];
$email=$_POST['email'];
$picture='default_user.jpg';
$query = "select username from `users` where `username` = '".strtolower($username)."'";
	$results = mysql_query( $query) or die('Mysql error: '.mysql_error());
	
	if(mysql_num_rows(@$results) > 0){ // not available
	die("This username is already added!");
	}
/*if($firstname or $lastname or $age or $username or $password == ''){
echo "you left one or more of the fields in the form empty.<br /><a href='admin.php'>Go back to Admin panel</a>";
return;
}*/
//include("connect.php");
if($coach=='on'){
//echo $firstname. $lastname. " is a coach";
$insert = mysql_query("INSERT INTO users (username, password, firstName, lastName, age, coach, trained_by, email, picture) VALUES ('$username', '$password', '$firstname', '$lastname', '$age',1,'nobody', '$email', '$picture')");

if(!$insert){
die("There's little problem with adding a member: ".mysql_error());
}else{
echo "Successfully added coach";
	}
	
}else{

/*if($trained== ''){
echo "you have to enter you coach in the \"trained\" field. <br /><a href='admin.php'>Go back to Admin panel</a>";
return;
}*/

$insert = mysql_query("INSERT INTO users (username, password, firstName, lastName, age, coach, trained_by, email, picture) VALUES ('$username', '$password', '$firstname', '$lastname', '$age',0,'$trained', '$email', '$picture')");

if(!$insert){
die("There's little problem with adding: ".mysql_error());
}else{
echo "Successfully added athlete";
}
	

}

//echo $firstname. " ".$lastname. " was successfully added into the system. He is trained by ".$trained;
}
}
 //end of isset session
 //all info about athlete for admin panel
if(isset($_GET['allathletes'])){
	if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
	/*
	echo '<form method="post"><div id="radio">';
while ($members = mysql_fetch_array($getmembers)) {
	$tr=$members[trained_by];
	$u=$members[trained_by];
	$getcoach = mysql_query("SELECT firstName,lastName FROM `users` WHERE `username`='$tr'");
	while ($mycoach = mysql_fetch_array($getcoach)) {
		$tr=$mycoach[firstName]. " ".$mycoach[lastName];
	}
echo "<input type='radio' id='radio$ch' name='radio' value='$members[id]'/><label for='radio$ch' title='$u'>$members[firstName] $members[lastName]</label> - trained by $tr";
$ch++;
echo "<br />";
}
echo "</div>";
*/
//include ("connect.php");
$getmembers = mysql_query("SELECT * FROM `users` WHERE `trained_by`!='nobody' ORDER BY firstName");
$ch=1;
echo '<form method="post">Athlete:<select id="radio">';
while ($members = mysql_fetch_array($getmembers)) {
	$tr=$members['trained_by'];
	$u=$members['trained_by'];
	$getcoach = mysql_query("SELECT firstName,lastName FROM `users` WHERE `username`='$tr'");
	while ($mycoach = mysql_fetch_array($getcoach)) {
		$tr=$mycoach['firstName']. " ".$mycoach['lastName'];
	}
echo "<option id='radio$ch' value='$members[id]' class='$members[age]' name='$tr' title='$u'>$members[firstName] $members[lastName]</option>";
$ch++;
//echo "<br />";
}
echo "</select><br />Current Coach:<input id='currentc' value='' disabled/>";
echo '<br />New Coach:<select id="newcoach" name="newcoach">';
$getnewcoach = mysql_query("SELECT * FROM users WHERE coach='1' ORDER BY firstName");
while ($him = MySQL_Fetch_Array($getnewcoach)) {
echo "<option value='$him[username]' title='$him[id]' class='$him[age]'>$him[firstName] $him[lastName]</option>";
}
echo "</select><p><input type='button' value='Change coach' name='changecoach' onclick='doYouWant();return false;' /></p><br />FirstName:<input type='text' name='newfirstname' id='newfirst'/><br />LastName:<input type='text' name='newlastname' id='newlast'/><br />Year of birth:<input type='text' name='newyear' id='newyear' size='4'  maxlength='4' min='1940' max='2003'/><br /><input type='button' value='Change details' name='changedetails' title='' id='chdetails' onclick='changeDetails();return false;' /></form>";
	}

}


//change username - user do it
if(isset($_POST['changeuser'])){

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
$chu=$_POST['changeuser'];
$chuid=$_POST['changeid'];
$ifcoach=$_POST['ifcoach'];
$cuser=$_POST['cuser'];
if($chuid==1){
exit;	
}
//include("connect.php");
if($ifcoach==0){
 $final = mysql_query("UPDATE `users` SET `username`='$chu' WHERE `id`='$chuid'") or die(mysql_error()); 
}else{
	$final = mysql_query("UPDATE `users` SET `username`='$chu' WHERE `id`='$chuid'") or die(mysql_error()); 
	$finish= mysql_query("UPDATE `users` SET `trained_by`='$chu' WHERE `trained_by`='$cuser'") or die(mysql_error()); 
}
 
if(!$final){
die("There's little problem with update username: ".mysql_error());
}else{
echo "Successfully changed username";
	}
}
}

//change password - user do it
if(isset($_POST['changepass'])){

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
$chp=$_POST['changepass'];
$chuid=$_POST['changeid'];
if($chuid==1){
exit;	
}
//$ifcoach=$_POST['ifcoach'];
//$cuser=$_POST['cuser'];
//include("connect.php");
 $fin = mysql_query("UPDATE `users` SET `password`='$chp' WHERE `id`='$chuid'") or die(mysql_error()); 
 
if(!$fin){
die("There's little problem with update password change: ".mysql_error());
}else{
echo "Successfully changed password";
	}
}
}

//change email- user do it
if(isset($_POST['changeemail'])){

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
$che=$_POST['changeemail'];
$chuid=$_POST['changeid'];
if($chuid==1){
exit;	
}
//$ifcoach=$_POST['ifcoach'];
//$cuser=$_POST['cuser'];
//include("connect.php");
 $fin = mysql_query("UPDATE `users` SET `email`='$che' WHERE `id`='$chuid'") or die(mysql_error()); 
 
if(!$fin){
die("There's little problem with update email: ".mysql_error());
}else{
echo "Successfully changed email address";
	}
}
}

//change your picture
if(isset($_POST['myuid'])){
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
	$pic=$_POST['myuid'].".jpg";
	$chuid=$_POST['myuid'];
	$file = $_FILES['file']['name'];
$tmp_file = $_FILES['file']['tmp_name'];
$size = $_FILES['file']['size'];
$poster="./images/".$chuid.".jpg";//.basename($file);
//echo $poster;
//basename($file)="7.jpg";
/*if(file_exists($poster)) {echo "<p>Файла съществува !<br /></p>";
echo basename($file);
exit;}*/

if($size==0) {echo "<p>Файла е повреден !<br /><br /></p>";exit;}
if($size>999999) {echo "<p>Файла е много голям !<br /><br /></p>";exit;}
$extensions = array("gif","jpg","jpeg","png");
$extension_file = end(explode(".",$file));
$extension_file = strtolower($extension_file);
if(!in_array($extension_file,$extensions)) {echo "<p>Този файл е не позволен ! Може да качвате само gif, jpg, jpeg, png !<br /></p>";exit;}
$upload = move_uploaded_file ($tmp_file,$poster);
if($upload){
	$pquery = mysql_query("UPDATE `users` SET `picture`='$pic' WHERE `id`='$chuid'") or die(mysql_error()); 
	if(!$pquery){
die("There's little problem with update your picture: ".mysql_error());
}else{
echo "Successfully changed profile picture";
	}
}
	
	}
}


//change details of user
if(isset($_POST['changedetails'])){
	//foreach ($_POST as $key => $value) echo $key.'='.$value.'<br />';
	//print_r($_POST);
	$userid=$_POST['changedetails'];
	$newname=$_POST['newfirstname'];
	$newname2=$_POST['newlastname'];
	$newyear=$_POST['newyear'];
	$ademail=$_POST['ademail'];
	if($userid==1){
		if($_SESSION['username']=='administrator'){
	$fin = mysql_query("UPDATE `users` SET `email`='$ademail' WHERE `id`='$userid'") or die(mysql_error()); 	
		}else{
		exit;	
		}
	}
	//change details of user
if(isset($_POST['newfirstname']) && isset($_POST['newlastname']) && isset($_POST['newyear'])){
 $updetails = mysql_query("UPDATE `users` SET `firstName`='$newname', `lastName`='$newname2', `age`='$newyear' WHERE `id`='$userid'") or die(mysql_error()); 
	 if(!$updetails){
die("There's little problem with updating user details: ".mysql_error());
}else{
echo "Successfully updated details";
	}
	
}	
	

}

//change the coach
if(isset($_POST['newcoach'])){
	if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
		//include("connect.php");
		$newc=$_POST['newcoach'];
		$theid=$_POST['radio'];
	  $result = mysql_query("UPDATE `users` SET `trained_by`='$newc' WHERE `id`='$theid'") or die(mysql_error()); 
	  $del=mysql_query("DELETE FROM `takesessions` WHERE `user_id`='$theid'") or die(mysql_error()); 
	 if(!$result){
die("There's little problem with update coach: ".mysql_error());
}else{
echo "Successfully changed coach";
	}
	
	}
}

//check if user exists
if(isset($_POST['isuser']))
{
	if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
		//include("connect.php");
	$username = $_POST['isuser'];
	$query = "select username from `users` where `username` = '".strtolower($username)."'";
	$results = mysql_query( $query) or die('Mysql error: '.mysql_error());
	
	if(mysql_num_rows(@$results) > 0) // not available
	{
		echo '<div id="Error">Already Taken</div>';
		 
	}
	else
	{
		echo '<div id="Success">Available</div>';
		
	}
	
	
	}
}

//test check if user exists
if(isset($_GET['testUser']))
{
	 if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
		//include("connect.php");
	$username 	= $_GET['testUser'];
	$query = "select username from `users` where `username` = '".strtolower($username)."'";
	$results = mysql_query( $query) or die('Mysql error: '.mysql_error());
	
	if(mysql_num_rows(@$results) > 0) // not available
	{
		 //echo '<div id="Error">Already Taken</div>';
		echo "exist";
	}
	else
	{
		echo "not exist";
		 //echo '<div id="Success">Available</div>';
	}
	 }
	 
}
//test athletes number
if(isset($_GET['testAthletes']))
{
	 if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
		//include("connect.php");
	//$username 	= $_GET['testUser'];
	$query = "select id from `users` where `trained_by` != 'nobody'";
	$results = mysql_query( $query) or die('Mysql error: '.mysql_error());
	echo mysql_num_rows(@$results);
	
	 }
	 
}

//set completed when session is finished
if(isset($_POST['completedby']) && isset($_POST['sid'])){
	//foreach ($_POST as $key => $value) echo $key.'='.$value.'<br />';
	//include("connect.php");
	$sid=$_POST['sid'];
	$compby=$_POST['completedby'];
	$upd = mysql_query("UPDATE `takesessions` SET `completed`=1 WHERE `session_id`='$sid' AND `user_id`='$compby'") or die(mysql_error()); 
	 if(!$upd){
die("There's little problem with update completed session by user: ".mysql_error());
}else{
	$howall = mysql_query("SELECT * FROM `takesessions` WHERE `session_id`='$sid'");
	$howcom = mysql_query("SELECT * FROM `takesessions` WHERE `session_id`='$sid' AND `completed`=1");
	if(mysql_num_rows(@$howall)==mysql_num_rows(@$howcom)){
		mysql_query("UPDATE `sessions` SET `allcompleted`=1 WHERE `id`='$sid'") or die(mysql_error());
	}
echo "Successfully completed session";
	}
}

//remove a member
if(isset($_POST['removemember'])){
	if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
		//include("connect.php");
	$leave=$_POST['removemember'];
	$leaveu=$_POST['memberusername'];
	mysql_query("DELETE FROM `users` WHERE id='$leave'") or die("There's little problem with deleting member: ".mysql_error());
	mysql_query("DELETE FROM `takesessions` WHERE user_id='$leave'") or die("There's little problem with deleting taken sessions by this user: ".mysql_error());
	mysql_query("DELETE FROM `sessions` WHERE `by`='$leaveu'") or die("There's little problem with deleting sessions by this coach: ".mysql_error());
	mysql_query("UPDATE `users` SET `trained_by`='newonecoach' WHERE `trained_by`='$leaveu'") or die(mysql_error());
	echo "Successfully removed member";
	}
}

//remove sessions
if(isset($_POST['removesessions'])){
	if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
		//include("connect.php");
	mysql_query("TRUNCATE TABLE `sessions`") or die("There's little problem with deleting sessions: ".mysql_error());
	mysql_query("TRUNCATE TABLE `intervals`") or die("There's little problem with deleting sessions: ".mysql_error());
	mysql_query("TRUNCATE TABLE `takesessions`") or die("There's little problem with deleting sessions: ".mysql_error());
	echo "Successfully removed sessions";
	
	}
}

if(isset($_GET['getallsessions'])){
if(isset($_SESSION['username']) && $_SESSION['username']=='administrator'){
$text.="<p>All Training Sessions</p><br />";	

$sqla = "SELECT * FROM `sessions`";
 //$resw = mysql_query ("SELECT count(id) FROM `sessions` WHERE `by`='$usr'");
//$nums=mysql_num_rows($resw);
$sesid=0;
$usern='';
 $Ra = mysql_query($sqla) or die("Mysql execute query error" .mysql_error());  
  while ($Sa = mysql_fetch_array($Ra))
  {
	  $sesid=$Sa['id'];
	  $usern=$Sa['by'];
	  $whoishe='';
	  $squ = "SELECT * FROM `users` WHERE `username`='$usern'";
 $Raz = mysql_query($squ) or die("Mysql execute query error" .mysql_error());  
  while ($Sav = mysql_fetch_array($Raz))
  {
	  $whoishe=$Sav['firstName']." " .$Sav['lastName'];
  }
	   $text.="<br /><h4>".$Sa['id'].":".$Sa['type']. " by ".$whoishe."</h4><br /><h5>".$Sa['description']." - ".$Sa['distance']." kilometers for ".$Sa['duration']." minutes (added:".$Sa['time_added'].")</h5>";
$text.="<p>Intervals</p>";
 $sqlat = "SELECT * FROM `intervals` WHERE `session_id`='$sesid'";
 //$resw = mysql_query ("SELECT count(id) FROM `sessions` WHERE `by`='$usr'");
//$nums=mysql_num_rows($resw);
 $Rat = mysql_query($sqlat) or die("Mysql execute query error" .mysql_error());  
  while ($Sa = mysql_fetch_array($Rat))
  {
	$text.="<p>".$Sa['description']. " at ".$Sa['level']." level for ".$Sa['duration']." minutes</p>";

  }
  $text.="<p>Taken By</p>";
  $sq = "SELECT * FROM `takesessions`,`users` WHERE `session_id`='$sesid' AND `user_id`=users.id";
 //$resw = mysql_query ("SELECT count(id) FROM `sessions` WHERE `by`='$usr'");
//$nums=mysql_num_rows($resw);
 $Rata = mysql_query($sq) or die("Mysql execute query error" .mysql_error());  
  while ($Sa = mysql_fetch_array($Rata))
  {
	 $text.="<p>".$Sa['firstName']." " .$Sa['lastName'];
	 if($Sa['completed']==1){
	  	$text.=" - completed at ".$Sa['whenis']."</p><br />";
	 }else{
		$text.="</p>"; 
	 }
$text.="<br />"; 
  }
  
  
  }//first while
  
require('fpdf17/fpdf.php');
  require('fpdf17/html2pdf/html2pdf.php');
$pdf=new PDF_HTML();
    $pdf->SetFont('Arial','',12);
    $pdf->AddPage();
     //$text=$_POST['getallsessions'];
    if(ini_get('magic_quotes_gpc')=='1')
     $text=stripslashes($text);
    $pdf->WriteHTML($text);
   $pdf->Output("AllInfo.pdf", 'F');
  echo $text;
   exit;

}
}

if(isset($_POST['makeit'])){
//by Philip Clarke
require('fpdf17/fpdf.php');
//$firstName=$_POST['firstname'];
//print_r($_POST);
//$lastName=$_POST['lastname'];

/*$nice=$_POST['makeit'].".pdf";
$pdf = new FPDF();
$pdf->title = 'My title';
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,"All Sessions !!!");
$pdf->Ln();
include("connect.php");
$sqla = "SELECT * FROM `sessions` ORDER BY `id` desc";
 $resw = mysql_query ("SELECT count(id) FROM `sessions` WHERE `by`='$usr'");
$f=50;
$s=20;
$nums=mysql_num_rows($resw);
 $Ra = mysql_query($sqla) or die("Mysql execute query error" .mysql_error());  
  while ($Sa = mysql_fetch_array($Ra))
  {
	  $pdf->Cell($f,$s,$Sa['type']. ":".$Sa['description']." - ".$Sa['time_added'] );
 $f=$f-3;
 $s=$s+3;
 $pdf->Ln();
  }
  $pdf->AddPage();
*/
//this script is by Philip Clarke
class PDF extends FPDF {

var $tablewidths;
var $headerset;
var $footerset;

function _beginpage($orientation, $size) {
    $this->page++;
    if(!isset($this->pages[$this->page])) // solves the problem of overwriting a page if it already exists
        $this->pages[$this->page] = '';
    $this->state  =2;
    $this->x = $this->lMargin;
    $this->y = $this->tMargin;
    $this->FontFamily = '';
    // Check page size and orientation
    if($orientation=='')
        $orientation = $this->DefOrientation;
    else
        $orientation = strtoupper($orientation[0]);
    if($size=='')
        $size = $this->DefPageSize;
    else
        $size = $this->_getpagesize($size);
    if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1])
    {
        // New size or orientation
        if($orientation=='P')
        {
            $this->w = $size[0];
            $this->h = $size[1];
        }
        else
        {
            $this->w = $size[1];
            $this->h = $size[0];
        }
        $this->wPt = $this->w*$this->k;
        $this->hPt = $this->h*$this->k;
        $this->PageBreakTrigger = $this->h-$this->bMargin;
        $this->CurOrientation = $orientation;
        $this->CurPageSize = $size;
    }
    if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1])
        $this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
}

function Header()
{
    global $maxY;

    // Check if header for this page already exists
    if(!$this->headerset[$this->page]) {

        foreach($this->tablewidths as $width) {
            $fullwidth += $width;
        }
        $this->SetY(($this->tMargin) - ($this->FontSizePt/$this->k)*2);
        $this->cellFontSize = $this->FontSizePt ;
        $this->SetFont('Arial','',( ( $this->titleFontSize) ? $this->titleFontSize : $this->FontSizePt ));
        $this->Cell(0,$this->FontSizePt,$this->titleText,0,1,'C');
        $l = ($this->lMargin);
        $this->SetFont('Arial','',$this->cellFontSize);
        foreach($this->colTitles as $col => $txt) {
            $this->SetXY($l,($this->tMargin));
            $this->MultiCell($this->tablewidths[$col], $this->FontSizePt,$txt);
            $l += $this->tablewidths[$col] ;
            $maxY = ($maxY < $this->getY()) ? $this->getY() : $maxY ;
        }
        $this->SetXY($this->lMargin,$this->tMargin);
        $this->setFillColor(200,200,200);
        $l = ($this->lMargin);
        foreach($this->colTitles as $col => $txt) {
            $this->SetXY($l,$this->tMargin);
            $this->cell($this->tablewidths[$col],$maxY-($this->tMargin),'',1,0,'L',1);
            $this->SetXY($l,$this->tMargin);
            $this->MultiCell($this->tablewidths[$col],$this->FontSizePt,$txt,0,'C');
            $l += $this->tablewidths[$col];
        }
        $this->setFillColor(255,255,255);
        // set headerset
        $this->headerset[$this->page] = 1;
    }

    $this->SetY($maxY);
}

function Footer() {
    // Check if footer for this page already exists
    if(!$this->footerset[$this->page]) {
        $this->SetY(-15);
        //Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        // set footerset
        $this->footerset[$this->page] = 1;
    }
}

function morepagestable($lineheight=8) {
    // some things to set and 'remember'
    $l = $this->lMargin;
    $startheight = $h = $this->GetY();
    $startpage = $currpage = $this->page;

    // calculate the whole width
    foreach($this->tablewidths as $width) {
        $fullwidth += $width;
    }

    // Now let's start to write the table
    $row = 0;
    while($data=mysql_fetch_row($this->results)) {
        $this->page = $currpage;
        // write the horizontal borders
        $this->Line($l,$h,$fullwidth+$l,$h);
        // write the content and remember the height of the highest col
        foreach($data as $col => $txt) {

            $this->page = $currpage;
            $this->SetXY($l,$h);
            $this->MultiCell($this->tablewidths[$col],$lineheight,$txt,0,$this->colAlign[$col]);

            $l += $this->tablewidths[$col];

            if($tmpheight[$row.'-'.$this->page] < $this->GetY()) {
                $tmpheight[$row.'-'.$this->page] = $this->GetY();
            }
            if($this->page > $maxpage)
                $maxpage = $this->page;
            unset($data[$col]);
        }
        // get the height we were in the last used page
        $h = $tmpheight[$row.'-'.$maxpage];
        // set the "pointer" to the left margin
        $l = $this->lMargin;
        // set the $currpage to the last page
        $currpage = $maxpage;
        unset($data[$row]);
        $row++ ;
    }
    // draw the borders
    // we start adding a horizontal line on the last page
    $this->page = $maxpage;
    $this->Line($l,$h,$fullwidth+$l,$h);
    // now we start at the top of the document and walk down
    for($i = $startpage; $i <= $maxpage; $i++) {
        $this->page = $i;
        $l = $this->lMargin;
        $t = ($i == $startpage) ? $startheight : $this->tMargin;
        $lh = ($i == $maxpage) ? $h : $this->h-$this->bMargin;
        $this->Line($l,$t,$l,$lh);
        foreach($this->tablewidths as $width) {
            $l += $width;
            $this->Line($l,$t,$l,$lh);
        }
    }
    // set it to the last page, if not it'll cause some problems
    $this->page = $maxpage;
}

function connect($host='localhost',$username='',$password='',$db=''){
    $this->conn = mysql_connect($host,$username,$password) or die( mysql_error() );
    mysql_select_db($db,$this->conn) or die( mysql_error() );
    return true;
}

function query($query){
    $this->results = mysql_query($query,$this->conn);
    $this->numFields = mysql_num_fields($this->results);
}

function mysql_report($query,$dump=false,$attr=array()){

    foreach($attr as $key=>$val){
        $this->$key = $val ;
    }

    $this->query($query);

    // if column widths not set
    if(!isset($this->tablewidths)){

        // starting col width
        $this->sColWidth = (($this->w-$this->lMargin-$this->rMargin))/$this->numFields;

        // loop through results header and set initial col widths/ titles/ alignment
        // if a col title is less than the starting col width / reduce that column size
        for($i=0;$i<$this->numFields;$i++){
            $stringWidth = $this->getstringwidth(mysql_field_name($this->results,$i)) + 6 ;
            if( ($stringWidth) < $this->sColWidth){
                $colFits[$i] = $stringWidth ;
                // set any column titles less than the start width to the column title width
            }
            $this->colTitles[$i] = mysql_field_name($this->results,$i) ;
            switch (mysql_field_type($this->results,$i)){
                case 'int':
                    $this->colAlign[$i] = 'R';
                    break;
                default:
                    $this->colAlign[$i] = 'L';
            }
        }

        // loop through the data, any column whose contents is bigger that the col size is
        // resized
        while($row=mysql_fetch_row($this->results)){
            foreach($colFits as $key=>$val){
                $stringWidth = $this->getstringwidth($row[$key]) + 6 ;
                if( ($stringWidth) > $this->sColWidth ){
                    // any col where row is bigger than the start width is now discarded
                    unset($colFits[$key]);
                }else{
                    // if text is not bigger than the current column width setting enlarge the column
                    if( ($stringWidth) > $val ){
                        $colFits[$key] = ($stringWidth) ;
                    }
                }
            }
        }

        foreach($colFits as $key=>$val){
            // set fitted columns to smallest size
            $this->tablewidths[$key] = $val;
            // to work out how much (if any) space has been freed up
            $totAlreadyFitted += $val;
        }

        $surplus = (sizeof($colFits)*$this->sColWidth) - ($totAlreadyFitted);
        for($i=0;$i<$this->numFields;$i++){
            if(!in_array($i,array_keys($colFits))){
                $this->tablewidths[$i] = $this->sColWidth + ($surplus/(($this->numFields)-sizeof($colFits)));
            }
        }

        ksort($this->tablewidths);

        if($dump){
            Header('Content-type: text/plain');
            for($i=0;$i<$this->numFields;$i++){
                if(strlen(mysql_field_name($this->results,$i))>$flength){
                    $flength = strlen(mysql_field_name($this->results,$i));
                }
            }
            switch($this->k){
                case 72/25.4:
                    $unit = 'millimeters';
                    break;
                case 72/2.54:
                    $unit = 'centimeters';
                    break;
                case 72:
                    $unit = 'inches';
                    break;
                default:
                    $unit = 'points';
            }
            print "All measurements in $unit\n\n";
            for($i=0;$i<$this->numFields;$i++){
                printf("%-{$flength}s : %-10s : %10f\n",
                    mysql_field_name($this->results,$i),
                    mysql_field_type($this->results,$i),
                    $this->tablewidths[$i] );
            }
            print "\n\n";
            print "\$pdf->tablewidths=\n\tarray(\n\t\t";
            for($i=0;$i<$this->numFields;$i++){
                ($i<($this->numFields-1)) ?
                print $this->tablewidths[$i].", /* ".mysql_field_name($this->results,$i)." */\n\t\t":
                print $this->tablewidths[$i]." /* ".mysql_field_name($this->results,$i)." */\n\t\t";
            }
            print "\n\t);\n";
            exit;
        }

    } else { // end of if tablewidths not defined

        for($i=0;$i<$this->numFields;$i++){
            $this->colTitles[$i] = mysql_field_name($this->results,$i) ;
            switch (mysql_field_type($this->results,$i)){
                case 'int':
                    $this->colAlign[$i] = 'R';
                    break;
                default:
                    $this->colAlign[$i] = 'L';
            }
        }
    }

    mysql_data_seek($this->results,0);
    $this->AliasNbPages();
    $this->SetY($this->tMargin);
    $this->AddPage();
    $this->morepagestable($this->FontSizePt);
}

}

$pdf = new PDF('L','pt','A4');
$pdf->SetFont('Arial','',15);
$pdf->title = 'All Sessions';

$pdf->connect('localhost','root','gamen7','club');
$tomorrow = mktime(0,0,0,date("m")-1,date("d"),date("Y"));
//$pdf->Ln();
//$pdf->Cell(40,10,"Last month was ".date("F", $tomorrow));
$attr = array('titleFontSize'=>20, 'titleText'=>'All Sessions for '.date("F", $tomorrow));
$month=date("m")-1;
$pdf->mysql_report("SELECT * FROM sessions ",false,$attr);//WHERE EXTRACT(MONTH FROM time_added)=$month
//Determine a temporary file name in the current directory
//$file = basename(tempnam('.', 'tmp'));
//rename($file, $file.'.pdf');
//$file .= '.pdf';
//Save PDF to file


$pdf->Output("AllSessions.pdf", 'F');//date("F\.Y", $tomorrow)
echo "AllSessions";
//Redirect
//header('Location: '.$file);
}

?>