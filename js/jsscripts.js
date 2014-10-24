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
var user;
function GetRemoteData(cname)
{
var url = "enter.php";
var parameters = "userinfo="+cname;
http.open("POST",url,true);
//Send the proper header information along with the request
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
http.setRequestHeader("Content-length", parameters.length);
http.setRequestHeader("Connection", "close");
 
http.onreadystatechange = function() {//Handler function for call back on state change.
    if(http.readyState == 4 && http.status==200) {
		
	user=JSON.parse(http.responseText);
	//alert(http.responseText);
	var act=1;
	  $("#mySessions").slideUp("fast",function() {
	 		
			if(user.coach==1){
				 makeMenu(1);
				 getSessions("sessions",user.username);
				 getAthletes();
				 
				 act=4;
				
			}else{
				 makeMenu(0);
				 getSessions("mysessions",user.id);
				 $("#readytostart").before('<button id="swimfeedback" onClick="sendFeedback()" style="display:none;">I completed it</button>');
			}
			 showLogin();
			 $("#whois").html(user.firstName);//,hide: { effect: "fold", duration: 500,show: { effect: "blind", duration: 500} }
			 $("#tabs").tabs({active:act});
	 		
		 getProfile();
		 $("table").slideDown("fast");
         });
	}
}
http.send(parameters);

}
 //var ss = $.Event("click");
 	 //$("li a#theprofile").trigger( ss );
//validate edit or add sessions
function validateFields(fo){
	var not=true;
	//but basicly it is going to check all fields in the edit or add session form
	if(fo=="add"){
	 
	var dist=$( "#distance ").val();
	var dsk=$( "#description ").val();
		 if ( dsk=="" || dsk==null || dsk==" "){
		alertify.error("Description is empty");
		 not=false;
		$( "#description ").focus();
		 return not;
		 }
		 if (dist<0 || dist=="" || isNaN(dist)){
		alertify.error("Distance is empty or not a number");
		 not=false;
		$( "#distance ").focus();
		 return not;
		 }
		for(var z=1;z<=ints;z++){
			if ($( "[name='description" + z+ "']").val()=="" || $( "[name='description" + z+ "']").val()==" "){
				alertify.error($( "[name='description" + z+ "']").attr('name')+"  is empty");
				$( "[name='description" + z+ "']").focus();
				not=false;
				return not;
			}
		
			if ($( "[id='duration" + z+ "']").val()==0 || $( "[id='duration" + z+ "']").val()=="" || isNaN($( "[id='duration" + z+ "']").val())){
				alertify.error($( "[id='duration" + z+ "']").attr('id')+"  is empty or is not a number");
				$( "[id='duration" + z+ "']").focus();
				not=false;
				return not;
			}
			 
		}
		
	return not;
	
	}
	if(fo=="edit"){
	
	var dist=$( "#edistance ").val();
	var dsk=$( "#edescription ").val();
		 if (dsk=="" || dsk==null || dsk==" "){
		alertify.error("Description is empty");
		 not=false;
		$( "#edescription ").focus();
		 return not;
		 }
		 if (dist<0 || dist=="" || isNaN(dist)){
		alertify.error("Distance is empty or not a number");
		 not=false;
		$( "#edistance ").focus();
		 return not;
		 }
		for(var z=1;z<=eints;z++){
			if ($( "[name='edescription" + z+ "']").val()=="" || $( "[name='edescription" + z+ "']").val()==" "){
				alertify.error($( "[name='edescription" + z+ "']").attr('name')+"  is empty");
				$( "[name='edescription" + z+ "']").focus();
				not=false;
				return not;
			}
		
			if ($( "[id='eduration" + z+ "']").val()==0 || $( "[id='eduration" + z+ "']").val()=="" || isNaN($( "[id='eduration" + z+ "']").val())){
				alertify.error($( "[id='eduration" + z+ "']").attr('id')+"  is empty or is not a number");
				$( "[id='eduration" + z+ "']").focus();
				not=false;
				return not;
			}
			 
		}
	
	 return not;
	}
}


function showTheSessions(){

if(user.coach==1){
	
	coachSessions();
}
else{
athleteSessions();	
}
	
}

function makeMenu(id){
	//$('#menu').empty();
	if(id==1){
	$('<li><a id="sessions" href="#tabs-1" onclick="coachSessions()">My Sessions</a></li><li><a id="athletes" href="#tabs-2" onclick="showAthletes()">My Athletes</a></li><li><a id="addnewsession" href="#tabs-3">New Session</a></li><li><a id="editsession" href="#tabs-4">Edit Session</a></li><li><a href="#tabs-5" id="theprofile" onclick="getProfile()">My Profile</a></li>').appendTo('#menu');
	
	$( "#cathletes" ).buttonset();
	}else{
		$('<li><a id="sessions" href="#tabs-1" onclick="athleteSessions()">My Sessions</a></li><li><a href="#tabs-5" id="theprofile" onclick="getProfile()">My Profile</a></li>').appendTo('#menu');
		
	}
	 $( "#tabs" ).show("fast");
	//$( "a,input[type=reset]" ).button().attr("cursor","pointer");
	
}

