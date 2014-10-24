<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="project, aberystwyth, computer science, third year, athlete, coach">
<meta name="description" content="CS39440 Major Project">
<title>Test functions</title>
 <link rel="stylesheet" href="./css/style.css" type="text/css" media="screen" />
  <style type="text/css">
  body{
	  color:#FFF;
  }
  </style>
<!-- 
 var myCenter=new google.maps.LatLng(51.1509743,-0.120850);
	
	<form id="addsession" method="post" action="#">
	    	
		<select>
        <option>Cycling</option>
        <option>Running</option>
        </select>
		<input type="text" size="20" value="some description"/>
        <input type="text" size="3" value="distance"/> 
		<input type="button" value="Add New Session" onClick="addSession();return false;"/>
	</form>
	how many watts for 5min just cycling basicly or just one 1 of the three disciplines
function initialize()
{
var mapProp = {
  center: myCenter,
  zoom:5,
  mapTypeId: google.maps.MapTypeId.ROADMAP
  };
function changeMap(){
	var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
	map.setZoom(16);
  var newCenter=new google.maps.LatLng(52.447457,-4.026728);
  map.setCenter(newCenter);
	
	}
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
  position: myCenter,
  title:'Click to zoom'
  });

marker.setMap(map);

// Zoom to 9 when clicking on marker
google.maps.event.addListener(marker,'click',function() {
 changeMap();
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
	
<div id="googleMap" style="width:500px;height:380px;display:none;"></div>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false"></script>
    -->
    
</head>

<body>
<p>IMPROVEMENTS<p>
•	Added email column in the database and in webpage
•	Different Interval when changing the chart , 30 or 15 but still have to change count up and countdown to change at specific second everything (or calculated depend on duration)
•	Will add pagination into the sessions 7 per page and will be more like list not table
•	Member will change username ,email and password - for username queries have to be executed to change in every coach field in users (admin could change names and year of birth)
•	Validate edit and add session functionality in JS and PHP as well
<p>CORRECTIONS</p>
•	New version of Xampp 3.2.1 (07.05.2013) there are errors with include which I fixed with inserting config inside PHP once and commented all others includes in each but still had to change in the places where i need to include config anyway
•	To make better design of tables and look on mobiles both small and large
•	Rearrange all descriptions and chart nicely plus updating it after edit more compact
•	Find a way to INCLUDE php config and making better PDF output for each session with all intervals and taken by whom
•	Timezone after edit was hour ago or after add hour from now(needs to be fixed and when add a session and edit one) – added in edit session 1 added to month
•	Using Alertify insted of jqueryUI dialogs for better design and nice responces plus log
•	Created when into take sessions so coach can see in green people who completed the session and WHEN is important, but in red those who have not completed yet
•	If you have created a session without anyone taking it (update taken by function is needed) if you edit it in the future you cannot see your athletes and of course select which will take it or not 


<article id="information" style="display:none;">The triathlon club has several qualified coaches as well as numerous athletes. Often an athlete is geographically remote from the club and needs to train by themselves. The club requires a solution that allows a coach to specify the details of a training session and to have this available to the athlete during their training. 

This project will involve the creation of a data structure to store the numerous training sessions available, a way for the coach to specify new sessions and an app which allows the athlete to select a session and receive real time information from it. 
The expectation is that this is two projects, one working on an Android application and one working on an iOS application but will be HTML5 webpage. 

<h3 id="1">Project description</h3>
<section>
The project is about making a web application for triathlon athletes who are away from the club and need to train by themselves. There will be several qualified coaches. A coach has to be able to specify the details of a training session and each athlete should be able to select a particular session and receive real time information from it. Also a coach can add and specify new sessions.

	<br />The most important which make this project worthwhile is the technology that will be used. Most of the functionality will be executed in client side, but some things will be processed on the server. Things like jQuery libraries, Ajax and basic Javascript will be used very efficiently and well implemented in the web page as well as using HTML5 language for our page(maybe and using of canvas). Probably I can use XML or JSON to for storing and exchanging session information. Also using PHP language to execute all commands needed to insert or read some information from the MySQL database.

	<br />The final version of the project should be a reliable, robust, easy to use and maintain web application. All members  will have access to the system all the times and athletes will be notified for new club information regarding their tasks.

</section>
<h3 id="2">Work to be tackled</h3>
<section>
First I need to do research in the APIs of technologies I have selected for things that will be put into use in this project. The second thing to be done is the main design of the web page. Then the registration and login function for the members of the club as well as their personal account page to check their sessions and keep track of everything. The next step is making a control panel and simultaneous updates when a session is specified by coach. The style of the page can be different on mobile devices for easier browsing and satisfaction.
</section>

<h3 id="3">Project deliverables</h3>
<section>
<ul>
<li>Good looking main page</li>
<li>Members registration and login functions</li>
<li>Personal user page</li>
<li>Control panel for coaches</li>
</ul>
</section>

</article>


</body>
</html>
