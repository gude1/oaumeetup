<?php
require "classstorycomment.php";
$storyid=$storycmnt=$fontpref=$storyslide=$storytitle=$viewlist="";
$storycmnt = new storycomment();
if($storycmnt->validateUser() != "true"){
header("location:oaumeetuplogin.php");
exit();
}
if(isset($_GET["storyid"]) && !empty($_GET["storyid"])){
$fontpref =$storycmnt->getFont();
$storycmnt->setStoryId($_GET["storyid"]);
if(!isset($_POST["commentpost"])){
$storyslide = $storycmnt->getStory();
$storytitle = $storycmnt->getStoryTitle();
$viewlist = $storycmnt->getViewers($storycmnt->getViewer());
}
$storyid = $storycmnt->getStoryId();
$comments = $storycmnt->getComment($storyid);

if(isset($_POST["commentpost"])){
$comment = $_POST["commentpost"];
if(empty($comment) || $comment == ""){
echo "Comment is empty";
exit();
}
$comments = $storycmnt->insertComment($comment);
if($comments == "failed s"){
echo "failedes";
exit();
}else if($comments == "failed"){
echo "failed";
exit();
}else{
echo $comments."_^_".$storycmnt->getChangeId()."_^_".$storycmnt->getCommntNum();
exit();
}

}//if isset post


}
?>
<!DOCTYPE html>
<html>
<head>
<title>oaumeetup.com|comment views </title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content="social & meetup website">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
<body class=""style="font-family:<?php echo $fontpref;?>;">
<!--navbar starts here-->
<div class="w3-top">

