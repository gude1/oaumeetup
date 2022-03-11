<?php
require "classwritestory.php";
$storywrite=$fonttype="";
$storywrite = new writestory();
if ($storywrite->validateUser() == "false") {
header("location:oaumeetuplogin.php");
exit();
}
$fonttype = $storywrite->getFont();
if (isset($_POST["story"]) && isset($_POST["colorpref"]) && isset($_POST["mode"]) && isset($_POST["title"]) && 
isset($_POST["mood"])) {
$title = $_POST["title"];
$story = $_POST["story"];
$storiescolorpref = $_POST["colorpref"];
$mode = $_POST["mode"];
$mood = $_POST["mood"];
if(empty($title)){
echo "Story doesnt have a title or mood ";
exit();
}elseif(count($story) < 1 || count($storiescolorpref) < 1) {
echo  "story is empty";
exit();
}else if(empty($mode)){
echo "mode should not be empty";
exit();
}else{
$storywrite->setStoryTitle($title);
$storywrite->setStoryContent($story);
$storywrite->setColorPref($storiescolorpref);
$storywrite->setStoryMode($mode);
$storywrite->setUserid($_SESSION["userid"]);
$storywrite->setMood($mood);
$result = $storywrite->insertStory();
if ($result == "successful") {
echo "success";
exit();
}else{
echo "could not post your story please try again ".$result;
exit();
}

}
}

?>
<!DOCTYPE html>
<html>
<head>
<title>oaumeetup|writestory</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content=" social & meetup website">
<meta name="keywords"content="Oau social website,oau meetup, oau meetup site,oau biggest social website,oau social page,oau meetup Dating stories ">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
<body style="font-family:<?php echo $fonttype;?>">
<!--mainpage-->
<div id="writestoryctn"class="w3-purple w3-bar"style="width:100%;height:100vh;margin:0;padding:0;">
<textarea id="storytextarea"class="w3-purple w3-block w3-bar-item w3-text-white w3-large w3-animate-left" style="width:70%; height:100vh;resize:none;font-size: 18px;padding:10px ;"placeholder="Type a story..."></textarea>
<div class="w3-bar-item w3-center w3-display-container"style="width:30%;height:100%;">
<button  id="prev"class="w3-round-large w3-btn w3-card-4 w3-black  w3-tiny w3-opacity w3-text-white w3-ripple w3-hover-white w3-hover-text-blue"style="width:80px;padding:4px;word-wrap:break-word;"><i class="fa fa-angle-left w3-xlarge"style=""></i>
<span class="w3-block w3-tiny">Previous</span>
</button><br><br>
<button  id="next"class="w3-round-large w3-btn w3-card-4 w3-black  w3-tiny w3-opacity w3-text-white w3-ripple w3-hover-white w3-hover-text-blue"style="width:80px;padding:4px;word-wrap:break-word;"><i class="fa fa-angle-right w3-xlarge"style=""></i>
<span class="w3-block w3-tiny">Next</span>
</button><br><br>	
<button  id="changecolor"class="w3-round-large w3-center w3-btn w3-card-4 w3-black w3-tiny w3-opacity w3-text-white w3-ripple w3-hover-white w3-hover-text-blue"style="width:80px;padding:4px;"><i class="fa fa-dashboard  w3-xlarge"style=""></i> 
<span class="w3-block w3-tiny"style="word-wrap:break-word;">Change colour</span>
</button><br><br>
<span class="w3-round-large w3-btn w3-card-4 w3-black w3-tiny w3-opacity w3-text-white w3-ripple w3-hover-white w3-hover-text-blue"style="width:90px;padding:4px;word-wrap:break-word;">
<i class="fa fa-smile-o w3-medium"></i> MOOD<br>
<select id="mood"style="width:75px;">
<option>Happy</option>
<option>Naughty</option>
<option>Tired</option>
<option>Horny</option>
<option>Cheerful</option>
<option>Angry</option>
<option>Sad</option>
</select>
</span><br><br>
<button  id="poststory"class="w3-round-large w3-center w3-btn w3-card-4 w3-black w3-tiny w3-opacity w3-text-white w3-ripple w3-hover-white w3-hover-text-blue"style="width:80px;;padding:4px;word-wrap:break-word;">
<span class="pvisible">	
<i class="fa fa-send w3-xlarge"style=""></i> 
<span class="w3-block w3-tiny"style="word-wrap:break-word;">Post Story</span>
</span>

<span class="phidden w3-hide">
<i class="fa fa-spinner w3-xlarge w3-spin"style=""></i>
<span class="w3-block w3-tiny">Posting story...</span>
</span>

</button><br><br>
<button  id="apoststory"class="w3-round-large w3-btn w3-card-4 w3-black w3-tiny w3-opacity w3-text-white w3-ripple w3-hover-white w3-hover-text-blue"style="width:80px;padding:4px;word-wrap:break-word;">
<span class="apvisible">
<i class="fa fa-send w3-xlarge"style=""></i> <i class="fa fa-eye-slash w3-xlarge"></i>
<span class="w3-block w3-tiny">Post Story <br>Anonymous</span>
</span>

<span class="aphidden w3-hide">
<i class="fa fa-spinner w3-xlarge w3-spin"style=""></i>
<span class="w3-block w3-tiny">Posting story...</span>
</span>

</button><br><br>


