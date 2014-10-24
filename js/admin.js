// JavaScript Document
//this gets data without submit with ajax requests
//make request


function GetXmlHttpObject()
{
    var xmlHttp=null;
    try
     {
         // Firefox, Opera 8.0+, Safari
         xmlHttp=new XMLHttpRequest();
     }
    catch (e)
     {
         // Internet Explorer
         try
          {
              xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
          }
         catch (e)
          {
              xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
     }
    return xmlHttp;
}
var http=GetXmlHttpObject();
//var athletes;
function GetRemoteData()
{
var url = "enter.php?allathletes=all";
http.open("GET",url,true);
var tx;
http.onreadystatechange = function() {//Handler function for call back on state change.
    if(http.readyState == 4 && http.status==200) {		
	//athletes=JSON.parse(http.responseText);
	$("#tabs-2").html(http.responseText);
	$("input[type=button]" ).button().attr("cursor","pointer");
	tx=$("#radio option:selected").attr("name");
	$("#currentc").val(tx);
	var str=$("#radio option:selected").text();
	var n=str.split(" ");
	$("#newfirst").val(n[0]);
	$("#newlast").val(n[1]);
	$("#newyear").val($("#radio option:selected").attr('class'));
	$("#newfirst,#newlast,#newyear").click(function() {
		this.select();
	});
	$("#chdetails").attr('title',$("#radio option:selected").val());
	
$("#radio").change(function() {
	
	 tx=$("#radio option:selected").attr("name");
	 var str=$("#radio option:selected").text();
	var n=str.split(" ");
	$("#newfirst").val(n[0]);
	$("#chdetails").attr('title',$("#radio option:selected").val());
	$("#newlast").val(n[1]);
	$("#newyear").val($("#radio option:selected").attr('class'));
	$("#currentc").val(tx);
	//alertify.log($("#radio option:selected").val());
});

$("#newcoach").change(function() {
	
	 tx=$("#newcoach option:selected").attr("name");
	 var str=$("#newcoach option:selected").text();
	var n=str.split(" ");
	$("#newfirst").val(n[0]);
	$("#chdetails").attr('title',$("#newcoach option:selected").attr('title'));
	$("#newlast").val(n[1]);
	$("#newyear").val($("#newcoach option:selected").attr('class'));
	//$("#currentc").val(tx);
	//alertify.log($("#newcoach option:selected").val());
});


    }
	
	
	 $("#newyear").spinner({
step: 1,
numberFormat: "n"
});

}
http.send(null);
}

function doYouWant(){
	var rid=$("#radio option:selected").attr("id");
	var curc=$("#radio option:selected").attr("title");
	var newc=$("#newcoach option:selected").val();
	if(curc==newc){
		//$("#feedback").show().html($("#"+rid).html()+"'s coach is still "+$("#newcoach option:selected").html()+"<br />Please select another coach").effect("highlight",3000).fadeIn().hide("fast");
		alertify.error($("#"+rid).html()+"'s coach is still <br />"+$("#newcoach option:selected").html()+"<br />Please select another coach");
	}else{
		// confirm dialog
		alertify.set({ labels: {
    ok     : "Change coach",
    cancel : "Cancel"
} });
alertify.confirm("Do you want to change <strong>"+$("#radio option:selected").html()+"</strong>'s current coach("+$("#radio option:selected").attr("name")+") with new one - "+$("#newcoach option:selected").html(), function (e) {
    if (e) {
       changeCoach();
    } else {
      alertify.error("Cancelled");
    }
});

	 
	}

}

//change admin details
function myDetails(){
	var newfirst=$("#adminfirst").val();
var newlast=$("#adminlast").val();
var newyear=$("#adminyear").val();
var ademail=$("#ademail").val();
if(newfirst=="" || newfirst==" " || newfirst==null || newfirst.length<3){
	
	alertify.log("Invalid first name");
	$("#adminfirst").focus();
	return false;
}
if(newlast=="" || newlast==" " || newlast==null || newlast.length<3){
	
	alertify.log("Invalid last name");
	$("#adminlast").focus();
	return false;
}
if(newyear=="" || newyear==" " || newyear==null || isNaN(newyear) ||newyear.length<4 || newyear<1940 || newyear>2003){
	
	alertify.log("Invalid year of birth");
	$("#adminyear").focus();
	return false;
}
if (checkEmail(ademail)==false)
  {
 
 	alertify.error("This email is not valid");
 	return false;
  }
	alertify.set({ labels: {
    ok     : "Change my details",
    cancel : "Cancel"
} });
var params="changedetails=1&newfirstname="+newfirst+"&newlastname="+newlast+"&newyear="+newyear+"&ademail="+ademail;
alertify.confirm("Do you want tho change your details?", function (e) {
    if (e) {
		
	  $.post("enter.php",params, function(response){
		alertify.success(response);
	});
	   getProfile();
	 
    } else {
      alertify.error("Cancelled");
    }
});
	
}
//change user details
function changeDetails(){
//var parameters ="newcoach="+newc+"
var newfirst=$("#newfirst").val();
var newlast=$("#newlast").val();
var newyear=$("#newyear").val();
if(newfirst=="" || newfirst==null || newfirst.length<3){
	
	alertify.log("Invalid first name");
	$("#newfirst").focus();
	return false;
}
if(newlast=="" || newlast==null || newlast.length<3){
	
	alertify.log("Invalid last name");
	$("#newlast").focus();
	return false;
}
if(newyear=="" || newyear==null || isNaN(newyear) ||newyear.length<4 || newyear<1940 || newyear>2003){
	
	alertify.log("Invalid year of birth");
	$("#newyear").focus();
	return false;
}
alertify.set({ labels: {
    ok     : "Change details",
    cancel : "Cancel"
} });
var params="changedetails="+$("#chdetails").attr('title')+"&newfirstname="+newfirst+"&newlastname="+newlast+"&newyear="+newyear;
alertify.confirm("Do you want to change user details?", function (e) {
    if (e) {
		
       //alertify.success(newfirst +" "+newlast+ "<br />"+newyear,"");
	  $.post("enter.php", 
		params
	, function(response){
		alertify.success(response);
	});
	   
	   GetRemoteData();
	   
    } else {
      alertify.error("Cancelled");
    }
});

}

//change the coach
function changeCoach()
{
var url = "enter.php";
var rid=$("#radio option:selected").attr("id");
	var curc=$("#radio option:selected").attr("title");
	var newc=$("#newcoach option:selected").val();
	//else{
	//http=GetXmlHttpObject();
	var parameters ="newcoach="+newc+"&radio="+$("#radio option:selected").val();
http.open("POST",url,true);
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
http.setRequestHeader("Content-length", parameters.length);
http.setRequestHeader("Connection", "close");
http.onreadystatechange = function() {//Handler function for call back on state change.
    if(http.readyState == 4 && http.status==200) {		
		if(http.responseText=="Successfully changed coach"){
		$("#feedback").show().html("Successfully changed coach<br />"+$("#"+rid).html()+"'s new coach is "+$("#newcoach option:selected").html()).effect("highlight",3000).fadeIn().hide("fast");
		alertify.success("Successfully changed coach<br />"+$("#"+rid).html()+"'s new coach is "+$("#newcoach option:selected").html());
		setTimeout("GetRemoteData()",300);
		}else{
			$("#feedback").show().html(http.responseText).effect("highlight",3000).fadeIn().hide("fast");
		}
    }
}
http.send(parameters);

	//}
	
}
//validation the details
function validateForm(){
	
	var x=$("#firstname").val();
	var y=$("#lastname").val();
	var age=$("#age").val();
	var user=$("#user").val();
	var pass=$("#pass").val();
	var email=$("#email").val();
	var trained=$("#trained").val();
	//var y=$("#lastname").val();
	//alert(x.length);
if (x==null || x=="" || x.length<3)
  {
  $('#feedback').html("First name must be filled out with at least 3 letters");
  $('#feedback').show("fast").effect("highlight",3000).fadeIn().hide("fast");
  alertify.error("First name must be filled out with at least 3 letters");
  $('#firstname').focus();
   return false;
  }
	
	else if (y==null || y=="" || y.length<3)
  {
  $('#feedback').html("Last name must be filled out with at least 3 letters");
  $('#feedback').show("fast").effect("highlight",3000).fadeIn().hide("fast");
  alertify.error("Last name must be filled out with at least 3 letters");
  $('#lastname').focus();
 	return false;
  }
  
  else if (age>2003 || age<1940 || age==null || age=="" || isNaN(age))
  {
  $('#feedback').html("Age must be filled out with year value between 1940 and 2003");
  $('#feedback').show("fast").effect("highlight",3000).fadeIn().hide("fast");
  alertify.error("Age must be filled out with year value between 1940 and 2003");
  $('#age').focus();
 	return false;
  }
  else if (user==null || user=="" || user.length<3)
  {
  $('#feedback').html("User must be filled out with more than 2 symbols");
  $('#feedback').show("fast").effect("highlight",3000).fadeIn().hide("fast");
  alertify.error("User must be filled out with more than 2 symbols");
  $('#user').focus();
 	return false;
  }
  else if (pass==null || pass=="" || pass.length<3)
  {
  $('#feedback').html("Pass must be filled out with more than 2 symbols");
  $('#feedback').show("fast").effect("highlight",3000).fadeIn().hide("fast");
  alertify.error("Pass must be filled out with more than 2 symbols");
  $('#pass').focus();
 	return false;
  }
  else if (checkEmail(email)==false)
  {
 
 	alertify.error("Email is not valid","");
 	return false;
  }
   // confirm dialog
   alertify.set({ labels: {ok : "Add member",cancel: "Cancel"} });
alertify.confirm("Do you want to add this new member?", function (e) {
    if (e) {
        addMember();
    } else {
       alertify.error("Cancelled","");
    }
});


 return false;
  
}

function checkEmail(inputvalue){	
    var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
    if(pattern.test(inputvalue)){         
		//alert("true"); 
		return true;  
    }else{   
		//alert("false");
		return false; 
    }
}

//ADD A MEMBER INTO THE SYSTEM
function addMember()
{
	var x=$("#firstname").val();
	var y=$("#lastname").val();
	var age=$("#age").val();
	var user=$("#user").val();
	var pass=$("#pass").val();
	var email=$("#email").val();
	var trained=$("#trained").val();
	var z=$("input:checkbox:checked").val();
	//alert(z);
var url = "enter.php";
var parameters = "submit=addmember&firstname="+x+"&lastname="+y+"&age="+age+"&user="+user+"&pass="+pass+"&email="+email;
 if(z=="on"){
  parameters=parameters+"&coach="+z;
  }else{
	  parameters=parameters+"&trained="+trained;
  }
var http=GetXmlHttpObject();
http.open("POST",url,true);
//Send the proper header information along with the request
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
http.setRequestHeader("Content-length", parameters.length);
http.setRequestHeader("Connection", "close");
http.onreadystatechange = function() {//Handler function for call back on state change.
    if(http.readyState == 4 && http.status==200) {
		$('#feedback').html(http.responseText);
		alertify.success(http.responseText);
  		$('#feedback').show("fast").fadeIn().hide("fast");
		setTimeout("GetRemoteData()",400);
		$('#resetform').click();
    }
}
http.send(parameters);


}

//remove a member
function removeMember(m){
	
	var removemember;
if(m==0){
removemember=$("#cradios option:selected");
}else{
removemember=$("#aradios option:selected");
}
var info=removemember.html();
alertify.set({ labels: {ok : "Remove",cancel: "Cancel"} });
alertify.confirm("Do you want to remove <strong>"+info+"</strong> ?", function (e) {
    if (e) {
        //alertify.log(removemember.attr('label'));
$("input[name='rradio']:checked").val();
$.post("enter.php","removemember="+removemember.val()+"&memberusername="+removemember.attr('title'), function(response){ 
$("#feedback").show().html(response).effect("highlight",3000).fadeIn().hide("fast");
alertify.log(response);
});
    } else {
       alertify.error("Cancelled");
    }
});

/*{else{
	$("#feedback").show().html("Please select a member").effect("highlight",3000).fadeIn().hide("fast");
}*/
}

//remove sessions
function removeSessions(){
	  var params="removesessions=yes";//;
	  alertify.set({ labels: {ok : "Remove All",cancel: "Cancel"} });
alertify.confirm("Do you want to remove all sessions from the database ?", function (e) {
    if (e) {
        $.post("enter.php",params, function(response){ alertify.alert(response); });
    } else {
       alertify.error("Action Cancelled");
    }
});

}
//make reports
function makeReports(){
	//var csessions=$("#csessions input:not(:button,:reset),#addmember").serialize();
	 //var params="getallsessions=me"//"makeit=nice";//;
	 $.get("enter.php?getallsessions=me", function(response){ 
	 alertify.set({ labels: {ok     : "Okay"} });
	 alertify.alert("Successfully Created file for All Sessions");
	 });
		
		$("#pdf").attr("href","AllInfo.pdf").show();
}

//get user's profile data
var adminuser='';
function getProfile(){
	 //usa='';
	var par="userinfo=administrator";
	$.post("enter.php",par
	, function(response){
			adminuser=JSON.parse(response);
		});
		showProfile();
}
		


$(document).ready(function() {
 $("summary").append("Using: "+BrowserDetect.browser+" "+BrowserDetect.version+" on "+BrowserDetect.OS);

 	GetRemoteData();
	 getProfile();
	//$("#currentc").html($("#radio option:selected").attr("name"));
	 
//$("#cradios, #aradios").buttonset();
$("#coach").button();
$("#coach").change(function() {
	$("#trainedp").slideToggle();
});

	$("#tabs").tabs({active:0});
//,hide: { effect: "drop", duration: 500 },show: { effect: "blind", duration: 500 }
$("#age").spinner({
step: 1,
numberFormat: "n"
});
	
$("#radio").change(function() {
	 //$("#radio option:selected").attr("name"));
	 
	 tx=$("#radio option:selected").attr("name");
	 //alert(tx);
	$("#currentc").html(tx);
	
});

});  

function redir(){
	
	document.location.href="index.php";
	
}

//shows admin profile
function showProfile(){
	//alert(adminuser.firstName);
	document.getElementById("adminname").innerHTML=adminuser.firstName+ " "+adminuser.lastName;
	var tyear=new Date();
	 
	 var nm=adminuser.age;
	 var whatyear=tyear.getFullYear()-nm;
	 document.getElementById("adminage").innerHTML=whatyear+" years old";
	 $('#adminyear').val(adminuser.age);
	  $('#adminfirst').val(adminuser.firstName);
	   $('#adminlast').val(adminuser.lastName);
	   $('#ademail').val(adminuser.email);
	document.getElementById("adminemail").innerHTML=adminuser.email;
	$("#adminyear").spinner({
step: 1,
numberFormat: "n"
});
}

function check_username(){

	var username = $("#user").val();
	if(username.length >= 3){
		$('#Loading').show();
		$.post("enter.php", {
			isuser: $('#user').val(),
		}, function(response){
			$('#Info').fadeOut();
			 $('#Loading').hide();
			 if(response=='<div id="Error">Already Taken</div>'){
	  			//alert("nice zaeto");
				$("#user").val('');
				$("#user").focus();
				
  			 }
			setTimeout("finishAjax('Info', '"+escape(response)+"')", 500);
		});
		return false;
	}else{
		alertify.error("Username should be at least 3 symbols");
		$("#user").select();
		
	}
}

function finishAjax(id, response){
 
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn(1000);
} 
//browser detect function very useful!!!
//this code comes from - http://www.quirksmode.org/js/detect.html	
	var BrowserDetect = {
	init: function () {
		this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
		this.version = this.searchVersion(navigator.userAgent)
			|| this.searchVersion(navigator.appVersion)
			|| "an unknown version";
		this.OS = this.searchString(this.dataOS) || "an unknown OS";
	},
	searchString: function (data) {
		for (var i=0;i<data.length;i++)	{
			var dataString = data[i].string;
			var dataProp = data[i].prop;
			this.versionSearchString = data[i].versionSearch || data[i].identity;
			if (dataString) {
				if (dataString.indexOf(data[i].subString) != -1)
					return data[i].identity;
			}
			else if (dataProp)
				return data[i].identity;
		}
	},
	searchVersion: function (dataString) {
		var index = dataString.indexOf(this.versionSearchString);
		if (index == -1) return;
		return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
	},
	dataBrowser: [
		{
			string: navigator.userAgent,
			subString: "Chrome",
			identity: "Chrome"
		},
		{ 	string: navigator.userAgent,
			subString: "OmniWeb",
			versionSearch: "OmniWeb/",
			identity: "OmniWeb"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari",
			versionSearch: "Version"
		},
		{
			prop: window.opera,
			identity: "Opera",
			versionSearch: "Version"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		},
		{		// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 		// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		}
	],
	dataOS : [//symbian is added by me for my nokia 500 :)
			 {
			string: navigator.platform,
			subString: "Symbian",
			identity: "Symbian"
		},
		{
			string: navigator.platform,
			subString: "Win",
			identity: "Windows"
		},
		{
			string: navigator.platform,
			subString: "Mac",
			identity: "Mac"
		},
		{
			   string: navigator.userAgent,
			   subString: "iPhone",
			   identity: "iPhone/iPod"
	    },
		{
			string: navigator.platform,
			subString: "Linux",
			identity: "Linux"
		}
	]

};
BrowserDetect.init();