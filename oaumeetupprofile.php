<?php
require "classprofile.php";
$profile=$fontpref=$statusbtn=$username=$institution=$gender=$mpref=$uploadpicbtn=$editstatus=$uploadpicformctn=$secretpref="";
$profile = new profile();
if ($profile->validateUser() == "false") {
header("location:oaumeetuplogin.php");
exit();
}
$fontpref = $profile->getFont();
if(isset($_GET["uid"]) && !empty($_GET["uid"])){
$profile->setOwnerId($_GET["uid"]);
}else{$profile->setOwnerId($profile->getUserId());}
//To Prevent Redundancy Of Code
if(count($_POST) == 0 && empty($_FILES)){
$odetails = $profile->getProfileDetails();
$username = $odetails[1];
$institution = $odetails[2];
$gender = $odetails[3];
$profilepic = $odetails[4];
$bio = $odetails[5];
$lastlogin = $odetails[6];
$attr = $odetails[7];
$uid = $profile->getUserId();
$ownerid = $profile->getOwnerId();


//code To Check If Viewer Is Owner Of profile
if($ownerid ==  $uid){
$uploadpicbtn="<button id='uploadpic'class='w3-text-blue  w3-display-bottomright w3-round-large w3-hover-white w3-btn w3-hover-text-blue w3-card'style='margin-right:10px;margin-bottom:11px;margin-left:10px;'><i class='fa fa-camera'></i></button>";

$statusbtn = "<button id='editstatusbtn'class='w3-btn w3-blue w3-hover-white w3-hover-text-blue  w3-round-large w3-tiny'style='margin-bottom :5px;width:100px;'><i class='fa fa-pencil-square-o'></i> Edit</button>";
$editstatus ="<div id='editstatus' class='w3-hide'>
<textarea id='statusarea'class='w3-bar-item  w3-textarea w3-light-grey w3-text-blue'placeholder='Write something about you'style='width:100%;resize:none;padding:5px;border:0;border-color:white;height:70px;border-color:white;border-bottom:1px groove #2196F3;' minlength='3'maxlength='140'>$bio</textarea>
<div class='w3-bar-item w3-center'style='width:100%;margin-top:5px;'>
<button id='closeedit'class='w3-btn w3-card-4 w3-red w3-hover-text-red w3-hover-white w3-round-large w3-tiny'style='margin-bottom :5px;margin-top:10px;'><i class='fa fa-remove w3-large'></i></button>
<button id='poststatusbtn' class='w3-btn  w3-blue w3-hover-white w3-hover-text-blue  w3-round-large w3-tiny'style='margin-bottom :5px;margin-top:10px;'>
<span id='statusposttxt'><i class='fa fa-pencil-square-o'></i> Post</span>
<span id='statuspostprg'class='w3-hide'>
<i class='fa fa-spinner w3-spin'></i>
posting...
</span>
    </button> 
<span id='statuslen'class='w3-small'>4/140 </span>
</div>
</div>";

$uploadpicformctn ="<div id='uploadprofilepicctn'class='w3-hide'>
<form id='uploadprofilepicform' method='post' class=' w3-bar 'action ='oaumeetupprofile.php?uid=$ownerid'enctype='multipart/form-data'style='padding:0;'>
<input class='w3-bar-item 'type='file'name='uploadfile'id='uploadfile'style='width:60%;margin-top:8px;font-size:12px;'>
<input id='uploadbtn' class='w3-blue w3-btn w3-round-large w3-bar-item w3-tiny'type='submit'value='upload'style='width:30%;margin-top:8px;font-size:12px;'><br>
</form>
<!--Progress Bar-->
<div id='uploadpicprg'class='w3-grey w3-small w3-round w3-hide'style='width:80%;margin:auto;'><div id='uploadprgtxt' class='w3-blue w3-round 'style='width:0%;padding:4px;'>
0%
</div>
</div>
<!--progress Bar Ends Here-->
<span id='uploadprgtext'class='w3-text-blue w3-hide'style='margin:8px;'><b>Uploading...</b></span>
<button id='closeupload'class='w3-btn w3-card-4 w3-red w3-hover-text-red w3-hover-white w3-round-large w3-tiny'style='margin-bottom :5px;margin-top:10px;'><i class='fa fa-remove w3-large'></i></button>
</div>";

$mpref = $odetails[8];
if(!empty($mpref) && count($mpref) > 0){
}else{
$mpref = "<div class='w3-text-blue'><i class='fa fa-smile-o'></i> You have not setup your meetup preference yet</div>";
}

$secretpref ="<div class='w3-card-4 w3-panel w3-center w3-ripple w3-animate-zoom w3-center w3-round-large w3-light-grey w3-transparent'style='width:95%;margin-left:auto;margin-right: auto; margin-top:6px ;margin-bottom: 6px;'>
<span class='w3-text-red'style='font-family: $fontpref;'><i class='fa fa-expeditedssl w3-large'></i> Only you can see this</span>
<p class='w3-text-blue'style='width:100%;font-family: $fontpref;margin:2px;margin-bottom: 5px;'>
<img src='lovematch.png'class='w3-circle'style='width:40px;height:40px;'/> <b> Your Meetup Preference</b>
      </p>
      
$mpref  
<a class='w3-btn w3-blue w3-hover-blue w3-hover-text-white  w3-round-large w3-medium'style='margin :5px;'>
<img src='lovematch.png'class='w3-circle'style='width:30px;height:30px;'> Setup
</a>
</div>";

/*closing braces for if user is Owner of profile*/}else{
$profile->chatcreate();
$chatid = $profile->getChatId();
$achatid = $profile->getAChatId();
//checK FOr normal Chat
if($profile->chatexists == "true" && !empty($chatid)){
$statusbtn .="<a href='oaumeetupfchat.php?chatid=$chatid'class='w3-btn w3-blue w3-border w3-round-large w3-card w3-small'style='width:30%;text-decoration:none;'><img src='chaticon.png'style='width:20px;height:20px;text-decoration:none;'> Chat</a>";
}
//check For achat
if($profile->achatexists == "true" && !empty($achatid)){
$statusbtn .= "<a href='oaumeetupfchat.php?chatid=$achatid'class='w3-btn w3-blue w3-border w3-round-large w3-card w3-small'style='width:30%;text-decoration:none;'><img src='chathide.jpg'style='width:20px;height: 20px;text-decoration:none;'> AChat</a>";
}
	
}
}//Closing BracEs For If Not Isset Is Post