var options;
var data;
var chart;
$(document).ready(function() {

	 $("summary").append("Using: "+BrowserDetect.browser+" "+BrowserDetect.version+" on "+BrowserDetect.OS);
	$("input[type=submit],input[type=reset]").button();
	
	$("#distance,#edistance").spinner({
 min: 0.050,
 step: 0.050

});

//$( "#theprofile" ).draggable({ containment: "parent" });
//$( "#addsession" ).draggable({ containment: "#tabs-3", scroll: false });

	 $("#duration1,#eduration1").spinner({
 spin: function( event, ui ) {
	 //alert($( this ).val());
	 var dval=ui.value-Math.floor(ui.value);
	var dvals=dval.toFixed(2);
if ( dvals > 0.59 && dvals < 0.61) {
$( this ).spinner( "value", Math.round(ui.value) );
return false;
} else if ( dvals <= 0.99 && dvals >= 0.61 ) {
$( this ).spinner( "value", ui.value-1+0.60 );
return false;
}
},min: 0.01,
 step: 0.01

});

 var shortly = new Date();
 var short = new Date();
 $('#short').countdown({since:short, onTick: watchCountup}).countdown('pause').hide("fast");
 $('#shortly').countdown({until:shortly, onTick: watchCountdown}).countdown('pause').hide("fast"); 
 $('#myathletes').hide("fast");
 //$('#addsession input:checkbox').click(changeChecks);

 $('#pausethis').click(function() {
 var paus=$('#pausethis').text();
 if(paus=="Pause"){
	 alertify.error("Session is paused");
 	$('#short').countdown('pause'); 
    $('#shortly').countdown('pause'); 
	$('#pausethis').text('Resume');
	}else{
	alertify.error("Session is resumed");
	$('#short').countdown('resume'); 
    $('#shortly').countdown('resume'); 
	$('#pausethis').text('Pause');
	}
	}); 
	
	$( "#editthis" ).button();
$('#startthis').click(function() {
		
	  alertify.set({ labels: {
    ok     : "Start",
    cancel : "Cancel"
} });
	 alertify.confirm("Dou you want to start this session?", function (e) {
    if (e) {
        alertify.success("Session started");
		
		$('#startthis').hide("fast");	//$(this).disable();
	$('#pausethis').show("fast");
	
	//$( "#tabs" ).tabs("disable");
		//$('#sessions').unbind('click');
		per=parseInt(getSD(sessions[getWhich()].duration));
		allsec=parseInt(getSD(sessions[getWhich()].duration));
		 console.log("Session duration in seconds:"+per);
		 $("#sound").attr("src","./sounds/comeon."+getAudioType());
	 document.getElementById("sound").play();
	 allsec=100/(allsec/30);
		per=per-30;
		//alert($("link[rel=stylesheet]").attr("href"));
	
	$('#countup').show("fast");
	var short = new Date();
	$('#short').countdown('resume').countdown('option', {since: short,format: 'HMS',onTick: watchCountup}); 
    $('#shortly').countdown('resume').countdown('option', {until: +getSD(sessions[getWhich()].duration),format: 'HMS',onTick: watchCountdown, onExpiry:liftOff}); 
		
		
    } else {
        alertify.error("Canceled");
    }
});

 getAudioType();
});  
 


function liftOff() { 
$("#sound").attr("src","./sounds/time_up."+getAudioType());
	 document.getElementById("sound").play();
	 backChart();
	 $( "#progressbar" ).val(100);
  sendFeedback();
  $('#shortly').countdown('destroy');
  $('#short').countdown('destroy');
} 
 var z=30;
 var per;
 var allsec;
 var prval=0;
	//p=p-z;
//Countdown which changes left time
function watchCountdown(periods) { 
//if(periods[5]==0 && periods[6]==4){changeChart();alert(getChart()+"change the chart to second task");}
	//if(periods[5]==0 && periods[6]==7){alert("change it to third task");}
	if(periods[5]>1){$('#monitor').text('Left: ' + periods[5] + ' minutes and ' + periods[6]+' seconds'); }
    if(periods[5]==1){$('#monitor').text('Left: ' + periods[5] + ' minute and ' + periods[6]+' seconds'); }
	if(periods[5]==0){$('#monitor').text('Left: ' +periods[6]+' seconds'); } 
	
	if ($.countdown.periodsToSeconds(periods) == per) {  
	   	nextChart();
		
		prval=prval+allsec;
		$( "#progressbar" ).val( prval );
		per=per-z;
		
	//setTitle(sessions[getWhich()].intervals[intnow].duration*60);
    } 
	 
}

function getFirst(){
	return parseInt(sessions[getWhich()].intervals[0].duration*60);
}

//which interval
var intnow=0;
function getIntNow(){
	return intnow;
}

function setIntNow(){
	 intnow++;
}
//Countdown which changes gone time
var soundplayed=180;
function watchCountup(periods) { 
	 
	
	 if ($.countdown.periodsToSeconds(periods)==how) { 
		console.log("interval now is :"+getIntNow());
		setIntNow();
		console.log("interval "+getIntNow()+" at "+how);
		how=how+getSD(sessions[getWhich()].intervals[getIntNow()].duration);
		console.log("interval "+getIntNow()+" at "+how);
		//var intdesc=sessions[getWhich()].intervals[getIntNow()].description+ " at "+getLevel(sessions[getWhich()].intervals[getIntNow()].level)+" level for "+getNiceDuration(sessions[getWhich()].intervals[getIntNow()].duration));
		$( "#sessiondist" ).html(sessions[getWhich()].distance+" kilometers");
		$( "#intervaldesc" ).html(sessions[getWhich()].intervals[getIntNow()].description);
		$( "#intervaltitle" ).html(sessions[getWhich()].type+" at "+getLevel(sessions[getWhich()].intervals[getIntNow()].level)+" level for "+getNiceDuration(sessions[getWhich()].intervals[getIntNow()].duration));
		/*$(function(){
		options.title=sessions[getWhich()].type+" at "+getLevel(sessions[getWhich()].intervals[getIntNow()].level)+" level for "+getNiceDuration(sessions[getWhich()].intervals[getIntNow()].duration);
		
		});
		//document.getElementById("intervaldesc").innerHTML=inntd;
		/*if(how==ll){
			document.getElementById("sound").play();
		ll=ll+20;
		}*/
	} else if ($.countdown.periodsToSeconds(periods)==soundplayed) { 
	console.log("when sound is played in seconds:"+soundplayed);
	 	document.getElementById("sound").play();
		soundplayed=soundplayed+180;
	 }
	
	if(periods[5]==0){$('#countup').text('Gone: ' +periods[6]+' seconds'); return;} 
	 if(periods[5]==1){$('#countup').text('Gone: ' + periods[5] + ' minute and ' + periods[6]+' seconds'); return;}
	if(periods[5]>1){$('#countup').text('Gone: ' + periods[5] + ' minutes and ' + periods[6]+' seconds'); return;}
}
//end
  });

  function getSome(){
  var loclev=sessions[getWhich()].intervals[getIntNow()].level;
   var some=loclev+getLevel(sessions[getWhich()].intervals[getIntNow()].level)+" level for ";//+getNiceDuration(sessions[getWhich()].intervals[getIntNow()].duration)+"";
  options.title=some;
  //return some;
  }
  
