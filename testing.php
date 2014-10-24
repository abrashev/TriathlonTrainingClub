<?php
error_reporting(0);
if(isset($_POST['submit'])){
$file = $_FILES['file']['name'];
$tmp_file = $_FILES['file']['tmp_name'];
$size = $_FILES['file']['size'];
$poster="./images/7.jpg";//.basename($file);
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
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="css/qunit-1.12.0.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Test Page</title>
<script src="js/jquery-1.9.1.js"></script>

<script src="js/qunit-1.12.0.js"></script>

</head>

<body>
 <div id="qunit"></div>
  <div id="qunit-fixture"></div>
  <div id="testdiv"></div>
  <script>

    var x="Misha";
	var y="Burton";
	var age="1974";
	var user="misha";
	var pass="kiss";
	var email="misha@abv.bg";
	var trained="john";
	var parameters = "submit=addmember&firstname="+x+"&lastname="+y+"&age="+age+"&user="+user+"&pass="+pass+"&email="+email+"&trained="+trained;
  document.getElementById("testdiv").innerHTML="These are the parameters for the user we are going to add in db:<br />"+parameters;
	  
	function testUser(expected){
	$.get("enter.php?testUser="+user, function(response){ //alert(response);
	 
		  test( "Check if username "+user+" is in database", function() {
		  
	 		  equal(response, expected, "We expect the user: "+user+" "+response+" in db" );
			
			});
		});
	}
	function testNumberAthletes(expect){
		$.get("enter.php?testAthletes=howmany", function(response){ 
		test( "Check athletes number", function() {
		
		equal( response, expect, "We expect athletes number to be "+expect );
		
		
	  });
    });
	}
  
  function AddTheMember(){
$.post("enter.php",parameters, function(response){
	//alert(response);
	test( "Add user "+user+" to database", function() {
	
	equal( response, "Successfully added athlete", "We expect "+user+" to be added successfully in db" );
  
    });
	
});
  }
	
		//testUser('not exist');
		//testNumberAthletes('11');
		AddTheMember();
		testUser('exist');
		testNumberAthletes('12');
  </script>
</body>
</html>