//Code To Handle posting OF status Starts Here
if(isset($_POST["statustxt"]) && $_POST["statustxt"] == "poststat"){
$status = $_POST["status"];
if(empty($status) || $status == ""){
echo "Your status is empty";
exit();
}
echo $statusupdate = $profile->updateStatus($status);
exit();
}

if(count($_FILES) > 0){
$name = $_FILES["uploadfile"]["name"];
$type = $_FILES["uploadfile"] ["type"];
 $tmploc = $_FILES["uploadfile"]["tmp_name"];
$size = $_FILES["uploadfile"]["size"];
$error = $_FILES["uploadfile"]["error"];
$target_dir = "uploads/";
$imagefiletype = pathinfo($name,PATHINFO_EXTENSION);
$dbfilename = $_SESSION["uname"].rand().".".$imagefiletype;
$targetfile = $target_dir.$dbfilename;
if(!$tmploc){
echo "<strong class='w3-bar-item w3-animate-zoom w3-text-red w3-padding-large'>please insert an image first</strong>";
exit();
}else if(!getimagesize($tmploc)){
echo "<strong class='w3-bar-item w3-animate-zoom w3-text-red w3-padding'>file is not an image</strong>";
exit();
}else if(!preg_match("/\.(jpg|jpeg|png)$/i",$name)){
echo "<strong class='w3-bar-item w3-animate-zoom w3-text-red w3-padding-large '>Sorrry file can only be a jpg jpeg or png</strong>";
exit();
}else if($size > 1048576){
echo "<strong class='w3-bar-item w3-animate-zoom w3-text-red w3-padding-large'>Sorry,File is larger than 1mb</strong>";
exit();
}else if(!is_uploaded_file($tmploc)){
echo "<strong class='w3-bar-item w3-animate-zoom w3-text-red w3-padding'>You did something wrong man!</strong>";
exit();
}else if($error === 1){
echo "<strong class='w3-bar-item w3-animate-zoom w3-text-red w3-padding-large'>An error occured while processing your file please try again!</strong>";
exit();
}else{
if(move_uploaded_file($tmploc,$targetfile)){ 
$dbsave = $profile->updateProfilePic($targetfile);
if($dbsave == "success"){
echo $targetfile."_^_success";
exit();
}else{
echo $dbsave;
exit();
}
}else{
echo "<strong class='w3-bar-item w3-animate-zoom w3-text-red w3-padding-large'>An error occured while uploading please try again</strong>";
exit();
}

}

}//end of pictire upload conditional statement