//sum all durations from intervals we have
function sumit(durrr){
	var vals=0;
	var left=0;
	$( 'input[id^="'+durrr+'"]' ).each(function( index ) {
console.log( index + ": " + $(this).val() );
var l=$(this).val()-Math.floor($(this).val());
left=left+l;
vals=vals+Math.floor($(this).val());
});
left=left*100;
if(left>59){
	var k=left/60;
	k=Math.floor(k);
	var n=left-k*60;
	n=n.toFixed();
	var al=vals+k;
console.log(al+" minutes and "+n+" seconds");
 var s=n/100;
	return parseFloat(al+s);
	}else{
		console.log(vals+" minutes and "+left.toFixed()+" seconds");
		
		return parseFloat(vals+left.toFixed()/100);
	}
	
}
//send feedback to the database
function sendFeedback(){
	 
	 var params="completedby="+user.id+"&sid="+sessions[whichchart].id;//;
	 $.post("enter.php",params, function(response){ 
	 alertify.set({ labels: {ok : "Thank you"} });
	 alertify.alert(response);
	  });
	   getSessions("mysessions",user.id);
}

var stopDef = function(e) {
if (e && e.preventDefault)
  e.preventDefault();
else if (window.event && window.event.returnValue)
  window.eventReturnValue = false;
};


 var ints=1;

function addIntervals(i){
 	 
		 ints++;
	 $('#addfields').before('<section id="interval'+ints+'">Interval '+ints+'<br />Description:<p><textarea name="description'+ints+'" size="20" value="" placeholder="some interval description"></textarea></p><p>Duration:<input type="text" id="duration'+ints+'" name="duration'+ints+'" size="3" placeholder="2.56" /> </p><p>Level:<select type="text" name="level'+ints+'" size="1"><option selected="selected" value="1">Level 1</option><option value="2">Level 2</option><option value="3">Level 3</option><option value="4">Recovery</option><option value="5">Aerobic</option><option value="6">Advanced Aerobic</option><option value="7">Anaerobic Threshold</option><option value="8">VO2 Max</option><option value="9">Speed</option><option value="10">Sprint</option></select></p></section>');
	 $("#intervals").val(ints);
	$("#duration"+ints).spinner({
 spin: function( event, ui ) {
	 //alert($( this ).val());
	 var dval=ui.value-Math.floor(ui.value);
	var dvals=dval.toFixed(2);
if ( dvals > 0.59 && dvals < 0.61) {
$( this ).spinner( "value", Math.round(ui.value) );
return false;
} else if ( dvals <= 0.99 && dvals >= 0.61 ) {
$( this ).spinner( "value", ui.value-1+0.60 );
return false;
}
},min: 0.01,
 step: 0.01

});

}

 var eints=1;
function addEditIntervals(where,i){
		
		  eints++;
		//alert("Edit Intervals:"+eints);
		if(where=="new"){
			$('#editfields').before('<section id="einterval'+eints+'">Interval '+eints+'<br />Description:<p><textarea name="edescription'+eints+'" size="30" value=""></textarea></p><p>Duration:<input type="text" id="eduration'+eints+'" name="eduration'+eints+'" size="3" value="0" /> </p><p>Level:<select type="text" name="elevel'+eints+'" id="elevel'+eints+'" size="1"><option value="1" selected="selected">Level 1</option><option value="2">Level 2</option><option value="3">Level 3</option><option value="4">Recovery</option><option value="5">Aerobic</option><option value="6">Advanced Aerobic</option><option value="7">Anaerobic Threshold</option><option value="8">VO2 Max</option><option value="9">Speed</option><option value="10">Sprint</option></select></p></section>');
	 $("#eintervals").val(eints);
	 $("#eduration"+eints).spinner({
 spin: function( event, ui ) {
	 //alert($( this ).val());
	 var dval=ui.value-Math.floor(ui.value);
	var dvals=dval.toFixed(2);
if ( dvals > 0.59 && dvals < 0.61) {
$( this ).spinner( "value", Math.round(ui.value) );
return false;
} else if ( dvals <= 0.99 && dvals >= 0.61 ) {
$( this ).spinner( "value", ui.value-1+0.60 );
return false;
}
},min: 0.01,
 step: 0.01

});

		}else{
		 $('#editfields').before('<section id="einterval'+eints+'">Interval '+eints+'<br />Description:<p><textarea name="edescription'+eints+'" size="30" value="">'+sessions[i].intervals[eints-1].description+'</textarea></p><p>Duration:<input type="text" id="eduration'+eints+'" name="eduration'+eints+'" size="3" value="'+sessions[i].intervals[eints-1].duration+'" /> </p><p>Level:<select type="text" name="elevel'+eints+'" id="elevel'+eints+'" size="1"><option value="1">Level 1</option><option value="2">Level 2</option><option value="3">Level 3</option><option value="4">Recovery</option><option value="5">Aerobic</option><option value="6">Advanced Aerobic</option><option value="7">Anaerobic Threshold</option><option value="8">VO2 Max</option><option value="9">Speed</option><option value="10">Sprint</option></select></p></section>');
	 $("#eintervals").val(eints);
	 $("#eduration"+eints).spinner({
 spin: function( event, ui ) {
	 //alert($( this ).val());
	 var dval=ui.value-Math.floor(ui.value);
	var dvals=dval.toFixed(2);
if ( dvals > 0.59 && dvals < 0.61) {
$( this ).spinner( "value", Math.round(ui.value) );
return false;
} else if ( dvals <= 0.99 && dvals >= 0.61 ) {
$( this ).spinner( "value", ui.value-1+0.60 );
return false;
}
},min: 0.01,
 step: 0.01

});
	
	 $('#elevel'+eints+'').val(sessions[i].intervals[eints-1].level);
		}
	 	
}

function delIntervals(where){
	
	if(where=="addfields"){
	  if(ints!=1) {//...се проверява дали i е различно от 1(за да може винаги да има поне 1 поле)
	   
	  $('section[id="interval'+ints+'"]').remove();//...label-а,input-a и <br />-то се премахват
	  ints--;//броя на полетата намалява с 1...
	   $("#intervals").val(ints);
	  }
	   return false;
	}else{
		 if(eints!=1) {//...се проверява дали i е различно от 1(за да може винаги да има поне 1 поле)
	   
	  $('section[id="einterval'+eints+'"]').remove();//...label-а,input-a и <br />-то се премахват
	  eints--;//броя на полетата намалява с 1...
	   $("#eintervals").val(eints);
	  }
	   return false;
		
	}
}

