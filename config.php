<?
$host="127.0.0.1";
$dbusername="root";
$dbpassword="gamen7";
$db="club";
$conn=@mysql_connect("$host","$dbusername", "$dbpassword") or die(mysql_error());
$mydb=@mysql_select_db($db) or die(mysql_error());
 
if (!$conn)
{
die("Could not connect: " . mysql_error());
}

?>