?>
<!DOCTYPE html>
<html>
<head>
<title>oaumeetup.com|Profile</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="author" content="Oausocial website">
<meta name="description" content=" social & meetup website">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0\css\font-awesome.css">
<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="jquery.form.min.js"></script>
<style type="text/css">
	#profileimg_ctn{
		background-image: url("bakground.jpeg");
		background-size: cover;
		width: 100%;
}

@media only screen and (max-width: 600px) {
		#profileimg_ctn{
			height: 200px;
		}
		#roundimg_ctn{
			height: 250px;
		}


    #profileimg{
	   width: 120px;
	   height: 120px;
       }
}
@media only screen and (min-width: 600px) {
		#profileimg_ctn{
			height: 200px;
		}

		#roundimg_ctn{
			height: 250px;
		}

		 #profileimg{
	   width: 120px;
	   height: 120px;
       }


}



@media only screen and (min-width: 768px) {
	#profileimg_ctn{
			height: 300px;
		}
       #roundimg_ctn{
			height: 350px;
		}
 #profileimg{
	   width: 150px;
	   height: 150px;
       }


}



@media only screen and (min-width: 992px) {
	#profileimg_ctn{
			height: 320px;
		}
		 #roundimg_ctn{
			height: 370px;
		}
		 #profileimg{
	   width: 150px;
	   height: 150px;
       }
}

@media only screen and (min-width: 1200px) {
 #profileimg_ctn{
			height: 320px;
		}
		 #roundimg_ctn{
			height: 370px;
		}

		 #profileimg{
	   width: 150px;
	   height: 150px;
       }
 }
</style>
</head>
<body class="w3-light-grey"style="width:100%;height:100%;font-family: <?php echo $fontpref;?>;">
<!--mainpage starts from here-->
<div class=""style="margin-bottom:60px;">
<!--Top section of profile page-->
<div id="roundimg_ctn" class="w3-display-container">
<div id="profileimg_ctn"class="w3-display-container w3-card">
<a href="<?php if(isset($_SERVER['HTTP_REFERER'])) echo htmlentities($_SERVER['HTTP_REFERER']); else echo("oaumeetupdatingstories.php");?>"style="text-decoration:none;"><i class="fa fa-arrow-left w3-text-blue w3-large w3-round-large w3-display-topleft w3-btn w3-hover-white w3-hover-text-blue w3-card"style="margin:10px;margin-left:11px;"></i></a>
<span class="w3-text-blue  w3-display-topmiddle w3-spin w3-hover-white w3-btn w3-round-large w3-hover-text-blue w3-card"style="margin:15px;margin-right:11px;font-family: <?php echo $fontpref;?>"><i class="fa fa-user"></i> <?php echo $username; ?></span>
<a href="oaumeetupsettings.html"><i class="fa fa-gear w3-text-blue w3-large w3-display-topright w3-hover-white w3-round-large  w3-btn w3-hover-text-blue w3-card"style="margin:10px;margin-right:11px;"></i></a>
<?php echo $uploadpicbtn;?>
</div>