function makeChart(i){
	//alert(sessions[i].intervals.length);
//$('#startthis').show("fast");
//if(sessions[i].type!="swimming"){
data=new google.visualization.DataTable();
data.addColumn('number', 'Duration');
data.addColumn('number', 'Level');
//data.addColumn({type:'string', role:'annotation'}); // annotation role col.
//data.addColumn({type:'string', role:'annotationText'}); // annotationText col.
var durs=new Array();
var len=sessions[i].intervals.length;
data.addRows(len*2);
for(var w=0;w<len;w++){
	 
	durs[w]=getSecond(sessions[i].intervals[w].duration);
	console.log("Interval "+w+" duration:"+durs[w]);
	//alertify.log("Interval "+w+" duration:"+durs[w]);
}

var bef=0;
var c=2;
w=0;
for(var w=0;w<len;w++){

//var d2=sessions[i].intervals[1].duration;
//var d3=sessions[i].intervals[2].duration;
//console.log("durs0"+durs[0]);
if(w==0){
data.setCell(0, 0, 0,sessions[i].intervals[0].description);
data.setCell(0, 1, sessions[i].intervals[0].level);
data.setCell(1, 0, parseFloat(durs[0]),sessions[i].intervals[0].description);
data.setCell(1, 1, sessions[i].intervals[0].level);
bef=parseFloat(durs[0]);
console.log("first in chart: "+bef);
//alertify.log("first in chart: "+bef);
}
else{
	console.log("first in: "+bef);
data.setCell(c, 0, bef,sessions[i].intervals[w].description);
data.setCell(c, 1, sessions[i].intervals[w].level);
bef=bef+parseFloat(durs[w]);
console.log("second in chart: "+bef);
//alertify.log("second in chart: "+bef);
data.setCell(c+1, 0, bef,sessions[i].intervals[w].description);
data.setCell(c+1, 1, sessions[i].intervals[w].level);

c=c+2;
}
/*
else if(w!=0 && w==len-1){
	bef=bef+parseFloat(durs[w]);
data.setCell(c, 0, parseFloat(durs[w]),sessions[i].intervals[w].description);
data.setCell(c, 1, sessions[i].intervals[w].level);
data.setCell(c+1, 0, parseFloat(durs[w])+bef,sessions[i].intervals[w].description);
data.setCell(c+1, 1, sessions[i].intervals[w].level);

c=c+2;
}
data.setCell(3, 0, sessions[i].intervals[1].duration+d1,sessions[i].intervals[1].description);
data.setCell(3, 1, sessions[i].intervals[1].level);

data.setCell(4, 0, sessions[i].intervals[1].duration+d1,sessions[i].intervals[2].description);
data.setCell(4, 1, sessions[i].intervals[2].level);
data.setCell(5, 0, sessions[i].intervals[2].duration+d1+d2,sessions[i].intervals[2].description);
data.setCell(5, 1, sessions[i].intervals[2].level);*/
//$("#test1").show().append("<br />"+bef);

}
 var viewport = {
    width  : $(window).width(),
    height : $(window).height()
};
var wd=viewport.width;
if(viewport.width>700){
	wd=700;
}
        options = {
			height:500,width:wd,
          animation: {
        duration: 1000,
        easing: 'in'
      },
      hAxis: {title: 'Duration', titleTextStyle: {color: 'red'},viewWindow: {min:0, max:getChart()}},vAxis:{title:'Level',  titleTextStyle: {color: 'blue'},viewWindow: {min:0, max:10}}
        };
	
	chart = new google.visualization.AreaChart(document.getElementById('good'));
	chart.draw(data, options);
	$("#good").click(function() {
		
		myClick();
		
	});
	
	//}//end if
}


function myClick(){
  //var selection = chart.getSelection();
chart.setSelection([{row:2,column:1},{row:3, column:null}])
/*var message;
  for (var i = 0; i < selection.length; i++) {
    var item = selection[i];
    if (item.row != null && item.column != null) {
      message += '{row:' + item.row + ',column:' + item.column + '}';
    } else if (item.row != null) {
      message += '{row:' + item.row + '}';
    } else if (item.column != null) {
      message += '{column:' + item.column + '}';
    }
  }
  if (message == '') {
    message = 'nothing';
  }
  alert('You selected ' + message);*/
}

 
 function continueChart(){
	//$("#test").html("chart is changed with 0.5");30seconds
       options.hAxis.viewWindow.min += 0.5;
      options.hAxis.viewWindow.max += 0.5;
	   drawit();
}

function nextChart(){
	//$("#test").html("chart is changed with 0.05"); aka 12seconds
       options.hAxis.viewWindow.min += 0.5;
      options.hAxis.viewWindow.max += 0.5;
	   drawit();
}
	
function backChart(){
       options.hAxis.viewWindow.min -= getChart();
      options.hAxis.viewWindow.max -= getChart();
	   drawit();
}
	
