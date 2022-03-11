<?php
session_start();
require_once "classfchat.php";
$fonttype=$chat=$chatid=$msgchat=$scrollid="";
$chat = new fchat();
if ($chat->validateUser() == "false") {
header("location:oaumeetuplogin.php");
exit();
}
$fonttype = $chat->getFont();

if(isset($_GET["chatid"])){
$gchatid = $_GET["chatid"];
$chat->confirmChat($gchatid);
$getchat = $chat->getChat();
if(!empty($getchat) && $getchat !="")
{
$msgchat = $getchat[0];
$scrollid = $getchat[1];
}
}

//code to handle inserting of textchat starts here
if(isset($_POST["chatm"])){
$mechat =$_POST['chat'];
if(empty($mechat) && $mechat == ''){
echo 'chat is empty';
exit();
}
echo $insertchat = $chat->insertChat($mechat);
exit();
}
//code to handle inserting of text chat ends here

//code to Handle Updating of Chat Starts Here
if(isset($_POST["updatechat"]) && $_POST["updatechat"] == "update"){
echo $chat->updateChat();
exit();
}
//code to handle updating Of chat Ends Here


?>

<!DOCTYPE html>
<html>
<head>
<title>oaumeetup.com|chat</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content=" social & meetup website friendchat ">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="jquery.form.min.js"></script>
<script type="text/javascript" src="lazysizemin.js"></script>

<!---<script type="text/javascript"src='jquery.scrollTo.min.js'></script>-->
<style type="text/css">
@media only screen and (max-width: 600px) {
#chatarea{
width:70%;
}
#callphoto{
margin-right:12px;
}
}
@media only screen and (min-width: 600px) {
#chatarea{
width:80%;
}
#callphoto{
margin-right:0px;
}
}

@media only screen and (min-width: 768px) {
#chatarea{
width:80%;
}
#callphoto{
margin-right:0px;
}
	
}

@media only screen and (min-width: 992px) {
#chatarea{
width:80%;
}
#callphoto{
margin-right:0px;
}
}

@media only screen and (min-width: 1200px) {
#chatarea{
width:80%;
}
#callphoto{
margin-right:0px;
}
 }
</style>

</head>
<body class='w3-light-grey'style="font-family:<?php echo $fonttype;?>">
<!--navbar starts here-->
<div class="w3-top">
<div class="w3-bar w3-blue w3-card w3-padding">
<button class="w3-btn w3-card-4 w3-bar-item w3-text-white w3-hover-white w3-hover-text-blue w3-round-large w3-small"style="width:40px;height:40px;"><i class="fa fa-arrow-left"></i></button> 
<img src="elisco.jpg" class="w3-circle w3-bar-item w3-card-4"style="width:40px;height:40px;border:2px dotted #fff;margin-left:10px;margin-right:5px;padding: 0;">
<div class="w3-bar-item w3-text-white w3-bold"style="padding: 0;"><span class="w3-block"style="padding:0;">
@Marlians</span>
<span class="w3-tiny"style="margin:0px;padding:0;">
Last seen Mon @ 2:30pm</span>
</div>
 <button class="w3-btn w3-card-4 w3-bar-item w3-text-white w3-hover-white w3-right w3-hover-text-blue w3-round-large"style="width:40px;height:40px;"><i class="fa fa-ellipsis-v"></i></button> 
</div>
</div>
<!--navbar ends here-->

<!--Mainpage starts here-->
<div class=''style="margin-top:75px; margin-bottom: 100px;">
<div id='chatcontainer' class=''style="height:80%; width:100%;overflow-y: auto;"> 
<!--chat Mmmessages starts here-->
<?php echo $msgchat;?>
<!--chat messages ends here-->
<div id='scrollto'></div>
</div>
</div>
<!--Mainpage ends here-->
<!--footer-->
<div id='footer'class="w3-bottom w3-bar w3-light-grey"style='width:100%;height:75px;'>
<textarea id='chatarea' class=" w3-bar-item  w3-round-xxlarge w3-padding w3-light-grey"placeholder="Share your feelings with @Marlians"style="word-wrap:break-word;resize: none;padding:5px;height:65px;border:1px groove #2196F3;margin-bottom:4px;margin-top:5px;"></textarea>
 <label for='chatsphoto'>
<i id='callphoto'class='fa fa-camera-retro w3-bar-item w3-text-blue w3-xxlarge  w3-hover-text-green'style=' margin-top:15px;padding:0;width:10%;margin-left:9px;'></i>
 </label>