<div class="w3-display-bottommiddle w3-display-container">
<a id='imagelink' href='<?php echo $profilepic;?>'style='text-decoration:none;'>
<img id="profileimg" src="<?php echo $profilepic?>" class="w3-circle w-display-bottommiddle w3-btn w3-card-4 w3-hover-white"style="border: 2px solid #2196F3;padding: 0;"></a>
<a id='imagedownloadlink'href="<?php echo $profilepic;?>"class="w3-display-bottommiddle w3-round-large w3-hover-text-blue w3-tiny w3-button w3-black w3-opacity"style="margin-bottom:8px;width:50%;" download="oaumeetup/<?php echo $profilepic;?>"><i class="fa fa-download"></i></a>
</div>

</div>
<!--Top section of profile page ends here-->
<!--other section starts here-->
<div class="w3-center">
<p id="uname"class="w3-text-blue" style="padding:0;width:100px;margin-left:auto;margin-right:auto;margin-top:6px;margin-bottom:0;"><i class="fa fa-user"></i> <?php echo $username;?></p>
</div>
<!--STATUS SECTION STARTS HERE-->
<div class="w3-center w3-text-blue w3-bar"style="margin-top:0;width:80%;margin-left: auto;margin-right:auto;padding:0;">
<!--display Status starts Here-->
<div id="displaystatus" class="">
<p id='displaystatustxt'class="w3-center"style="margin-top:0;margin-bottom:3px;width:100%;padding:5px;word-wrap:break-word;"><?php echo $bio;?></p>
<?php echo $statusbtn;?>
</div>
<!--display Status Ends Here-->

<!--edit status starts Here--> 
<?php echo $editstatus;?>
<!--editstatus Ends Here-->

<!--upload pic starts-->
<?php echo $uploadpicformctn;?>
<!--upload pic ends Here-->
</div>
<!--STATUS SECTION ENDS HERE-->
<!--LAST PART OF PROFILE GOES HERE-->
<div class="w3-container">
<div class="w3-card-4 w3-animate-zoom w3-ripple w3-padding-large w3-round-large w3-light-grey w3-transparent w3-animate-zoom"style="width:95%;margin-left:auto;margin-right: auto; margin-top:6px ;margin-bottom: 6px;">
<span class="w3-text-blue"style=""><i class="fa fa-<?php echo $gender;?>"></i> Gender ~</span>
<span class="w3-text- w3-right w3-text-blue"style=""><?php echo $gender;?></span>
</div>

<div class="w3-card-4  w3-ripple w3-padding-large w3-round-large w3-animate-zoom w3-light-grey w3-transparent w3-animate-zoom"style="width:95%;margin-left:auto;margin-right: auto; margin-top:6px ;margin-bottom: 6px;">
<span class="w3-text-blue"style=""><i class="fa fa-institution"></i> Institution ~</span>
<span class="w3-text- w3-right w3-text-blue"style=""><?php echo $institution;?></span>
</div>

<div class="w3-card-4 w3-animate-zoom w3-panel  w3-ripple w3-padding-large w3-round-large w3-light-grey w3-transparent w3-animate-zoom"style="width:95%;margin-left:auto;margin-right: auto; margin-top:6px ;margin-bottom: 6px;">
<span class="w3-text-blue"style=""><i class="fa fa-sort-amount-asc"></i> Height ~</span>
<span class="w3-text- w3-right w3-text-blue"style="">Medium</span>
</div>