function drawit(){
chart.draw(data, options);
}
//get user's profile data
function getProfile(){
	
	document.getElementById("cname").innerHTML=user.firstName+ " "+user.lastName;
	//document.getElementById("last").innerHTML=user.lastName;
	document.getElementById("email").innerHTML=user.email;
	var thisyear=new Date();
	var whatage=thisyear.getFullYear()-user.age;
	 document.getElementById("cage").innerHTML=whatage+" years old";
	document.getElementById("mypic").src="./images/"+user.picture;
	//document.getElementById("mypic").title=user.firstName+ " "+user.lastName+ " at "+user.whatage+" years old";
	//var ageyear=new Date();
	//ageyear.setYear(user.age);
	
	 //alert($( "#profileinfo tr:first td:last" ).text());
	if(user.trained_by!="nobody"){
	document.getElementById("mycoach").innerHTML=user.mycoach;
	}else{
		//if($( "#profileinfo tr:first td:last" ).text()=="My Coach"){
		//$( "#profileinfo dt:last" ).remove();
		 $( "#colabel" ).remove();
		$( "#mycoach" ).remove();
		//}
		
	}
	   //completedSessions();
	   $( "button,input[type=file]" ).button();
	   //$("#browsefile").val(user.id);
	   $( "#profileinfo" ).show("fast");
}


 /*function completedSessions(){
var uncompl=0;
		for(var w=0;w<sessions.length;w++){
			if(sessions[w].completed==0){
			uncompl++;
			}
		}
		if(uncompl=>0){
		$.titleAlert('('+uncompl+') New Sessions', {interval:1200});
		}

}*/
//session for a coach
function coachSessions(){
	 
	 if(sessions.length==0){
		 $( "#mySessions" ).hide("fast");
		  alertify.set({ labels: {ok : "OK"} });
		  alertify.log("You do not have sessions yet");
		 return false;
	 }
	 var i;
	  
  $("#mySessions").empty();
  /*if($("#good,#readytostart").css("display")=="none"){
 $("#good,#readytostart").show("fast");
  }else{
	  $("#good,#readytostart").hide("fast");
  }
    //$("#good,#readytostart").hide("fast");
	*/
 var html='<tr><td></td><td></td><td></td><td>Type</td><td>Intervals</td><td>Description</td><td>Distance</td><td>Duration</td><td>Added</td></tr>';
 $(html).appendTo("#mySessions");
 var shor;
for (i=0;i<sessions.length;i++){
	html='';
	 var date=sessions[i].time_added;
   	//date = date.replace(/-/g,"/");
	date = date.replace(/ /g,"T");
	var datata=new Date(date);
	shor=sessions[i].description.slice(0,20)+"..."; 
	if(sessions[i].completed==0){
		html += '<tr class="notcomplete"><td class="newsession"></td><td ><a name="' +sessions[i].id+ '" title="edit this new session" onclick="addTab('+i+')">Edit</a></td><td>';
	}else{html += '<tr class="complete"><td></td><td><a name="' +sessions[i].id+ '" onclick="addTab('+i+')" title="edit this completed session" class="edit">Edit</a></td><td>'}
	
	  html += '<a  title="view this session" onclick="seeSession('+i+')">View</a></td><td>'+
             sessions[i].type
             + '</td><td>'+sessions[i].intervals.length+' interval(s)</td><td title="'+sessions[i].description+'">'
             + shor
             + '</td><td>'
             + sessions[i].distance
			 + ' kilometers</td><td>'
			 + getNiceDuration(sessions[i].duration)
			 + '</td><td><abbr id="added'+i+'" class="timeago"></abbr></td></tr>';
			 $(html).appendTo("#mySessions");			 
  	// $('#end').countdown({since: endday,layout: '{dn} {dl},{hn} {hl},{mn} {ml}'});
	 	  $("#added"+i).attr("title", date);
	 	 //$("#added"+i).timeago();
	 }
	//$.timeago.settings.allowFuture = true;
		$(".timeago").timeago();
		hideCoach();
		$("#mySessions").show("fast");
	 	$("#coachdiv a,#editthis,tr a").button();
		
}
 //athlete sessions
 function athleteSessions(){
	 //alert(sessions[0].time_added);
	 if(sessions.length==0){
		 $( "#mySessions" ).hide("fast");
		 alertify.set({ labels: {ok : "OK"} });
		alertify.log("You do not have sessions yet");
		 return false;
	 }
	 var i;
	 //$("#mySessions").html(''); 
	 $("#mySessions").empty();	  
 var html='<tr><td></td><td></td><td>Type</td><td>Intervals</td><td>Description</td><td>Distance</td><td>Duration</td><td>Added</td></tr>';
 $(html).appendTo("#mySessions");
 var date;
 var uncomp=0;
 var shor;
	 for (i=0;i<sessions.length;i++){
		 html='';
	 date=sessions[i].time_added;
   	//date = date.replace(/-/g,"/");
	date = date.replace(/ /g,"T");
	var thedate=new Date(date);
	var datata=new Date(date);
	//enddate = enddate.replace(/ /g,"T");
	//var endday=new Date(enddate);
	shor=sessions[i].description.slice(0,20)+"..."; 
	if(sessions[i].completed==0){//<img src="./images/new-icon.png" />
		  uncomp++;
		html += '<tr class="notcomplete"><td class="newsession"></td><td ><a id="' +i+ '" onclick="startSession(this.id)">View</a></td><td>';
	}else{html += "<tr class='complete'><td></td><td></td><td>"}
	html += sessions[i].type
             + '</td><td>'+sessions[i].intervals.length+' interval(s)</td><td title="'+sessions[i].description+'">'
             + shor
             + '</td><td>'
             + sessions[i].distance
			 + ' kilometers</td><td>'		 
			 + getNiceDuration(sessions[i].duration)
			 + '</td><td><abbr id="added'+i+'" class="timeago"></abbr></td></tr>';
			 $(html).appendTo("#mySessions");
	  $("#added"+i).attr("title", date);
	 	 
	 }
	 $(".timeago").timeago();
	    hideAthlete();
		$("#mySessions").show("fast");		
		if(uncomp>0){
			//var newtitle=document.title;
		$.titleAlert('('+uncomp+') New Sessions', {interval:1500});
		}
	  $( "tr a" ).button();
	
	 //$( "#good" ).hide();
}

//return date in nice format
function getNiceDate(what){
  //var day=what.toDateString()+" at "+what.toTimeString();
return what.toString();	
}

var whichchart;
var how;
//athlete starts a session
function startSession(x){
	//$("#coachdiv").hide("fast");
	
	if(sessions[x].type=="swimming"){
		$("#sound").attr("src","./sounds/Go."+getAudioType());
	document.getElementById("sound").play();
	showAthlete();
	$("#swimfeedback").show("fast");
	whichchart=x;
	makeChart(x);
	 how=getSD(sessions[x].intervals[0].duration);
	
	 $("#sessiondist").html(sessions[getWhich()].distance+" kilometers");
	 $("#monitor").html(getNiceDuration(sessions[x].duration));
	 $( "#momentdesc" ).html(sessions[whichchart].description);
	 $( "#intervaldesc" ).html(sessions[getWhich()].intervals[0].description);
	 $( "#intervaltitle" ).html(sessions[getWhich()].type+" at "+getLevel(sessions[getWhich()].intervals[0].level)+" level for "+getNiceDuration(sessions[getWhich()].intervals[0].duration));
	 if(sessions.length>1){
	 for(var m=1;m<sessions.length;m++){
		 $( "#intervaltitle" ).append("<br />"+getLevel(sessions[getWhich()].intervals[m].level)+" level for "+getNiceDuration(sessions[getWhich()].intervals[m].duration));
	 }
	 }
	 $.titleAlert.stop();
	 }else{
	console.log(getAudioType());
	//alertify.log(getAudioType());
	$("#sound").attr("src","./sounds/Go."+getAudioType());
	document.getElementById("sound").play();
	$.titleAlert.stop();
	showAthlete();
	$("#buttons").show("fast");
	whichchart=x;
	makeChart(x);
	 how=getSD(sessions[x].intervals[0].duration);
	 $( "#sessiondist" ).html(sessions[getWhich()].distance+" kilometers");
	 $("#monitor").html(getNiceDuration(sessions[x].duration));
	 $( "#momentdesc" ).html(sessions[whichchart].description);
	 $( "#intervaldesc" ).html(sessions[getWhich()].intervals[0].description);
     $( "#intervaltitle" ).html(sessions[getWhich()].type+" at "+getLevel(sessions[getWhich()].intervals[0].level)+" level for "+getNiceDuration(sessions[getWhich()].intervals[0].duration));   
		
		
	 }
	 
	 $("#buttons a").button();
}