</div>
</div>
<!--mainpage ends here-->
<!--script for javascript starts here-->
<script type="text/javascript">
$(document).ready(function(){
var coloroption = ["w3-purple","w3-blue","w3-red","w3-yellow","w3-green","w3-pink","w3-orange","w3-teal","w3-khaki","w3-brown","w3-black"];
var count = 1;
var userstory =[];
var storycolors=[];
var changecolor,writestoryctn=storytextarea=colornow=poststory=apoststory=prev=next=mood=pvisible=phidden=
apvisible=aphidden=storyindex=promptb="";
colornow = "w3-purple";
storyindex = 0;
changecolor = $("#changecolor");
writestoryctn = $("#writestoryctn");
storytextarea = $("#storytextarea");
poststory = $("#poststory");
apoststory = $("#apoststory");
pvisible = $(".pvisible");
phidden = $(".phidden");
apvisible = $(".apvisible");
aphidden = $(".aphidden");
mood = $("#mood");
prev = $("#prev");
next = $("#next");
promptb = false;
//function to handle changing of colors starts here
changecolor.click(function() {
if(count > (coloroption.length -1)){
count = 0;
}
colornow = coloroption[count];
if (userstory[storyindex] != undefined) {storycolors[storyindex] = colornow;}
writestoryctn.attr("class",colornow +" w3-bar");
storytextarea.attr("class",colornow +" w3-block w3-bar-item w3-text-white w3-large");
count++;
});
//code for saving users story as typing
storytextarea.on({
change :function(){
var storytext = storytextarea.val();
if (storytext != "") {
userstory[storyindex] = storytext;
storycolors[storyindex] = colornow;
}
},
click :function(){
var storytext = storytextarea.val();
if (storytext != "") {
userstory[storyindex] = storytext;
storycolors[storyindex] = colornow;
}},
keydown : function(){
var storytext = storytextarea.val();
if (storytext != "") {
userstory[storyindex] = storytext;
storycolors[storyindex] = colornow;
}
//console.log(userstory + " "+storycolors);
}
});

/*code for switching between slides starts here*/
prev.click(function(){
if(storyindex != 0 && !(storyindex < 0)){
storytextarea.addClass("w3-hide");	
storyindex--;
var storytext = userstory[storyindex];
colornow = storycolors[storyindex];
writestoryctn.attr("class",colornow +" w3-bar");
storytextarea.val(storytext).attr("class",colornow +" w3-block w3-bar-item w3-animate-left w3-text-white w3-large");
//console.log(userstory + " "+storycolors);
}
});

next.click(function(){
var storytext = storytextarea.val();
if (storytext != "") {
storytextarea.addClass("w3-hide");	
userstory[storyindex] = storytext;
storycolors[storyindex] = colornow;
storyindex++;
count = 1;
//here we do some logic to check if their already exists a next
if(userstory[storyindex] != undefined){
var nextstorytext = userstory[storyindex];
colornow = storycolors[storyindex];
writestoryctn.attr("class",colornow +" w3-bar");
storytextarea.val(nextstorytext).attr("class",colornow +" w3-block w3-bar-item w3-animate-left w3-text-white w3-large");
}else{
colornow = "w3-purple";
writestoryctn.attr("class","w3-purple w3-bar");
storytextarea.val("").attr("class","w3-purple w3-block w3-bar-item w3-animate-left w3-text-white w3-large");
}
//console.log(userstory + " "+storycolors);
}
});
/*code for switching between slides ends here*/
//code to handle posting of story starts here
poststory.click(function() {
var storytitle,storytext;
storytext = storytextarea.val();
if (storytext != "") {
userstory[storyindex] = storytext;
storycolors[storyindex] = colornow;
storytitle= prompt("Would you like to give your story a title?","My first kiss");
if(storytitle == null){
storytitle = mood.val();
}
apoststory.hide();
pvisible.addClass("w3-hide");
phidden.removeClass("w3-hide");
poststory.attr("disabled",true);
}else{return;}
$.ajax({
url :"oaumeetupwritestory.php",
method : "post",
data :{story:userstory,colorpref:storycolors,mode:"nonsecret",title:storytitle,mood:mood.val()},
success : function(data) {
if (data.indexOf("success") > -1) {
alert("story posted");
storytextarea.val("");
userstory = [];
storycolors =[];
count = 1;
window.location = "oaumeetupdatingstories.php";
}else{
alert(data);
}
apoststory.show();
pvisible.removeClass("w3-hide");
phidden.addClass("w3-hide");
poststory.removeAttr("disabled");
},
error :function(xhr,status,err) {
alert("couldnot post story maybe due to bad network please try again");
apoststory.show();
pvisible.removeClass("w3-hide");
phidden.addClass("w3-hide");
poststory.removeAttr("disabled");
}
});
});



apoststory.click(function(){
var storytitle,storytext;
storytext = storytextarea.val();
if (storytext != "") {
userstory[storyindex] = storytext;
storycolors[storyindex] = colornow;
storytitle= prompt("Would you like to give your story a title?","My first kiss");
if(storytitle == null){
storytitle = mood.val();
}
poststory.hide();
apvisible.addClass("w3-hide");
aphidden.removeClass("w3-hide");
apoststory.attr("disabled",true);
}else{return;}
$.ajax({
url :"oaumeetupwritestory.php",
method : "post",
data :{story:userstory,colorpref:storycolors,mode:"secret",title:storytitle,mood:mood.val()},
success : function(data) {
if (data.indexOf("success") > -1) {
alert("story posted");
storytextarea.val("");
userstory = [];
storycolors =[];
count = 1;
window.location = "oaumeetupdatingstories.php";
}else{
alert(data);
}
poststory.show();
apvisible.removeClass("w3-hide");
apoststory.removeAttr("disabled");
aphidden.addClass("w3-hide");
},
error:function(xhr,status,err) {
alert("couldnot post story maybe due to bad network please try again");
apvisible.removeClass("w3-hide");
aphidden.addClass("w3-hide");
apoststory.removeAttr("disabled");
poststory.show();
}
});
});
//code to handle posting of story ends here

});
</script>
<!--script for javascript ends here-->
</body>
</html>