<button id='chatbtn'class='w3-bar-item w3-light-grey w3-text-blue  w3-hover-text-green'
style=' margin-top:15px;padding:0;width:10%margin-left:0;'>
<i class='fa fa-send  w3-xxlarge'></i>
</button>
<input class='w3-hide'id='chatsphoto'type='file'/>
</div>
<!--footer-->
<!--javascript-->
<script type='text/javascript'>
$(function(){
var origscrollid ="<?php echo $scrollid;?>";
//alert(origscrollid);
if(origscrollid != ""){
$(window).scrollTop($("#"+origscrollid).offset().top);
}
/*$("#chatcontainer").animate({
        scrollTop: $("#"+origscrollid).offset().top
    }, 100)*/
var  filephoto =chatarea=chatbtn=chatctn=lastinsertid="";
filephoto = $("#chatsphoto");
chatbtn = $("#chatbtn");
chatarea = $("#chatarea");
chatctn = $("#chatcontainer");
lastinsertid =origscrollid;

//function to send chat starts here
chatbtn.click(function(){
var text = chatarea.val();
//text area not empty run ajax
if(text != ""){
chatarea.val("");
var id = "coolBlow"+parseInt(Math.random());

chatctn.append("<div id ="+id+" class='w3-panel'style='padding:0;margin:0;'><div class='w3-right w3-card msg_txt w3-blue w3-padding w3-animate w3-ripple w3-animate-zoom w3-medium'style='max-width:250px;word-wrap: break-word;border-radius:15px 50px 30px;margin: 5px;font-size:16px;'><p style='margin:2px;'>"+text+"</p><p class='w3-tiny w3-left'style='margin:0;margin-left:5px;margin-right:10px;'>time loading...</p><span class='w3-tiny w3-right'><i class='fa fa-spinner w3-spin'></i>sending...</span></div></div>");
$(window).scrollTop(chatctn.prop( "scrollHeight" ));

$.ajax({
url : "oaumeetupfchat.php",
method :"post",
data:{chatm:"in",chat:text},
success:function(data){
if(data.indexOf("Failed") > -1){
alert(data);
}else{
var a = data.split("®®®");
var arr = a[0];
//alert(data);
if(arr != ""){
var arr = arr.split("©©©");
for(i = 0;i < arr.length;i++){
if($("#"+arr[i]).length > 0){
$("#isseen"+arr[i]).html("seen");
}//if
}//for Loop
}//iF Not Empty
$("#"+id).remove();
chatctn.append(a[1]);
$(window).scrollTop($("#"+a[2]).offset().top);
lastinsertid = a[2];
}//closing else statement

},
error:function(xhr,status,err){
alert("couldnot connect to server maybe due to bad connection");
$("#"+id).remove();
}
});
}
});

//To Handle Scrolling When Chat area Is Typing
chatarea.on({
click:function(){
$(window).scrollTop(chatctn.prop( "scrollHeight" ));
},
change:function(){
$(window).scrollTop(chatctn.prop( "scrollHeight" ));
},
hover:function(){
$(window).scrollTop(chatctn.prop( "scrollHeight" ));
},
keydown:function(){
$(window).scrollTop(chatctn.prop( "scrollHeight" ));
}
});
//code  to handle upload of file

//sending of chatphoto to partner starts here
filephoto.change(function(){
$(this).ajaxSubmit({
beforeSubmit:function(){
}
});
});
//sending of Chatphoto To partner Ends Here
});

function updateChat(){
$.ajax({
url : "oaumeetupfchat.php",
method : "post",
data :{updatechat:"update"},
success:function(data){
if(data.indexOf("Failed") > -1 || data == ""){
/*alert("cool");
alert(data);*/
}else{
//alert(data);
var a = data.split("®®®");
var arr = a[0];
//alert(data);
if(arr != ""){
var arr = arr.split("©©©");
for(i = 0;i < arr.length;i++){
if($("#"+arr[i]).length > 0){
$("#isseen"+arr[i]).html("seen");
}//if
}//for Loop
}//iF Not Empty
if(a[1] != "" && a[2] != ""){
chatctn.append(a[1]);
$(window).scrollTop($("#"+a[2]).offset().top);
lastinsertid = a[2];
}
}
},
error:function(xhr,status,err){
console.log(xhr);
}
});
}

setInterval(updateChat,5000);

</script>
<!--javascript-->
</body>
</html>