//coach sees a session
function seeSession(x){
	
	takenBy(sessions[x].id);
	 whichchart=x;   
	 how=getSD(sessions[x].intervals[0].duration);
	  makeChart(x);
	  showCoach();
	  
	  $( "#sessiondist" ).html(sessions[x].distance+" kilometers");
	 $("#monitor").html(getNiceDuration(sessions[x].duration));
	 $( "#momentdesc" ).html(sessions[x].description).show("fast");
	 $( "#intervaldesc" ).html(sessions[x].intervals[0].description).show("fast");
     $( "#intervaltitle" ).html(sessions[x].type+" at "+getLevel(sessions[x].intervals[0].level)+" level for "+getNiceDuration(sessions[x].intervals[0].duration));
	 
}

//hide coach items
function hideCoach(){
	 $("#coachdiv,#takenbywho,#readytostart,#good,#editthis").hide("fast");
	
}
//show coach items
function showCoach(){
	$("#mySessions").hide("fast");
	$("#coachdiv,#takenbywho,#readytostart,#good,#editthis").show("fast");
	
	
}
//shows athletes items
function showAthlete(){
	$("#mySessions").hide("fast");
	$("#readytostart,#good").show("fast");
}
//hide athlete items
function hideAthlete(){
	$("#readytostart,#good,#buttons,#swimfeedback").hide("fast");
	
}
//get duration in nice format for the chart
function getSecond(o){
	var f=Math.floor(o);
	var h=o-Math.floor(o);
	
	if(f==0){
		var se=(o*100)/60;
		//alert(se.toFixed(2));
		return se.toFixed(2);
	}else{
		h=(h*100)/60;
		var z=f+h;
	return z.toFixed(2);
	}
	
}
//get duration in seconds
function getSD(m){
	var f=Math.floor(m);
	var h=m-Math.floor(m);
	
	if(f==0){
		var se=m*100;
		//alert(se.toFixed(2));
		return se;
	}else{
		//h=(h*100)/60;
		var z=(f*60)+(h*100);
	return z;
	}
}
//get session duration in nice format for the chart
function getChart(){
	var f=Math.floor(sessions[whichchart].duration);
	var h=sessions[whichchart].duration-Math.floor(sessions[whichchart].duration);
	
	if(f==0){
		var se=(sessions[whichchart].duration*100)/60;
		//alert(se.toFixed(2));
		return se.toFixed(2);
	}else{
		h=(h*100)/60;
		var z=f+h;
	return z.toFixed(2);
	}
	
}

//get audio type of browser capabilities
function getAudioType(){
	var audio = new Audio();
	 audio.type="mp3";
    if(audio.canPlayType("audio/mp3")){
       $('#sound').attr("src","./sounds/comeon.mp3");
	   $('#sound').attr("type","audio/mp3");
	   audio.type="mp3";
	}
    else if(audio.canPlayType("audio/ogg")){
       $('#sound').attr("src","./sounds/comeon.ogg");
	   $('#sound').attr("type","audio/ogg");
	   audio.type="ogg";
	   }
	return audio.type;
}

function getWhich(){
	return parseInt(whichchart);
}
//which element we have pressed in the page
function whichElement(e)
{
var targ;
if (!e)
  {
  var e=window.event;
  }
if (e.target)
  {
  targ=e.target;
  }
else if (e.srcElement)
  {
  targ=e.srcElement;
  }
if (targ.nodeType==3) // defeat Safari bug
  {
  targ = targ.parentNode;
  }
var tname;
tname=targ.id;
return tname;

//return tname;
}

var sessions;
function getSessions(type,name){
	 //alert("by:"+name);
	 var conn=GetXmlHttpObject();
	var url = "enter.php";
var parameters = type+"="+name;
conn.open("POST",url,true);
//Send the proper header information along with the request
conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
conn.setRequestHeader("Content-length", parameters.length);
conn.setRequestHeader("Connection", "close");
conn.onreadystatechange = function() {//Handler function for call back on state change.
    if(conn.readyState == 4 && conn.status==200) {
		//alert("sessions: "+http.responseText);
	  sessions=JSON.parse(conn.responseText);	  
	 //document.getElementById("sessions").innerHTML=http.responseText;	 
    }
}
conn.send(parameters);
}

var athletes;
function getAthletes(){
	 //alert("by:"+name);
	 var conn=GetXmlHttpObject();
	var url = "enter.php";
var parameters = "athletes="+user.username;
conn.open("POST",url,true);
//Send the proper header information along with the request
conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
conn.setRequestHeader("Content-length", parameters.length);
conn.setRequestHeader("Connection", "close");
conn.onreadystatechange = function() {//Handler function for call back on state change.
    if(conn.readyState == 4 && conn.status==200) {
		//alert("sessions: "+http.responseText);
	  athletes=JSON.parse(conn.responseText);	  
	 //document.getElementById("sessions").innerHTML=http.responseText;	 
    }
}
conn.send(parameters);
$("input[type=button]").button();

}

function showAthletes(){
	
	 if(athletes.length==0){
		$( "#myathletes" ).hide("fast");
		alertify.set({ labels: {ok : "Okay"} });
		 alertify.log("You do not have assigned athletes yet");
		 //alertify.set({ buttonFocus: "ok"});
		 return false;
	 }
	 
	   $('#myathletes').empty();
	var html='';
 //$(html).appendTo("#myathletes");
 var thisyear=new Date();
 var whatage;
 var fullname;
 var g=2;
	for (var i=0;i<athletes.length;i++){
	fullname=athletes[i].firstName+' '+athletes[i].lastName;
	whatage=thisyear.getFullYear()-athletes[i].age;
	//html='';
	 html = '<p id="user'+i+'">'+fullname+'('+whatage+' years)<br /><img src="./images/'+athletes[i].picture+'" alt="picture" title="'+fullname+'" width="100" height="100" /></p>';
			 if(i==g){
				 html+='<br />';
				 g=g+2;
			 }
            /* + athletes[i].firstName
             + ' '
             + athletes[i].lastName
			 + ' - '
			 + whatage
			 + ' years old</p>';*/
	//document.getElementById("mypic").title=user.firstName+ " "+user.lastName+ " at "+user.whatage+" years old";
	 $(html).appendTo("#myathletes");
	  
	 }
	 //alert(html);
	 //$("#myathletes").show();
	// $(html).appendTo('#test');
}