<!--OWNER SEE ONLY MEETUP PREFERENCE STARTS HERE-->
<?php echo $secretpref;?>
<!--OWNER SEE ONLY MEETUP PREFERENCE ENDS HERE-->
</div>
<!--LAST PART OF PROFILE ENDS HERE-->
<div class="w3-card-4 w3-panel w3-cente w3-ripple w3-center w3-round-large w3-light-grey w3-transparent"style="width:95%;margin-left:auto;margin-right: auto; margin-top:6px ;margin-bottom: 6px;">
</div>
<!-- other section ends here-->
</div>
<!--mainpage ends here-->
<!--footer-->
<?php include_once "footer.php";?>
<!--footer-->
<!--javascript starts here-->
<script type="text/javascript">
$(function(){
var uploadpicbtn=displaystatus=len=editstatus=cedit=statusarea=profileimg=editstatusbtn=ro=poststatusbtn=statuslen=userid=displaystatustxt =statusposttxt=statuspostprg=uploadpicform=uploadpicctn=uploadfile=uploadpicprg=uploadprgtxt=uploadprgtext=uploadbtn=uploadpic=userid=imagelink=closeupload=imagedownloadlink="";
userid = "<?php echo $profile->getOwnerId();?>";
displaystatus = $("#displaystatus");
editstatus = $("#editstatus");
statusarea = $("#statusarea");
editstatusbtn = $("#editstatusbtn");
poststatusbtn = $("#poststatusbtn");
statuslen = $("#statuslen");
displaystatustxt = $("#displaystatustxt");
statusposttxt = $("#statusposttxt");
statuspostprg = $("#statuspostprg");
uname = $("#uname");
uploadpic = $("#uploadpic");
profileimg = $("#profileimg");
cedit = $("#closeedit");
closeupload = $("#closeupload");
uploadpicform = $("#uploadprofilepicform");
uploadpicctn = $("#uploadprofilepicctn");
uploadfile = $("#uploadfile");
uploadpicprg = $("#uploadpicprg");
uploadprgtxt = $("#uploadprgtxt");
uploadprgtext = $("#uploadprgtext");
uploadbtn = $("#uploadbtn");
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
ro = profileimg.offset().top;
imagelink = $("#imagelink");
imagedownloadlink = $("#imagedownloadlink");
/*alert(uploadpicform.html());
alert(uploadpicctn.html());
alert(uploadfile.attr("class"));
alert(uploadbtn.attr("class"));
alert(uploadprgtxt.html());
alert(uploadprgtext.html());
alert(uploadpicprg.html());*/

//To Open Edit Status
editstatusbtn.click(function(){
displaystatus.addClass("w3-hide");
uploadpicctn.addClass("w3-hide");
editstatus.removeClass("w3-hide");
uploadpic.attr("disabled",true);
statusarea.focus();
$(window).scrollTop(ro);
});

//to open upload form Starts Here
uploadpic.click(function(){
displaystatus.addClass("w3-hide");
editstatus.addClass("w3-hide");
uploadpicctn.removeClass("w3-hide");
});

//code to Handle Closing Of uploadpics Form starts Here
closeupload.click(function(){
uploadpicctn.addClass("w3-hide");
displaystatus.removeClass("w3-hide");
editstatus.addClass("w3-hide");
uploadpicprg.addClass("w3-hide");
uploadprgtext.removeClass("w3-hide");
uploadprgtxt.width("0%").removeClass("w3-red").removeClass("w3-green").addClass("w3-blue").html("0%");
uploadprgtext.removeClass("w3-text-red").removeClass("w3-text-green").addClass("w3-text-blue").html("<b>Uploading..</b>").addClass("w3-hide");
uploadbtn.removeAttr("disabled");
uploadfile.val("");
});

//Code To Handle Uploadig Of Pics Starts Here
uploadpicform.submit(function(e){
e.preventDefault();
if(uploadfile.val() != ""){
var filesize = document.getElementById("uploadfile").files[0].size;
if(filesize > 1097152){
alert("sorry File is Larger Than 1 Mb");
return;
}
$(this).ajaxSubmit({
beforeSubmit:function(){
uploadbtn.attr("disabled",true);
uploadpicprg.removeClass("w3-hide");
uploadprgtext.removeClass("w3-hide");
uploadprgtxt.width("0%").removeClass("w3-red").removeClass("w3-green").addClass("w3-blue").html("0%");
uploadprgtext.removeClass("w3-text-red").removeClass("w3-text-green").addClass("w3-text-blue").html("<b>Uploading..</b>");
},
uploadProgress:function(event,position,total,percentagecomplete){
/*uploadprgtxt.animate({
width : percentagecomplete+"%",
}
,"fast");*/
uploadprgtxt.width(percentagecomplete+"%").html(percentagecomplete+"%");
},
success:function(data){
if(data.indexOf("success") > -1){
var data = data.split("_^_");
profileimg.attr("src",data[0]);
imagelink.attr("href",data[0]);
imagedownloadlink.attr("href",data[0]);
imagedownloadlink.attr("download","oaumeetup/"+data[0]);
uploadprgtxt.removeClass("w3-blue").addClass("w3-green");
uploadprgtext.removeClass("w3-text-blue").addClass("w3-text-green").html("<b>Upload Complete</b>");
uploadbtn.removeAttr("disabled");
}else{
uploadprgtxt.removeClass("w3-blue").addClass("w3-red");
uploadprgtext.removeClass("w3-text-blue").addClass("w3-text-red").html("<b>"+data+"<b>");
uploadbtn.removeAttr("disabled");
}
},
error:function(xhr,status,err){
alert("could not connect to Server maybe due to bad Connection please try again");
uploadprgtxt.removeClass("w3-blue").addClass("w3-red");
uploadprgtext.removeClass("w3-text-blue").addClass("w3-text-red").html("<b>Failed</b>");
uploadbtn.removeAttr("disabled");
}
});
}
});
//code to Handle Uploading OF piics Ends Here 

//to close Edit Status And open display Status
cedit.click(function(){
displaystatus.removeClass("w3-hide");
editstatus.addClass("w3-hide");
uploadpicctn.addClass("w3-hide");
uploadpic.removeAttr("disabled");
});

  //post status btn for handling posting status
poststatusbtn.click(function(){
if(statusarea.val() !=""){
var stat = statusarea.val();
poststatusbtn.attr("disabled",true);
statusposttxt.addClass("w3-hide");
statuspostprg.removeClass("w3-hide");
$.ajax({
url : "oaumeetupprofile.php?uid="+userid,
method : "post",
data :{status:statusarea.val(),statustxt:"poststat"},
success:function(data){
    
if(data.indexOf("success") > -1){
statusarea.val(stat);
displaystatustxt.html(stat);
poststatusbtn.removeAttr("disabled");
displaystatus.removeClass("w3-hide");
editstatus.addClass("w3-hide");
statusposttxt.removeClass("w3-hide");
statuspostprg.addClass("w3-hide");
uploadpic.removeAttr("disabled");
}else{
alert(data);
statusposttxt.removeClass("w3-hide");
statuspostprg.addClass("w3-hide");
poststatusbtn.removeAttr("disabled");
}
}
,
error:function(xhr,status,err){
alert("Could not Connect to Server Maybe Due To Connection Issues please try again");
statusposttxt.removeClass("w3-hide");
statuspostprg.addClass("w3-hide");
poststatus.removeAttr("disabled");
}
});

}

});
statusarea.on({
click:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
$(window).scrollTop(ro);
},
hover:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
$(window).scrollTop(ro);
},
change:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
statusarea.focus();
$(window).scrollTop(ro);
},
mouseover:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
statusarea.focus();
$(window).scrollTop(ro);
},
mousedown:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
statusarea.focus();
$(window).scrollTop(ro);
},
mouseout:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
statusarea.focus();
$(window).scrollTop(ro);
},
keydown:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
statusarea.focus();
$(window).scrollTop(ro);
},
keypress:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
statusarea.focus();
$(window).scrollTop(ro);
},
keyup:function(){
len = statusarea.val().length;
statuslen.html(len+"/"+"140");
statusarea.focus();
$(window).scrollTop(ro);
}
});

});
</script>
<!--javascript ends here-->
</body>
</html>