<!--first part of navbar starts here-->
<div class="w3-bar w3-light-grey w3-card-4"style="padding: 0;">
<button  class="w3-btn w3-bar-item w3-round-large w3-center w3-text-blue w3-card w3-hover-blue w3-hover-text-white w3-transparent"style="margin:8px;margin-left:13px;"><i class="fa fa-arrow-left w3-large"></i></button>
<p class="w3-large w3-text-blue w3-bar-item w3-small"style="padding:0;margin:6px;margin-left:13px;width:70%;"><b><?php echo $storytitle;?></b></p>
</div>
<!--first part of navbar ends here-->	
</div>
<!--navbar ends here-->	
<!--mainpage starts here-->
<div style="margin-top:55px;margin-bottom: 70px;">
<!--slideshow/story content starts here-->
<div class="readstoryctn w3-display-container"style="">
<?php echo $storyslide;?>
<button onclick="preV()"class="w3-round-large back w3-display-left w3-btn w3-card-4 w3-text-blue w3-black w3-opacity w3-hover-white w3-hover-text-blue"style="margin:5px;"><i class="fa fa-angle-left w3-xlarge "></i></button>
<button onclick="nexT()" class="w3-round-large next w3-display-right w3-btn w3-text-blue w3-card-4 w3-black w3-opacity w3-hover-white w3-hover-text-blue"style="margin:5px;"><i class="fa fa-angle-right w3-xlarge"></i></button>
</div>
<!--slideshow/story content ends here-->
<!--COMMENT SECTION STARTS HERE padding:2px;border: 3px dashed #2196F3;-->
<ul id="commentctn" class="w3-ul w3-animate-left">
<?php echo $comments;?>
</ul>
<!--COMMENT SECTION ENDS HERE padding:2px;border: 3px dashed #2196F3;-->
<!--viewers section starts here-->
<ul id="viewerctn" class="w3-ul w3-hide w3-animate-left">
<?php echo $viewlist;?>	
</ul>
<!--viewers section ends here-->	
</div>
<!--mainpage ends here-->
<!--footer starts here-->
<form id="strycommentform"method="post"class="w3-bottom w3-bar w3-light-grey"style='width:100%;height:65px;padding:0;'action="oaumeetupstorycomments.php?storyid=<?php echo $storyid;?>">
<!--to make the text area act well make it a bar-item-->
<textarea  id="cmmntarea"class="w3-bar-item w3-textarea"placeholder="Write a comment"style="width:80%;word-wrap:break-word;resize: none;padding:5px;height:65px;border-color:white;border-bottom:1px groove #2196F3"></textarea>
<button id="cmmntbtn" class='w3-center  w3-bar-item w3-blue w3-btn w3-round-large w3-hover-white w3-hover-text-blue'style='height:50px;width:15%;padding:0;margin-top:5px;margin-left:5px;'><i class='fa fa-send'></i></button>
<span id="prgctn"class="w3-bar-item w3-right w3-text-blue w3-hide w3-animate-left"><i class="fa fa-spinner w3-spin"></i> <span id="prgtxt">posting..</span></span>
<span id="fprgctn"class="w3-bar-item w3-right w3-text-red w3-hide w3-animate-left"><i class="fa fa-exclamation-circle"></i> Could not post please try again</span>
</form>	
<!--footer starts here-->
<!---javascript-->
<script type="text/javascript">
var count=storyid=stories=length="";
count = 1;
storyid = "<?php echo $storyid;?>";
stories = $(".storycntent");
length = stories.length;	
$(function() {
var storyindex ="";
slideindex = $("#slideindex");
$(".storycntent:nth-child(1)").removeClass("w3-hide");
var cmmntform=cmmntid=cmmntctn=viewerctn=scbtn=numcmmnttxt=cmmntarea=showcmnt=showview=cmmntbtn=prgctn=prgtxt=fprgctn=nocmmnt="";
cmmntform = $("#strycommentform");
cmmntctn = $("#commentctn");
viewerctn = $("#viewerctn");
cmmntarea = $("#cmmntarea");
cmmntbtn = $("#cmmntbtn");
prgctn = $("#prgctn");
prgtxt = $("#prgtxt");
fprgctn = $("#fprgctn");
nocmmnt = $("#nocmmntctn");
scbtn = $("#scbtn");
showcmnt = $("#showcmnt");
showview = $("#showview");
numcmmnttxt = $("#numcmmnttxt");

cmmntbtn.click(function(e) {
e.preventDefault();
if(cmmntarea.val() != ""){
cmmntbtn.attr("disabled",true);
prgctn.removeClass("w3-hide");
fprgctn.addClass("w3-hide");
cmmntform.animate({height:"100px"});

$.ajax({
url : "oaumeetupstorycomments.php?storyid="+storyid,
method : "post",
data :{commentpost:cmmntarea.val()},
success:function(data) {
if(data.indexOf("failed") > -1){
cmmntbtn.removeAttr("disabled");
prgctn.addClass("w3-hide");
fprgctn.removeClass("w3-hide");
}else if (data.indexOf("failedes") > -1){
alert("Sorry your comment contains characters that are not accepted");
cmmntbtn.removeAttr("disabled");
prgctn.addClass("w3-hide");
fprgctn.addClass("w3-hide");
cmmntform.animate({height:"65px"});
}else{
var data = data.split("_^_");
cmmntctn.html(data[0]);
cmmntarea.val("");
numcmmnttxt.html(data[2]+"comments");
$(window).scrollTop($("#comment"+data[1]).offset().top);
nocmmnt.addClass("w3-hide");
cmmntbtn.removeAttr("disabled");
prgctn.addClass("w3-hide");
fprgctn.addClass("w3-hide");
cmmntform.animate({height:"65px"});
}
},
error:function(xhr,status,err) {
cmmntbtn.removeAttr("disabled");
prgctn.addClass("w3-hide");
fprgctn.removeClass("w3-hide");
}
});
}//if cmment.val() !=""
});

/*code to handle switching between comment and viewers starts here*/
showcmnt.click(function() {
//alert(viewerctn.html());
cmmntctn.removeClass("w3-hide");
viewerctn.addClass("w3-hide");
});

showview.click(function(){
//alert(commentctn.html());	
cmmntctn.addClass("w3-hide");
viewerctn.removeClass("w3-hide");
});
/*code to handle switching between comment and viewers ends here*/

//function to handle focusing of textarea
scbtn.click(function() {
cmmntarea.focus();
});


});

function preV() {
//here we check if the index is less than one
if(count < 1){
count = 1;
}else if(count == 1){
//here we check if the index is equal to one
count = count;
}else{
--count;
stories.addClass("w3-hide");
$(".storycntent:nth-child("+count+")").removeClass("w3-hide");
slideindex.html(count+"/"+length);
}	
}

function nexT() {
if (count < length) {
++count;	
}else if (count >= length) {
count = 1;
}
stories.addClass("w3-hide");
$(".storycntent:nth-child("+count+")").removeClass("w3-hide");
slideindex.html(count+"/"+length);
}

//share functionality coming up soon
function sharE(data) {

}
</script>
<!--javascript-->
</body>
</html>