//adds a session
function addSession(){
	if(validateFields('add')==false){
		return false;	
	}
	alertify.set({ buttonFocus: "ok",labels: {ok : "Add it", cancel:"Cancel"} });
	alertify.confirm("A new session will be added. You will not be able to delete it(just edit it) afterwards. Are you sure?", function (e) {
    if (e) {
       		
	var conn=GetXmlHttpObject();
	var url = "enter.php";
 var dt=new Date();
	var mn=dt.getMonth()+1;
	var dat=dt.getFullYear()+"-"+mn+"-"+dt.getDate()+" "+dt.getHours()+":"+dt.getMinutes()+":"+dt.getSeconds();
 var valArray = $('#addsession input:not(:button,:reset),#addsession textarea,#addsession select').serialize();
var parameters = "addsession="+user.username+"&"+valArray+"&alldur="+sumit("duration")+"&timeadded="+dat;
conn.open("POST",url,true);
//Send the proper header information along with the request
conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
conn.setRequestHeader("Content-length", parameters.length);
conn.setRequestHeader("Connection", "close");
conn.onreadystatechange = function() {//Handler function for call back on state change.
    if(conn.readyState == 4 && conn.status==200) {
		//alert("sessions: "+http.responseText);
		//alertify.set({ buttonFocus: "ok",labels: {ok : "Okay"} });
		alertify.success(conn.responseText);
	 	$('#success').html(conn.responseText);	
	    getSessions("sessions",user.username);
		//coachSessions();
	 //document.getElementById("sessions").innerHTML=http.responseText;	 
    }
}
conn.send(parameters);
		
    } else {
      
	  alertify.error("Canceled");
	  
    }
});

}
//edit a session
function editSession(){
	if(validateFields('edit')==false){
		return false;	
	}
	var editit=$("#editsession input:not(:button,:reset),#editsession textarea,#editsession select,#editsession hidden").serialize();
	var dt=new Date();
	var mn=dt.getMonth()+1;
	var dat=dt.getFullYear()+"-"+mn+"-"+dt.getDate()+" "+dt.getHours()+":"+dt.getMinutes()+":"+dt.getSeconds();
	//alert(dat);
 	var params = "editsession="+$("#sessionid").val()+"&"+editit+"&alldur="+sumit("eduration")+"&whenis="+dat;
	alertify.set({ buttonFocus: "ok",labels: {ok : "Change it",cancel: "Cancel"} });
	alertify.confirm("This session's information will be changed. Are you sure?", function (e) {
    if (e) {
       
	   $.post("enter.php", 
		params
	, function(response){
			//alert(params);
			$("#edittest").html(response).show();
			alertify.success(response);
			 //resetEdit();
			 getSessions("sessions",user.username);
			 //$( "#mySessions" ).empty();
			 //coachSessions();			
			 //$( "#tabs" ).tabs( "option", "active", 0 );
			 //var e = $.Event("click");
 			 //$("li a#sessions").trigger( e );
			 
		});
	   
	   
    } else {
       
	   
	   alertify.error("Cancel");
	   
    }
});	

}

function resetEdit(){
	var w = $.Event("click");
 	$("#editsession reset").trigger( w );
	//$("#editsession input,textarea,select").val('');
	
}
// function checks if there is at least one checked box - selected user
function checkbox_test() {
	
	var valArray = $('#addsession input:not(:button,:reset),textarea,select').serialize();
 return valArray;
	
}
function getDuration(d){
	return d*60;
}
function getNiceDuration(d){
	var left=d-Math.floor(d);
	if(d==1){
		return d+" minute";
	}
 	else if(left==0){
		return d+" minutes";
	}
	else if(d<1){
		 //d=d*100;
		return parseInt(d*100)+" seconds";
	}
	else{	
		return Math.floor(d)+" minutes and "+(left*100).toFixed()+" seconds";
	}
}

function getLevel(l){
	if(l==1){
		return "First (1)";
	}
	else if(l==2){
		return "Second (2)";
	}
	else if(l==3){
		return "Third (3)";
	}
	else if(l==4){
		return "Recovery (4)";
	}
	else if(l==5){
		return "Aerobic (5)";
	}
	else if(l==6){
		return "Advanced Aerobic (6)";
	}
	else if(l==7){
		return "Anaerobic Threshold (7)";		
	}
	else if(l==8){
		return "VO2 Max (8)";		
	}
	else if(l==9){
		return "Speed (9)";		
	}
	else if(l==10){
		return "Sprint (10)";		
	}
	else return "Unknown";
}
var whichsession;
function addTab(i){
	eints=1;
	$( "#edittest" ).hide();
	 $( "#editsession,#tabs-4" ).show();
	 $('section[id^="einterval"][id!="einterval1"]').remove();//...label-а,input-a и <br />-то се премахват  
	$("#eintervals").val(sessions[i].intervals.length);
	  $("select#etype option").each(function () {
		if($(this).text()==sessions[i].type) {$(this).attr("selected","selected");//$(this).prop("selectedIndex",1);
		$("select#etype").val($(this).text());
		}
	});
	$("#edescription").val(sessions[i].description);
	$("#edistance").val(sessions[i].distance);
	$("#edescription1").val(sessions[i].intervals[0].description);
	//$("#edistance1").val(sessions[i].intervals[0].distance);
	$("#eduration1").val(sessions[i].intervals[0].duration);
	$("#elevel1").val(sessions[i].intervals[0].level);
	$("#sessionid").val(sessions[i].id);
	 for(var l=1;l<sessions[i].intervals.length;l++){
	 	addEditIntervals("add",i);
		
	 }
	 takenBy(sessions[i].id);
	 
	var e = $.Event("click");
  $("#editsession").trigger( e );
	 var whichsession=$("#sessionid").val();
  $("#editfields").click(function(){addEditIntervals("new",whichsession);});
  //$("#eathletes").buttonset();
}


//determine which will be next chart to see
function seeNext(){
	var number=getWhich();
	//alertify.log(number);
	
	if(number==sessions.length-1){
		number=0;
		seeSession(number);
	}else{
		
		number++;
		seeSession(number);
	}
	
}

//determine which will be previous chart to see
function seePrev(){
	var number=getWhich();
	//alertify.log(number);
	
	if(number==0){
		number=sessions.length-1;
		seeSession(number);
	}else{
		
		number--;
		seeSession(number);
	}
	
}

//checkboxes for edit session
var takenbya;
function takenBy(i){
	var twhen='';
		$("#takenbywho").empty();
		$.post("enter.php", {
			takenby: i,
		}, function(response){
			var che=false;
			 takenbya = JSON.parse(response);
			 if(athletes.length>0){
			$("#eathletes").empty();
			$("#editthis").show();
			$("#startthis").hide();
			$("#eathletes").append("Athletes:<br />");
			for (var zw=0;zw<athletes.length;zw++){
				che=false;
				//var finishedby;
				for(var kk=0;kk<takenbya.length;kk++){
					
				if(athletes[zw].id==takenbya[kk].id){
					//$("#edittest").append("<br />"+athletes[zw].firstName+" "+athletes[zw].lastName);
					che=true;
				if(takenbya[kk].iscompleted==0){
				$("#takenbywho").append("<input type='checkbox' name='takecheck"+kk+"' disabled='disabled' /><label for='takecheck"+kk+"'  class='notcompleted'>"+athletes[zw].firstName+" "+athletes[zw].lastName+"</label><br /><img src='./images/"+athletes[zw].picture+"' width='100' height='100'/><br />");
				
				}else{
					
					twhen=takenbya[kk].whenis;
					twhen=twhen.replace(/ /g,"T");
				 $("#takenbywho").append("<input type='checkbox' name='takecheck"+kk+"' disabled='disabled' checked='checked'/><label for='takecheck"+kk+"' class='completed'>"+athletes[zw].firstName+" "+athletes[zw].lastName+" - completed <abbr title='"+twhen+"' id='taken"+kk+"'>"+takenbya[kk].whenis+"</abbr></label><br /><img src='./images/"+athletes[zw].picture+"' width='100' height='100' /><br />");
				 $("#taken"+kk).timeago();
				}
				
					continue;
				}
				
				}
				if(che==true){
				$("#eathletes").append("<input type='checkbox' name='echeck"+zw+"' id='echeck"+zw+"' checked='checked' value='"+athletes[zw].id+"' /><label for='echeck"+zw+"'>"+athletes[zw].firstName+" "+athletes[zw].lastName+"</label><br />");
				
				}else{
				
				$("#eathletes").append("<input type='checkbox' name='echeck"+zw+"' id='echeck"+zw+"' value='"+athletes[zw].id+"' /><label for='echeck"+zw+"'>"+athletes[zw].firstName+" "+athletes[zw].lastName+"</label><br />");
				}
				
			}$("#eathletes").buttonset();
		}else{//if there are no athletes
			$("#eathletes").html("You do not have athletes");
			//$("#takenbywho").append("Nobody");
			
		}
		$("#takenbywho").prepend("Taken By<br />");
		if(takenbya.length==0){
			$("#takenbywho").append("Nobody");
		}
		
		});
		
}

//user changes his email
function changeEmail(){

	alertify.set({ labels: {ok : "Change your email",cancel : "Cancel"},buttonReverse: true });
	alertify.prompt("Please type new email address", function (e, str) {
    // str is the input text
    if (e) {
		if(checkEmail(str)==true){
       
	$.post("enter.php", 
		"changeemail="+str+"&changeid="+user.id
	, function(response){
	user.email=str;
	$('#email').html(str);
	
	});
	
	alertify.success("Successfully changed email<br />Your new one is: <p>"+str+"</p>");
		}else{alertify.error("Not a valid email address"); }
	
    } else {
       alertify.log("Cancelled");
    }
}, "");
	
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

function changeUser(){

	//$("#olduser").val(user.username);
	//$('#changeuser').show('fast');
	
	alertify.set({ labels: {ok : "Change username",cancel : "Cancel"},buttonReverse: true });
alertify.prompt("Your username is:<strong>"+user.username+"</strong>.Please type new username", function (e, str) {
    // str is the input text
    if (e) {
		if(str.length>2 && str!=null){
        //var chu=$("#newuser").val();
	
	$.post("enter.php", 
		"changeuser="+str+"&changeid="+user.id+"&ifcoach="+user.coach+"&cuser="+user.username
	, function(response){
	//$('#changeuser').hide('fast');
	
	//alertify.success(responce);
	user.username=str;
	//$('#whois').html(user.);
	});
	
	alertify.success("Successfully changed username<br />Your new one is: <p>"+str+"</p>");
		}else{alertify.error("Less than 3 symbols"); }
	
    } else {
       alertify.log("Cancelled");
    }
}, "");



}


//change your picture
function changePic(){
	
	alertify.set({ labels: {ok : "Change your profile picture",cancel : "Cancel"},buttonReverse: true });
	alertify.confirm("Do you want to change your picture?(old one will be replaced)", function (e) {
    // str is the input text
    if (e) {
		
       
	$.post("index.php", 
		"myuid="+user.id
	, function(response){
	//alert(response);
	alertify.success(response);
	});
	
	alertify.success("Successfully changed picture<br />You can see now your new one<br />");
		
		//document.getElementById("formpic").submit();
		//alert("submit");
    } else {
		
       alertify.log("Cancelled");
	   return false;
    }
}, "");
	
}

//change your pass
function changePass(){

	alertify.set({ labels: {ok : "Change your password",cancel : "Cancel"},buttonReverse: true });
	alertify.prompt("Please type new password", function (e, str) {
    // str is the input text
    if (e) {
		if(str.length>2 && str!=null){
       
	$.post("enter.php", 
		"changepass="+str+"&changeid="+user.id
	, function(response){
	
	//alertify.success(responce);
	
	});
	
	alertify.success("Successfully changed password<br />Your new one is: <p>"+str+"</p>");
		}else{alertify.error("Less than 3 symbols"); }
	
    } else {
       alertify.log("Cancelled");
    }
}, "");
	
}

function showLogin(){
	
	 $("#logform").toggle();
}
function redir(){
	
	document.location.href="index.php";
	
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